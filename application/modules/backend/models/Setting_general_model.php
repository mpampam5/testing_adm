<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_general_model extends MY_Model{

  function get_setting_system(){
    return $this->db->get_where("setting_system",["id_setting_system"=>999])->row();
  }

}
