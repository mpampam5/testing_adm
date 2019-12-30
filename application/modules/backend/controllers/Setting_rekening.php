<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_rekening extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")!="superadmin") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model("Setting_rekening_model","model");
  }

  function _rules()
  {
    $this->form_validation->set_rules("nama_rekening","*&nbsp;","trim|xss_clean|htmlspecialchars|required");
    $this->form_validation->set_rules("no_rekening","*&nbsp;","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("bank","*&nbsp;","trim|xss_clean|required|htmlspecialchars");
    $this->form_validation->set_error_delimiters('<span class="error mt-1 text-danger" style="font-size:11px">','</span>');
  }

  function index()
  {
    $this->template->set_title("Rekening");
    $data['row'] = $this->model->get_data_rekening();
    $this->template->view("content/setting_rekening/index",$data);
  }

  function add()
  {
    $this->template->set_title("Rekening");
    $data = [
              "action"        => site_url("backend/setting_rekening/add_action"),
              "button"        => "add",
              "nama_rekening" => set_value("nama_rekening"),
              "no_rekening"   => set_value("no_rekening"),
              "bank"          => set_value("bank"),
            ];
    $this->template->view("content/setting_rekening/form",$data);
  }


  function add_action()
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $this->_rules();
        if ($this->form_validation->run()) {

          $data = [
                    "nama_rekening" => $this->input->post("nama_rekening",true),
                    "no_rekening"   => $this->input->post("no_rekening",true),
                    "bank"          => $this->input->post("bank",true),
                    "created"     => date('Y-m-d H:i:s')
                  ];

          $this->model->get_insert("setting_rekening",$data);

          $json['alert'] = "add data successfully";
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


  function update($id)
  {
    if ($row = $this->model->get_where("setting_rekening",["id_rekening"=>dec_uri($id)])) {
        $this->template->set_title("Rekening");
        $data = [
                  "action"        => site_url("backend/setting_rekening/update_action/$id"),
                  "button"        => "update",
                  "nama_rekening" => set_value("nama_rekening",$row->nama_rekening),
                  "no_rekening"   => set_value("no_rekening",$row->no_rekening),
                  "bank"          => set_value("bank",$row->bank),
                ];
        $this->template->view("content/setting_rekening/form",$data);
    }
  }


  function update_action($id)
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $this->_rules();
        if ($this->form_validation->run()) {
          $data = [
                    "nama_rekening" => $this->input->post("nama_rekening",true),
                    "no_rekening"   => $this->input->post("no_rekening",true),
                    "bank"          => $this->input->post("bank",true),
                    "modified"     => date('Y-m-d H:i:s')
                  ];
          $this->model->get_update("setting_rekening",$data,["id_rekening"=>dec_uri($id)]);
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


  function delete($id)
    {
      if ($this->input->is_ajax_request()) {
        if ($this->model->get_update('setting_rekening',["is_delete"=>"1"],["id_rekening"=>dec_uri($id)])) {
            $json['success'] = "success";
            $json['alert']   = 'delete data successfully';
        }
        echo json_encode($json);
      }
    }

}
