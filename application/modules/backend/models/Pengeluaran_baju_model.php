<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran_baju_model extends MY_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  function get_baju($where)
  {
    return $this->db->get_where("pengeluaran_baju",["ukuran_baju"=>$where,"status"=>"sudah"])->num_rows();
  }

  function json()
    {
      $this->datatables->select("pengeluaran_baju.id,
                                  pengeluaran_baju.id_person,
                                  pengeluaran_baju.status,
                                  tb_person.nama,
                                  tb_person.ukuran_baju,
                                  auth_person.username");
      $this->datatables->from('pengeluaran_baju');
      $this->datatables->join("tb_person","tb_person.id_person = pengeluaran_baju.id_person");
      $this->datatables->join("auth_person","auth_person.id_person = pengeluaran_baju.id_person");
      $this->datatables->add_column('action','','id_member');
      return $this->datatables->generate();
    }


    function get_export()
    {
      $this->db->select("pengeluaran_baju.id,
                                  pengeluaran_baju.id_person,
                                  pengeluaran_baju.status,
                                  tb_person.nama,
                                  tb_person.ukuran_baju,
                                  auth_person.username");
      $this->db->from('pengeluaran_baju');
      $this->db->join("tb_person","tb_person.id_person = pengeluaran_baju.id_person");
      $this->db->join("auth_person","auth_person.id_person = pengeluaran_baju.id_person");
      $this->db->order_by('id',"desc");
      $qry = $this->db->get();
      return $qry->result();
    }
}
