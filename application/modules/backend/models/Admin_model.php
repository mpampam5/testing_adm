<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends MY_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  function json()
  {
    $this->datatables->select("id,nama,email,telepon");
    $this->datatables->from('admin');
    $this->datatables->add_column('action',
                                   '<a href="'.site_url("backend/admin/update/$1").'" class="text-white btn btn-sm btn-warning" id="update" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit">
                                       <i class="ti-pencil-alt"></i> Ubah
                                     </a>
                                     <a href="'.site_url('backend/admin/delete/$1').'" id="delete" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus" data-original-title="Hapus">
                                       <i class="ti-trash"></i> Hapus
                                     </a>',
                                  'id');
    return $this->datatables->generate();
  }







} //end class models
