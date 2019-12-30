<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_financial extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")!="superadmin") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model("Setting_financial_model","model");
  }

  function index()
  {
    $this->template->set_title('Financial');
    $this->template->view('content/setting_financial/index',array());
  }

  function action_deposit()
  {
    if ($this->input->is_ajax_request()) {
            $json = array('success'=>false, 'alert'=>array());
            $this->form_validation->set_rules("deposit_min","&nbsp;*","trim|xss_clean|required");
            $this->form_validation->set_rules("deposit_max","*&nbsp;","trim|xss_clean|required");
            $this->form_validation->set_rules("deposit_status","*&nbsp;","trim|xss_clean|required");
            $this->form_validation->set_error_delimiters('<span class="error ml-1 text-danger" style="font-size:11px">','</span>');
            if ($this->form_validation->run()) {

              $data = [
                         "deposit_min"  => replace_rupiah($this->input->post('deposit_min')),
                         "deposit_max"  => replace_rupiah($this->input->post('deposit_max')),
                         "deposit_status"       => $this->input->post("deposit_status"),
                    ];

              $this->model->get_update("setting_financial",$data,["id_financial"=>999]);

              $json['alert'] = "update successfully";
              $json['success'] =  true;
            }else {
              foreach ($_POST as $key => $value)
                {
                  $json['alert'][$key] = form_error($key);
                }
            }

            echo json_encode($json);
    }
  }



  function action_withdraw()
  {
    if ($this->input->is_ajax_request()) {
            $json = array('success'=>false, 'alert'=>array());
            $this->form_validation->set_rules("withdraw_min","&nbsp;*","trim|xss_clean|required");
            $this->form_validation->set_rules("withdraw_max","*&nbsp;","trim|xss_clean|required");
            $this->form_validation->set_rules("withdraw_status","*&nbsp;","trim|xss_clean|required");
            $this->form_validation->set_error_delimiters('<span class="error ml-1 text-danger" style="font-size:11px">','</span>');
            if ($this->form_validation->run()) {

              $data = [
                         "withdraw_min"     => replace_rupiah($this->input->post('withdraw_min')),
                         "withdraw_max"     => replace_rupiah($this->input->post('withdraw_max')),
                         "withdraw_status"  => $this->input->post("withdraw_status"),
                    ];

              $this->model->get_update("setting_financial",$data,["id_financial"=>999]);

              $json['alert'] = "update successfully";
              $json['success'] =  true;
            }else {
              foreach ($_POST as $key => $value)
                {
                  $json['alert'][$key] = form_error($key);
                }
            }

            echo json_encode($json);
    }
  }


  function action_invesment()
  {
    if ($this->input->is_ajax_request()) {
            $json = array('success'=>false, 'alert'=>array());
            $this->form_validation->set_rules("biaya_admin","&nbsp;*","trim|xss_clean|required");
            $this->form_validation->set_rules("invesment_min","&nbsp;*","trim|xss_clean|required");
            $this->form_validation->set_rules("invesment_max","*&nbsp;","trim|xss_clean|required");
            $this->form_validation->set_rules("invesment_royalti","*&nbsp;","trim|xss_clean|required|numeric");
            $this->form_validation->set_rules("invesment_kontrak","*&nbsp;","trim|xss_clean|required|numeric");
            $this->form_validation->set_rules("invesment_profit","*&nbsp;","trim|xss_clean|required|numeric");
            $this->form_validation->set_rules("invesment_status","*&nbsp;","trim|xss_clean|required");
            $this->form_validation->set_error_delimiters('<span class="error ml-1 text-danger" style="font-size:11px">','</span>');
            if ($this->form_validation->run()) {

              $data = [  "biaya_admin"     => replace_rupiah($this->input->post('biaya_admin')),
                         "invesment_min"     => replace_rupiah($this->input->post('invesment_min')),
                         "invesment_max"     => replace_rupiah($this->input->post('invesment_max')),
                         "invesment_kontrak"  => $this->input->post("invesment_kontrak"),
                         "invesment_royalti"  => $this->input->post("invesment_royalti"),
                         "invesment_profit"  => $this->input->post("invesment_profit"),
                         "invesment_status"  => $this->input->post("invesment_status"),
                    ];

              $this->model->get_update("setting_financial",$data,["id_financial"=>999]);

              $json['alert'] = "update successfully";
              $json['success'] =  true;
            }else {
              foreach ($_POST as $key => $value)
                {
                  $json['alert'][$key] = form_error($key);
                }
            }

            echo json_encode($json);
    }
  }


  function action_comission()
  {
    if ($this->input->is_ajax_request()) {
            $json = array('success'=>false, 'alert'=>array());
            $this->form_validation->set_rules("founder","*&nbsp;","trim|xss_clean|required|numeric");
            $this->form_validation->set_rules("cofounder","*&nbsp;","trim|xss_clean|required|numeric");
            $this->form_validation->set_rules("agency","*&nbsp;","trim|xss_clean|required|numeric");
            $this->form_validation->set_error_delimiters('<span class="error ml-1 text-danger" style="font-size:11px">','</span>');
            if ($this->form_validation->run()) {

              // $data = [
              //            "invesment_min"     => replace_rupiah($this->input->post('invesment_min')),
              //            "invesment_max"     => replace_rupiah($this->input->post('invesment_max')),
              //            "invesment_kontrak"  => $this->input->post("invesment_kontrak"),
              //       ];
              //
              $this->model->get_update("level_person",["comission"=>$this->input->post("founder")],["id_level"=>1]);

              $this->model->get_update("level_person",["comission"=>$this->input->post("cofounder")],["id_level"=>2]);

              // $this->model->get_update("level_person",["comission"=>$this->input->post("agency")],["id_level"=>3]);

              $json['alert'] = "update successfully";
              $json['success'] =  true;
            }else {
              foreach ($_POST as $key => $value)
                {
                  $json['alert'][$key] = form_error($key);
                }
            }

            echo json_encode($json);
    }
  }


  function testing_comission()
  {
      if ($this->input->is_ajax_request()) {
              $json = array('success'=>false, 'alert'=>array());
              $this->form_validation->set_rules("tanggal","&nbsp;*","trim|xss_clean|required");
              $this->form_validation->set_error_delimiters('<span class="error ml-1 text-danger" style="font-size:11px">','</span>');
              if ($this->form_validation->run()) {
                $waktu = $this->input->post("tanggal");
                $tgl = date("d",strtotime($waktu));
                  if ($tgl=="01" OR $tgl=="15") {


                    $qry = $this->db->get_where("investment_profit",[
                                                "time_profit" => "$waktu",
                                                "amount_profit" => null
                                              ]);

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


                    $json["alert_header"] = "success";
                    $json['alert'] = "testing successfully";
                  }else {
                    $json["alert_header"] = "error";
                    $json['alert'] = "Testing Error";
                  }
                $json['success'] =  true;
              }else {
                foreach ($_POST as $key => $value)
                  {
                    $json['alert'][$key] = form_error($key);
                  }
              }
              echo json_encode($json);
      }
  }


  // function testing_comission()
  // {
  //     if ($this->input->is_ajax_request()) {
  //             $json = array('success'=>false, 'alert'=>array());
  //             $this->form_validation->set_rules("tanggal","&nbsp;*","trim|xss_clean|required");
  //             $this->form_validation->set_error_delimiters('<span class="error ml-1 text-danger" style="font-size:11px">','</span>');
  //             if ($this->form_validation->run()) {
  //               $waktu = $this->input->post("tanggal");
  //               $tgl = date("d",strtotime($waktu));
  //                 if ($tgl=="01" OR $tgl=="15") {
  //
  //
  //                   $qry = $this->db->get_where("investment_profit",[
  //                                               "time_profit" => "$waktu",
  //                                               "amount_profit" => null
  //                                             ]);
  //
  //                   foreach ($qry->result() as $row) {
  //                     $amount_invest = cek_invest($row->id_invest,"amount");
  //
  //                     $profit = ($amount_invest/100)*setting_financial("invesment_royalti");
  //
  //                     $this->model->get_update("investment_profit",["amount_profit" => $profit]
  //                                             ,[
  //                                               "id_invest_profit" => $row->id_invest_profit,
  //                                               "id_invest" => $row->id_invest,
  //                                               "time_profit" => $row->time_profit
  //                                             ]);
  //
  //
  //                     // hitung komisi parent
  //                     // ambil id investment
  //                     $pemilik_invest = cek_invest($row->id_invest,"id_person");
  //                     // cek semua parent
  //                     $cek_parent = is_parent($pemilik_invest);
  //
  //                     foreach ($cek_parent as $id_person) {
  //                       $this->_insert_comission($id_person, $row->id_invest,$row->no_profit,$row->time_profit);
  //                     }
  //                     //unset komisi
  //                     $this->session->unset_userdata('sess_comission');
  //
  //                     if ($row->no_profit==6) {
  //                         $this->model->get_update("investment",["status"=>"done"],["id_invest"=>$row->id_invest]);
  //                     }
  //                   }
  //
  //
  //                   $json["alert_header"] = "success";
  //                   $json['alert'] = "testing successfully";
  //                 }else {
  //                   $json["alert_header"] = "error";
  //                   $json['alert'] = "Testing Error";
  //                 }
  //               $json['success'] =  true;
  //             }else {
  //               foreach ($_POST as $key => $value)
  //                 {
  //                   $json['alert'][$key] = form_error($key);
  //                 }
  //             }
  //             echo json_encode($json);
  //     }
  // }


  // function _insert_comission($id_person, $id_invest, $no, $time)
  // {
  //   $amount_invest = cek_invest($id_invest,"amount");
  //
  //   $comission_id_person = profile_person($id_person,"comission");
  //
  //   $sess_comission = $this->session->flashdata("sess_comission");
  //   $cek_session_comission = ($sess_comission=="") ? 0 : $sess_comission;
  //   $hitung_comission = $comission_id_person - $cek_session_comission;
  //
  //
  //       $dividen = ($amount_invest/100)*$hitung_comission;
  //
  //       $data_komisi = ["id_invest"=>$id_invest,
  //                       "id_person" =>$id_person,
  //                       "persentase" => $hitung_comission,
  //                       "amount" => $dividen,
  //                       "no_dividen" => $no,
  //                       "time_dividen" => $time
  //                       ];
  //       $this->model->get_insert("investment_dividen",$data_komisi);
  //
  //
  //       $this->session->set_flashdata("sess_comission",$comission_id_person);
  //
  //
  //   return;
  // }




}
