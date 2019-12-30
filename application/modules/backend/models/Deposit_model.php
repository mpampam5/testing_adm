<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit_model extends MY_Model{

  var $column_order = array(null, 'deposit.kode_transaksi','nama','username');
  var $column_search = array('deposit.kode_transaksi','tb_person.nama','tb_person.username','deposit.amount');
  var $order = array('id_deposit'=>"DESC");
  var $select = "deposit.id_deposit,
                  deposit.kode_transaksi,
                  deposit.id_person,
                  deposit.amount,
                  deposit.biaya_admin,
                  deposit.status,
                  deposit.metode_pembayaran,
                  deposit.created,
                  tb_person.kode_person,
                  tb_person.nama,
                  tb_person.telepon1,
                  auth_person.username";

  private function _get_datatables_query($status)
    {

      $this->db->select($this->select);
      $this->db->from("deposit");
      $this->db->join("tb_person","tb_person.id_person = deposit.id_person");
      $this->db->join("auth_person","auth_person.id_person = deposit.id_person");
      if ($status=="approved") {
        $this->db->where("deposit.status", "approved");
      }else {
        $this->db->where("deposit.status", "process");
      }



        if($this->input->post('nama'))
        {
            $this->db->like('tb_person.nama', $this->input->post('nama'));
        }
        if($this->input->post('kode_transaksi'))
        {
            $this->db->like('deposit.kode_transaksi', $this->input->post('kode_transaksi'));
        }
        if($this->input->post('username'))
        {
            $this->db->like('auth_person.username', $this->input->post('username'));
        }
        if($this->input->post('amount'))
        {

            if (replace_rupiah($this->input->post("amount")) > 5000000) {
              $this->db->like('deposit.amount', replace_rupiah($this->input->post("amount")) - 150000);
            }else {
              $this->db->like('deposit.amount', replace_rupiah($this->input->post("amount")));
            }
        }



        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function get_datatables($status)
    {
        $this->_get_datatables_query($status);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($status)
    {
        $this->_get_datatables_query($status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($status)
    {
        $this->db->from("deposit");
        if ($status=="approved") {
          $this->db->where("deposit.status","approved");
        }else {
          $this->db->where("deposit.status","process");
        }
        return $this->db->count_all_results();
    }



    function get_where_detail($status,$id)
  {
    $this->db->select("deposit.id_deposit,
                              deposit.kode_transaksi,
                              deposit.id_person,
                              deposit.amount,
                              deposit.amount_acc,
                              deposit.biaya_admin,
                              deposit.status,
                              deposit.keterangan,
                              deposit.metode_pembayaran,
                              deposit.created,
                              setting_rekening.nama_rekening,
                              setting_rekening.no_rekening,
                              setting_rekening.bank,
                              tb_person.kode_person,
                              tb_person.nama,
                              auth_person.username");
      $this->db->from("deposit");
      $this->db->join("setting_rekening","setting_rekening.id_rekening = deposit.metode_pembayaran");
      $this->db->join("tb_person","tb_person.id_person = deposit.id_person");
      $this->db->join("auth_person","auth_person.id_person = deposit.id_person");
      $this->db->where("deposit.id_deposit",dec_uri($id));
      if ($status=="approved") {
        $this->db->where("deposit.status","approved");
      }else {
        $this->db->where("deposit.status","process");
      }
      $qry = $this->db->get();
      return $qry->row();
  }



  function export($status)
  {
    $this->db->select("deposit.id_deposit,
                      deposit.kode_transaksi,
                      deposit.id_person,
                      deposit.biaya_admin,
                      deposit.amount,
                      deposit.amount_acc,
                      deposit.status,
                      deposit.metode_pembayaran,
                      deposit.created,
                      setting_rekening.nama_rekening,
                      setting_rekening.no_rekening,
                      setting_rekening.bank,
                      deposit.time_approved,
                      tb_person.kode_person,
                      tb_person.nik,
                      tb_person.nama,
                      tb_person.telepon1,
                      auth_person.username,
                      level_person.level");
      $this->db->from("deposit");
      $this->db->join("setting_rekening","setting_rekening.id_rekening = deposit.metode_pembayaran");
      $this->db->join("tb_person","tb_person.id_person = deposit.id_person");
      $this->db->join("auth_person","auth_person.id_person = deposit.id_person");
      $this->db->join("level_person","level_person.id_level = tb_person.id_level");

      if ($status=="approved") {
        $this->db->where("deposit.status","approved");
      }else {
        $this->db->where("deposit.status","process");
      }
      $qry = $this->db->get();

    return $qry;
  }

}
