<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contoh_model extends MY_Model{

    var $column_order = array(null, 'nama','telepon','email');
    var $column_search = array('nama','telepon','email');
    var $order = array('id_contoh'=>"DESC");


    private function _get_datatables_query()
      {


        $this->db->from("contoh");



          if($this->input->post('nama'))
          {
              $this->db->like('nama', $this->input->post('nama'));
          }
          if($this->input->post('telepon'))
          {
              $this->db->like('telepon', $this->input->post('telepon'));
          }
          if($this->input->post('email'))
          {
              $this->db->like('email', $this->input->post('email'));
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
          $this->db->from("contoh");
          return $this->db->count_all_results();
      }


}
