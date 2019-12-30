<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")=="admin_spk") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model('Admin_model','model');
  }

  function _rules()
  {
    $this->form_validation->set_rules("nama","Nama","trim|xss_clean|htmlspecialchars|required");
    $this->form_validation->set_rules("telepon","Telepon","trim|xss_clean|htmlspecialchars|required|numeric");
    $this->form_validation->set_rules("email","Email","trim|xss_clean|required|valid_email");
    $this->form_validation->set_error_delimiters('<label class="error mt-2 text-danger" style="font-size:11px;">','</label>');
  }

  function index()
  {
      $this->template->set_title('Admin');
      $this->template->view("content/admin/index");
  }

  function json()
  {
    if ($this->input->is_ajax_request()) {
        $this->load->library('Datatables');
        header('Content-Type: application/json');
        echo $this->model->json();
    }
  }


  function add()
  {
      $this->template->set_title('Admin');
        $data = [
                  'button' => 'Tambah',
                  'action' => site_url('backend/admin/add_action'),
  								'nama'	=>	set_value('nama'),
  								'telepon'	=>	set_value('telepon'),
  								'email'	=>	set_value('email'),
  							];
      $this->template->view('content/admin/form',$data);
  }


  function add_action()
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success'=>false,'status'=>array(), 'alert'=>array());
      $this->_rules();
      if ($this->form_validation->run()) {
        $data = [
                  "nama"    => $this->input->post("nama",true),
                  "telepon" => $this->input->post("telepon",true),
                  "email"   => $this->input->post("email",true),
                ];
        $this->model->get_insert("admin",$data);

        $json['alert'] = "Data Berhasil Di Simpan";
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
    if ($row = $this->model->get_where("admin",['id'=>$id])) {
      $this->template->set_title('Admin');
        $data = [
                  'button' => 'edit',
                  'action' => site_url("backend/admin/update_action/$id"),
  								'nama'	=>	set_value('nama',$row->nama),
  								'telepon'	=>	set_value('telepon',$row->telepon),
  								'email'	=>	set_value('email',$row->email),
  							];
      $this->template->view('content/admin/form',$data);
    }else {
      $this->_error404();
    }

  }

  function update_action($id)
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success'=>false,'status'=>array(), 'alert'=>array());
      $this->_rules();
      if ($this->form_validation->run()) {
        $data = [
                  "nama"    => $this->input->post("nama",true),
                  "telepon" => $this->input->post("telepon",true),
                  "email"   => $this->input->post("email",true),
                ];
        $this->model->get_update("admin",$data,["id"=>$id]);

        $json['alert'] = "Data Berhasil Di Edit";
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
      if ($this->model->get_delete('admin',["id"=>$id])) {
          $json['success'] = "success";
          $json['alert']   = 'Delete successful';
      }
      echo json_encode($json);
    }
  }




} //end class crud
