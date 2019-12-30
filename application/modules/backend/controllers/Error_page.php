<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_page extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function e403()
  {
    $this->template->set_title("error 403");
    $this->template->view("backend/error403");
  }

}
