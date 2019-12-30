<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comission extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")=="admin_spk") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->helper(array("enc_gue","backend","tanggal_indonesia","balance"));
    $this->load->library(array('template','btree'));
    $this->load->model("Setting_financial_model","model");
  }

  function test()
  {
      $waktu = date("Y-m-d");
    $data_insert = array('nama' => "ini contoh curl $waktu");
    $this->model->get_insert("contoh",$data_insert);
    return true;
  }


  function wget()
  {
      $waktu = date("Y-m-d");
    $data_insert = array('nama' => "ini contoh wget $waktu");
    $this->model->get_insert("contoh",$data_insert);
    return true;

  }

  function get()
  {

    $waktu = date("Y-m-d");
    $tgl = date("d",strtotime($waktu));
      if ($tgl=="01" OR $tgl=="15") {


        $qry = $this->db->select("investment_profit.id_invest_profit,
                                  investment_profit.id_invest,
                                  investment_profit.no_profit,
                                  investment_profit.time_profit,
                                  investment_profit.name_profit,
                                  investment.kode_invest,
                                  investment_profit.amount_profit,
                                  investment.id_person,
                                  tb_person.is_active")
                        ->from("investment_profit")
                        ->join("investment","investment.id_invest = investment_profit.id_invest")
                        ->join("tb_person","tb_person.id_person = investment.id_person")
                        ->where("investment_profit.time_profit", "$waktu")
                        ->where("investment_profit.amount_profit", null)
                        ->where("tb_person.is_active", "1")
                        ->get();


        foreach ($qry->result() as $row) {
          $amount_invest = cek_invest($row->id_invest,"amount");

          $profit = ($amount_invest/100)*setting_financial("invesment_royalti");

          $this->model->get_update("investment_profit",["amount_profit" => $profit]
                                  ,[
                                    "id_invest_profit" => $row->id_invest_profit,
                                    "id_invest" => $row->id_invest,
                                    "time_profit" => $row->time_profit
                                  ]);


          // hitung komisi parent
          // ambil id investment
          $pemilik_invest = cek_invest($row->id_invest,"id_person");
          // cek semua parent
          $parent = is_parent($pemilik_invest);
          if (count($parent)!=0) {
            if (profile_person($pemilik_invest,"id_level")==4) {

                // agency
                $agency = $parent[0];
                $agency_level = profile_person($agency,"id_level");
                $agency_comission = level_person($agency_level,"comission");
                $omset = omset($this->btree->get_all_id_children($agency));
                if ($omset>=1000000 AND $omset<=499000000) {
                  $omset_agency = 2;
                }elseif ($omset>=500000000 AND $omset<=1999000000) {
                  $omset_agency = 3;
                }elseif ($omset>=2000000000) {
                  $omset_agency = 4;
                }
                $dividen_agency = ($amount_invest/100)*$omset_agency;
                // end agency


                //co founder
                $cofounder = $parent[1];
                $cofounder_level = profile_person($cofounder,"id_level");
                $cofounder_comission = level_person($cofounder_level,"comission");
                $omset_cofounder = abs($cofounder_comission-$omset_agency);
                $dividen_cofounder = ($amount_invest/100)*$omset_cofounder;
                // end cofounder

                // founder
                $founder = $parent[2];
                $founder_level = profile_person($founder,"id_level");
                $founder_comission = level_person($founder_level,"comission");
                $dividen_founder = ($amount_invest/100)*1;
                //end founder


                $data_komisi = [
                                  [
                                    "id_invest"=>$row->id_invest,
                                    "id_person" =>$agency,
                                    "persentase" => $omset_agency,
                                    "amount" => $dividen_agency,
                                    "no_dividen" => $row->no_profit,
                                    "time_dividen" => $row->time_profit
                                  ],
                                  [
                                    "id_invest"=>$row->id_invest,
                                    "id_person" =>$cofounder,
                                    "persentase" => $omset_cofounder,
                                    "amount" => $dividen_cofounder,
                                    "no_dividen" => $row->no_profit,
                                    "time_dividen" => $row->time_profit
                                  ],
                                  [
                                    "id_invest"=>$row->id_invest,
                                    "id_person" =>$founder,
                                    "persentase" => 1,
                                    "amount" => $dividen_founder,
                                    "no_dividen" => $row->no_profit,
                                    "time_dividen" => $row->time_profit
                                  ]
                                ];
            }elseif (profile_person($pemilik_invest,"id_level")==3) {
              //co founder
              $cofounder = $parent[0];
              $cofounder_level = profile_person($cofounder,"id_level");
              $cofounder_comission = level_person($cofounder_level,"comission");
              $dividen_cofounder = ($amount_invest/100)*$cofounder_comission;
              // end cofounder

              // founder
              $founder = $parent[1];
              $founder_level = profile_person($founder,"id_level");
              $founder_comission = level_person($founder_level,"comission");
              $dividen_founder = ($amount_invest/100)*1;
              //end founder
              $data_komisi = [
                                [
                                  "id_invest"=>$row->id_invest,
                                  "id_person" =>$cofounder,
                                  "persentase" => $cofounder_comission,
                                  "amount" => $dividen_cofounder,
                                  "no_dividen" => $row->no_profit,
                                  "time_dividen" => $row->time_profit
                                ],
                                [
                                  "id_invest"=>$row->id_invest,
                                  "id_person" =>$founder,
                                  "persentase" => 1,
                                  "amount" => $dividen_founder,
                                  "no_dividen" => $row->no_profit,
                                  "time_dividen" => $row->time_profit
                                ]
                              ];
            }elseif (profile_person($pemilik_invest,"id_level")==2) {
              // founder
              $founder = $parent[0];
              $founder_level = profile_person($founder,"id_level");
              $founder_comission = level_person($founder_level,"comission");
              $dividen_founder = ($amount_invest/100)*$founder_comission;
              //end founder
              $data_komisi = [
                                [
                                  "id_invest"=>$row->id_invest,
                                  "id_person" =>$founder,
                                  "persentase" => $founder_comission,
                                  "amount" => $dividen_founder,
                                  "no_dividen" => $row->no_profit,
                                  "time_dividen" => $row->time_profit
                                ]
                              ];
            }
            $this->db->insert_batch("investment_dividen",$data_komisi);
          }


          if ($row->no_profit==6) {
              $this->model->get_update("investment",["status"=>"done"],["id_invest"=>$row->id_invest]);
          }

        }



      }else{
        echo "gagal";
      }




}

}
