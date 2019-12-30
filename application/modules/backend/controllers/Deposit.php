<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")=="admin_spk") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model("Deposit_model","model");
  }

  function get($status)
  {
    $this->template->set_title('Deposit');
    $this->template->view('content/deposit/index',["status"=>$status]);
  }


  function json($status="")
  {
    if ($this->input->is_ajax_request()) {
      $list = $this->model->get_datatables($status);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $rows) {
          if ($rows->status =="approved") {
            $statuss = '<span class="badge badge-success">approved</span>';
          }

          if ($rows->status =="process") {
            $statuss = '<span class="badge badge-warning text-white">process</span>';
          }
          if ($rows->status =="cancel") {
            $statuss = '<span class="badge badge-danger">cancel</span>';
          }

          $row = array();
          $row[] = '<span class="text-primary">'.$rows->kode_transaksi.'</span>';
          $row[] = date("d/m/Y H:i",strtotime($rows->created));
          $row[] = "<label class='text-primary' style='font-size:14px;'>".$rows->kode_person." </label><br><label style='font-size:14px;'> ".$rows->nama." **<span class='text-success'>".$rows->username."</span></label><br><label style='font-size:14px;'> ".$rows->telepon1."</label>";
          $row[] = "Rp.".format_rupiah(($rows->amount+$rows->biaya_admin));
          $row[] = $statuss;


          $row[] = '
                    <a href="'.site_url("backend/deposit/detail/".$status."/".enc_uri($rows->id_deposit)).'" class="badge badge-success" id="rst_pwd" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="DETAIL"><i class="ti-zoom-in"></i></a>
                   ';

          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->model->count_all($status),
                      "recordsFiltered" => $this->model->count_filtered($status),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
    }
  }


  function detail($status="",$id="")
  {
    if ($row = $this->model->get_where_detail($status,$id)) {
      $this->template->set_title("Deposit");
      $data['status'] = ucfirst($status);
      $data['row'] = $row;
      $this->template->view("content/deposit/detail",$data);
    }
  }


  function status_action($status="",$id="")
    {
      if ($this->input->is_ajax_request()) {
        if ($status=="process") {

              $json = array('success'=>false, 'alert'=>array(), 'url'=>array());
              $this->form_validation->set_rules("amount","&nbsp;*","trim|xss_clean|required");
              $this->form_validation->set_rules("status","*&nbsp;","trim|xss_clean|required");
              $this->form_validation->set_rules("keterangan","*&nbsp;","trim|xss_clean");
              $this->form_validation->set_rules("id_person","*&nbsp;","trim|xss_clean|numeric|required");
              $this->form_validation->set_rules("password","*&nbsp;","trim|xss_clean|required|callback__cek_password");
              $this->form_validation->set_error_delimiters('<span class="error ml-1 text-danger" style="font-size:11px">','</span>');
              if ($this->form_validation->run()) {

                $amount = replace_rupiah($this->input->post("amount"));



              if ($this->input->post("status")=="cancel") {
                    $keterangan = $this->input->post("keterangan");
                  }else {
                    $ket = [  "approved_by" => "admin",
                              "id_admin"  => sess("id_admin"),
                              "time_approved" => date("Y-m-d H:i:s"),
                              "keteragan" => $this->input->post("status")
                            ];
                      $keterangan = json_encode($ket);
                  }

                $data = [
                           "amount_acc"   => $amount,
                           "status"       => $this->input->post("status"),
                           "keterangan"   => $keterangan
                      ];

                $this->model->get_update("deposit",$data,["id_deposit"=>dec_uri($id)]);


                $json['alert'] = $this->input->post("status")." successfully";
                $json['success'] =  true;
                if ($this->input->post("status")=="approved") {
                  $json['url'] =  site_url("backend/deposit/get/approved");
                }else {
                  $json['url'] =  site_url("backend/deposit/get/process");
                }
              }else {
                foreach ($_POST as $key => $value)
                  {
                    $json['alert'][$key] = form_error($key);
                  }
              }

              echo json_encode($json);
        }
      }
    }


    function export($status="")
    {
      $data['status'] =$status;
      $this->load->view("content/deposit/export",$data);
    }

}
