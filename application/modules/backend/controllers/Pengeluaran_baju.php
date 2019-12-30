<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran_baju extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Pengeluaran_baju_model","model");
  }

  function index()
  {
    $this->template->set_title("Data Pengeluran Baju");
    $this->template->view("content/pengeluaran_baju/index");
  }

  function json()
  {
    $this->load->library('Datatables');
    header('Content-Type: application/json');
    echo $this->model->json();
  }


  function ubah_status($id,$status)
  {
    if ($this->input->is_ajax_request()) {
      if ($this->model->get_update('pengeluaran_baju',['status'=>"$status"],["id"=>$id])) {
          $json['success'] = "success";
          $json['alert']   = 'successful';
      }
      echo json_encode($json);
    }
  }


  function export()
  {
    $data['row'] = $this->model->get_export();
    $this->load->view("content/pengeluaran_baju/export",$data);
  }

}
