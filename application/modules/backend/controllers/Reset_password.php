<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reset_password extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Administrator_model","model");
  }

  function index()
  {
    $this->template->set_title("Ganti Password");
    $this->template->view("content/reset_password/index");
  }


  function action()
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success'=>false, 'alert'=>array());
      $this->form_validation->set_rules('password_lama', '*&nbsp;', 'required|callback__cek_password');
      $this->form_validation->set_rules('password', '*&nbsp;', 'required|min_length[5]');
      $this->form_validation->set_rules('v_password', '*&nbsp;', 'matches[password]',[
        "matches"=>"* password tidak valid"
      ]);
      $this->form_validation->set_error_delimiters('<label class="error mt-1 text-danger" style="font-size:11px">','</label>');

      if ($this->form_validation->run()) {
        $this->load->helper('pass_has');
        $token = enc_uri(date('dmYhis'));
        $data = [
                  "token"       => $token,
                  "password"    => pass_encrypt($token,$this->input->post("v_password")),
                ];
        $this->model->get_update("tb_admin",$data,["id_admin"=>sess("id_admin")]);
        $json['success'] = true;
        $json['alert']   = 'Reset password successful';
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
