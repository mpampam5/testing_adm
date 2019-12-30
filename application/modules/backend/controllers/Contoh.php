<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contoh extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Contoh_model","model");
  }

  function _rules()
  {
    $this->form_validation->set_rules("nama","*&nbsp;","trim|xss_clean|htmlspecialchars|required");
    $this->form_validation->set_rules("telepon","*&nbsp;","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("email","*&nbsp;","trim|xss_clean|required|valid_email");
    $this->form_validation->set_error_delimiters('<span class="error mt-1 text-danger" style="font-size:11px">','</span>');
  }

  function index()
  {
    $this->template->set_title("Contoh");
    $this->template->view("content/contoh/index");
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
            $row[] = $rows->nama;
            $row[] = $rows->telepon;
            $row[] = $rows->email;

            $row[] = '<a href="'.site_url("backend/contoh/detail/".enc_uri($rows->id_contoh)).'" class="badge badge-success" id="rst_pwd" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="DETAIL"><i class="ti-zoom-in"></i></a>
                      <a href="'.site_url("backend/contoh/update/".enc_uri($rows->id_contoh)).'" class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="UPDATE"><i class="ti-pencil-alt"></i></a>
                      <a href="'.site_url("backend/contoh/delete/".enc_uri($rows->id_contoh)).'" class="badge badge-danger" id="delete" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="REMOVE"><i class="ti-trash"></i></a>
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

    function detail($id="")
    {
      if ($row = $this->model->get_where("tb_admin",["id_admin"=>dec_uri($id)])) {
          $this->template->set_title("Contoh");
          $data['row'] = $row;
          $this->template->view("content/contoh/detail",$data);
      }else {
        $this->_error404();
      }
    }

    function add()
    {
      $this->template->set_title("contoh");
      $data = [
                "action"      => site_url("backend/contoh/add_action"),
                "button"      => "add",
                "nama"        => set_value("nama"),
                "email"       => set_value("email"),
                "telepon"     => set_value("telepon"),
              ];
      $this->template->view("content/contoh/form",$data);
    }

    function add_action()
    {
      if ($this->input->is_ajax_request()) {
          $json = array('success'=>false, 'alert'=>array());
          $this->_rules();
          if ($this->form_validation->run()) {

            $data = [
                      "nama"        => $this->input->post("nama",true),
                      "telepon"     => $this->input->post("telepon",true),
                      "email"       => $this->input->post("email",true),
                    ];

            $this->model->get_insert("contoh",$data);

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
      if ($row = $this->model->get_where("contoh",["id_contoh"=>dec_uri($id)])) {
          $this->template->set_title("contoh");
          $data = [
                    "action"      => site_url("backend/contoh/update_action/$id"),
                    "button"      => "update",
                    "nama"        => set_value("nama",$row->nama),
                    "email"       => set_value("email",$row->email),
                    "telepon"     => set_value("telepon",$row->telepon),
                  ];
          $this->template->view("content/contoh/form",$data);
      }else {
        $this->_error404();
      }
    }

    function update_action($id)
    {
      if ($this->input->is_ajax_request()) {
          $json = array('success'=>false, 'alert'=>array());
          $this->_rules();
          if ($this->form_validation->run()) {
            $data = [
                      "nama"    => $this->input->post("nama",true),
                      "telepon" => $this->input->post("telepon",true),
                      "email"   => $this->input->post("email",true),
                    ];
            $this->model->get_update("contoh",$data,["id_contoh"=>dec_uri($id)]);
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
      if ($this->model->get_delete('contoh',["id_contoh"=>dec_uri($id)])) {
          $json['success'] = "success";
          $json['alert']   = 'delete data successfully';
      }
      echo json_encode($json);
    }
  }

}
