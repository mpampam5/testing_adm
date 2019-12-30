<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{

  function get_query($query)
    {
      return $this->db->query($query);
    }

    function get_where($table,$where)
    {
      return $this->db->get_where($table,$where)
                      ->row();
    }

    function get_insert($table,$data)
    {
      return $this->db->insert($table,$data);
    }


    function get_update($table,$data,$where)
    {
      return $this->db->where($where)
                      ->update($table,$data);
    }

    function get_delete($table,$where)
    {
      return $this->db->where($where)
                      ->delete($table);

    }

} //end class model
