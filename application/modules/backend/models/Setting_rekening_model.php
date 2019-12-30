<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_rekening_model extends MY_Model{

  function get_data_rekening()
  {
    $qry = $this->db->select("*")
                    ->from("setting_rekening")
                    ->where("is_delete","0")
                    ->order_by("id_rekening","DESC")
                    ->get();
      return $qry;
  }

}
