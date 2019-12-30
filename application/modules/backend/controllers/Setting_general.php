<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_general extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")!="superadmin") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model("Setting_general_model","model");
  }

  function _rules()
  {
    $this->form_validation->set_rules("nama","*&nbsp;","trim|xss_clean|htmlspecialchars|required");
    $this->form_validation->set_rules("telepon1","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("telepon2","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("email","*&nbsp;","trim|xss_clean|valid_email");
    $this->form_validation->set_rules("alamat","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_error_delimiters('<span class="error mt-1 text-danger" style="font-size:11px">','</span>');
  }

  function index()
  {
    $this->template->set_title("General");
    $data['row'] = $this->model->get_setting_system();
    $this->template->view("content/setting_general/index",$data);
  }

  function update($id)
  {
    if ($row = $this->model->get_where("setting_system",["id_setting_system"=>dec_uri($id)])) {
        $this->template->set_title("General");
        $data = [
                  "action"        => site_url("backend/setting_general/update_action/$id"),
                  "button"        => "update",
                  "nama"         => set_value("nama",$row->title),
                  "email"         => set_value("email",$row->email),
                  "telepon1"       => set_value("telepon1",$row->telepon1),
                  "telepon2"       => set_value("telepon2",$row->telepon2),
                  "alamat"        => set_value("alamat",$row->alamat),
                ];
        $this->template->view("content/setting_general/form",$data);
    }
  }


  function update_action($id)
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $this->_rules();
        if ($this->form_validation->run()) {
          $data = [
                    "title"    => $this->input->post("nama",true),
                    "telepon1" => $this->input->post("telepon1",true),
                    "telepon2" => $this->input->post("telepon2",true),
                    "email"   => $this->input->post("email",true),
                    "alamat"   => $this->input->post("alamat",true),
                  ];
          $this->model->get_update("setting_system",$data,["id_setting_system"=>dec_uri($id)]);
          $json['alert'] = "update data successfully";
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


  function do_upload()
        {
          if ($this->input->is_ajax_request()) {
              $json = array('success' =>false , "alert"=> array(), "file_name"=>array());
              $image = "background-login.".pathinfo($_FILES['foto_personal']['name'], PATHINFO_EXTENSION);

              $config['upload_path'] = "./_template/";
              $config['allowed_types'] = 'jpg|jpeg';
              $config['overwrite'] = true;
              $config['max_size']  = '1024';
              $config['file_name']  = "$image";


              $this->load->library('upload', $config);

              if (!$this->upload->do_upload('foto_personal')){
                  $json['header_alert'] = "error";
                  $json['alert'] = "File tidak valid, format file harus jpg|jpeg & ukuran maksimal 1mb";
              }else {
                  $this->model->get_update("setting_system",["background"=>$image],["id_setting_system"=>999]);
                  $json['header_alert'] = "success";
                  $json['file_name'] = $image;
                  $json['alert'] = "File upload successfully.";
                  $json['success'] = true;
              }

              echo json_encode($json);

        }
      }

}
