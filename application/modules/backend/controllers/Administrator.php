<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")!="superadmin") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model("Administrator_model","model");
  }

  function index()
  {
    $this->template->set_title("Administrator");
    $this->template->view("content/administrator/index");
  }

  function _rules()
  {
    $this->form_validation->set_rules("nama","*&nbsp;","trim|xss_clean|htmlspecialchars|required");
    $this->form_validation->set_rules("level","*&nbsp;","trim|xss_clean|htmlspecialchars|required");
    $this->form_validation->set_rules("telepon","*&nbsp;","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("email","*&nbsp;","trim|xss_clean|required|valid_email");
    $this->form_validation->set_error_delimiters('<span class="error mt-1 text-danger" style="font-size:11px">','</span>');
  }

  function json()
  {
    if ($this->input->is_ajax_request()) {
      $list = $this->model->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $admin) {
          $no++;
          $row = array();
          $row[] = $no;
          $row[] = $admin->nama;
          $row[] = $admin->username;
          $row[] = $admin->email;
          $row[] = $admin->level;

          $row[] = ($admin->is_active=="y") ? '<span class="text-success"> Aktif</span>':'<span class="text-danger">Tidak Aktif</span>';

          $row[] = '<a href="'.site_url("backend/administrator/reset_password/".enc_uri($admin->id_admin)).'" class="badge badge-warning text-white" id="rst_pwd" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="RESET PASSWORD"><i class="ti-key"></i></a>
                    <a href="'.site_url("backend/administrator/update/".enc_uri($admin->id_admin)).'" class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="UPDATE"><i class="ti-pencil-alt"></i></a>
                    <a href="'.site_url("backend/administrator/delete/".enc_uri($admin->id_admin)).'" class="badge badge-danger" id="delete" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="REMOVE"><i class="ti-trash"></i></a>
                   ';

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


  function add()
  {
    $this->template->set_title("Administrator");
    $data = [
              "action"      => site_url("backend/administrator/add_action"),
              "button"      => "add",
              "nama"        => set_value("nama"),
              "email"       => set_value("email"),
              "telepon"     => set_value("telepon"),
              "is_active"   => set_value("is_active"),
              "level"   => set_value("level")
            ];
    $this->template->view("content/administrator/form",$data);
  }

  function add_action()
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $this->form_validation->set_rules("is_active","*&nbsp;","trim|xss_clean|required");
        $this->form_validation->set_rules('username', '*&nbsp;', 'required|alpha_numeric|min_length[5]|is_unique[tb_admin.username]',[
          "is_unique" => "Ganti Username Lain"
        ]);
        $this->form_validation->set_rules('password', '*&nbsp;', 'required|min_length[5]');
        $this->form_validation->set_rules('v_password', '*&nbsp;', 'required|matches[password]',[
          "matches"=>"* password tidak valid"
        ]);
        $this->_rules();
        if ($this->form_validation->run()) {
          $this->load->helper('pass_has');
          $token = enc_uri(date('dmYhis'));

          $data = [
                    "nama"        => $this->input->post("nama",true),
                    "telepon"     => $this->input->post("telepon",true),
                    "email"       => $this->input->post("email",true),
                    "level"       => $this->input->post("level",true),
                    "token"       => $token,
                    "username"    => $this->input->post("username", true),
                    "password"    => pass_encrypt($token,$this->input->post("v_password")),
                    "level"       => $this->input->post('level'),
                    "is_active"   => $this->input->post('is_active'),
                    "created"     => date('Y-m-d H:i:s')
                  ];

          $this->model->get_insert("tb_admin",$data);

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
    if ($row = $this->model->get_where("tb_admin",["id_admin"=>dec_uri($id)])) {
        $this->template->set_title("Administrator");
        $data = [
                  "action"      => site_url("backend/administrator/update_action/$id"),
                  "button"      => "update",
                  "nama"        => set_value("nama",$row->nama),
                  "email"       => set_value("email",$row->email),
                  "telepon"     => set_value("telepon",$row->telepon),
                  "is_active"     => set_value("is_active",$row->is_active),
                  "level"     => set_value("level",$row->level),
                ];
        $this->template->view("content/administrator/form",$data);
    }else {
      $this->_error404();
    }
  }

  function update_action($id)
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $this->form_validation->set_rules("is_active","Is Active","trim|xss_clean|required");
        $this->_rules();
        if ($this->form_validation->run()) {
          $data = [
                    "nama"    => $this->input->post("nama",true),
                    "telepon" => $this->input->post("telepon",true),
                    "email"   => $this->input->post("email",true),
                    "is_active"   => $this->input->post('is_active'),
                    "level"   => $this->input->post('level'),
                    "modified"     => date('Y-m-d h:i:s')
                  ];
          $this->model->get_update("tb_admin",$data,["id_admin"=>dec_uri($id)]);
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
      if ($this->model->get_update('tb_admin',['is_delete'=>'1'],["id_admin"=>dec_uri($id)])) {
          $json['success'] = "success";
          $json['alert']   = 'delete data successfully';
      }
      echo json_encode($json);
    }
}



  function reset_password($id="")
  {
    if ($this->input->is_ajax_request()) {
        if ($row =  $this->model->get_where("tb_admin",["id_admin"=>dec_uri($id)])) {
          $data['action'] = site_url("backend/administrator/reset_password_action/$id");
          $data['row'] = $row;
          $this->template->view("content/administrator/reset_pwd",$data,false);
        }else {
          echo "page not found";
        }
    }
  }

  function reset_password_action($id="")
  {
    if ($this->input->is_ajax_request()) {
      $json = array('success'=>false, 'alert'=>array());
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
        $this->model->get_update("tb_admin",$data,["id_admin"=>dec_uri($id)]);
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
