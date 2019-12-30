<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Founder extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")=="admin_spk") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model("Founder_model","model");
  }

  function index()
  {
    $this->template->set_title("Founder");
    $this->template->view("content/founder/index");
  }



  function json()
  {
    if ($this->input->is_ajax_request()) {
      $list = $this->model->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $rows) {
          $no++;
          $row = array();
          $row[] = $no;
          $row[] = $rows->kode_person;
          $row[] = '<span class="data-person"><i class="ti-id-badge"></i> '.$rows->nik.'</span>
                    <span class="data-person"><i class="ti-user"></i> '.$rows->nama.' [ <label class="text-success">'.$rows->username.'</label> ]</span>
                    <span class="data-person"><i class="ti-email"></i> '.$rows->email.'</span>
                    ';

          $row[] = ($rows->is_active=="1") ? '<span class="badge badge-success"> Aktif</span>':'<span class="badge badge-danger">Tidak Aktif</span>';

          if (profile_admin("level")=="admin_supervisor") {
            $row[] = '<a href="'.site_url("backend/personal/detail/".enc_uri($rows->id_person)).'" class="badge badge-success text-white" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="DETAIL"><i class="ti-zoom-in"></i></a>
                     ';
          }else {
          $row[] = '<a href="'.site_url("backend/personal/detail/".enc_uri($rows->id_person)).'" class="badge badge-success text-white" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="DETAIL"><i class="ti-zoom-in"></i></a>
                    <a href="'.site_url("backend/personal/update/".enc_uri($rows->id_person)).'" class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="UPDATE"><i class="ti-pencil-alt"></i></a>
                   ';
                 }

          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->model->count_all(),
                      "recordsFiltered" => $this->model->count_filtered(),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
    }
  }


}
