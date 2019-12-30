<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Co_founder_model extends MY_Model{

  var $column_order = array(null,'kode_person','nik','nama','username','email');
  var $column_search = array('kode_person','nik','username','nama','email','is_active');
  var $order = array('id_person'=>"DESC");


  private function _get_datatables_query()
    {
      $this->db->select("tb_person.id_person,
                          tb_person.kode_person,
                          tb_person.id_level,
                          tb_person.nik,
                          tb_person.nama,
                          tb_person.email,
                          tb_person.is_active,
                          auth_person.username");
      $this->db->from("tb_person");
      $this->db->join("auth_person","auth_person.id_person = tb_person.id_person");
      $this->db->where("id_level", 2);


        //add custom filter here
        if($this->input->post('email'))
        {
            $this->db->like('email', $this->input->post('email'));
        }
        if($this->input->post('nik'))
        {
            $this->db->like('nik', $this->input->post('nik'));
        }
        if($this->input->post('nama'))
        {
            $this->db->like('nama', $this->input->post('nama'));
        }
        if($this->input->post('username'))
        {
            $this->db->like('username', $this->input->post('username'));
        }
        if($this->input->post('kode_person'))
        {
            $this->db->like('kode_person', $this->input->post('kode_person'));
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


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from("tb_person");
        $this->db->where("id_level", 2);
        return $this->db->count_all_results();
    }


}
