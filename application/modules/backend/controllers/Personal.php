<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    if (profile_admin("level")=="admin_spk") {
        redirect(site_url("backend/error_page/e403"));
    }
    $this->load->model("Personal_model","model");
  }


  function _rules()
  {
    $this->form_validation->set_rules("nama","*&nbsp;","trim|xss_clean|htmlspecialchars|required");
    $this->form_validation->set_rules("telepon1","*&nbsp;","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("telepon2","*&nbsp;","trim|xss_clean|numeric");
    $this->form_validation->set_rules("tempat_lahir","*&nbsp;","trim|xss_clean|required|htmlspecialchars");
    $this->form_validation->set_rules("tanggal_lahir","*&nbsp;","trim|xss_clean|required|htmlspecialchars");
    $this->form_validation->set_rules("alamat","*&nbsp;","trim|xss_clean|required|htmlspecialchars");
    $this->form_validation->set_rules("pekerjaan","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("ukuran_baju","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("nama_ahli_waris","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("hubungan_ahli_waris","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("telepon_ahli_waris","*&nbsp;","trim|xss_clean|numeric");
    $this->form_validation->set_rules("alamat_ahli_waris","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("nama_rekening","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("no_rekening","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("bank","*&nbsp;","trim|xss_clean|htmlspecialchars");
    $this->form_validation->set_rules("status","*&nbsp;","trim|xss_clean|required|numeric|min_length[1]");
    $this->form_validation->set_rules("id_parent","*&nbsp;","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("status_level","*&nbsp;","trim|xss_clean|required|numeric");
    $this->form_validation->set_error_delimiters('<span class="error mt-1 text-danger" style="font-size:11px">','</span>');
  }

    function add_parent($id="")
    {
      if ($id!="") {
        $this->template->view("content/personal/modal",["id"=>$id],false);
      }else {
        echo "page not found";
      }
    }

    function json_personal($id)
    {
      $this->load->library('Datatables');
      header('Content-Type: application/json');
      echo $this->model->json_personal($id);
    }


    function detail($id="")
    {
      if ($row = $this->model->get_where_person(dec_uri($id))) {
          $this->template->set_title("Personal");
          $data['row'] = $row;
          $this->template->view("content/personal/detail",$data);
      }
    }

    function add()
    {
      if (profile_admin("level")=="admin_supervisor") {
          redirect(site_url("backend/error_page/e403"));
      }else {
        // code...
      $this->template->set_title("Personal");
      $data = [
                "action"          => site_url("backend/personal/add_action"),
                "button"          => "add",
                "nik"             => set_value("nik"),
                "nama"            => set_value("nama"),
                "email"           => set_value("email"),
                "telepon"         => set_value("telepon"),
                "tempat_lahir"    => set_value("tempat_lahir"),
                "tanggal_lahir"   => set_value("tanggal_lahir"),
                "telepon1"        => set_value("telepon1"),
                "telepon2"        => set_value("telepon2"),
                "pekerjaan"        => set_value("pekerjaan"),
                "ukuran_baju"     => set_value("ukuran_baju"),
                "alamat"          => set_value("alamat"),
                "waris_nama"      => set_value("waris_nama"),
                "waris_telepon"   => set_value("waris_telepon"),
                "waris_alamat"    => set_value("waris_alamat"),
                "waris_hubungan"  => set_value("waris_hubungan"),
                "username"  => set_value("username"),
                "no_rekening"  => set_value("no_rekening"),
                "nama_rekening"  => set_value("nama_rekening"),
                "bank"  => set_value("bank"),
                "status"  => set_value("status"),
                "level"  => set_value("level"),
                "is_parent"  => set_value("is_parent"),
              ];
      $this->template->view("content/personal/form",$data);
    }
    }


    function add_action()
    {
      if ($this->input->is_ajax_request()) {
          $json = array('success'=>false, 'alert'=>array(), 'url'=>array());
          $this->form_validation->set_rules("nik","&nbsp;*","trim|xss_clean|min_length[16]|max_length[16]|required|numeric|callback__cek_nik");
          $this->form_validation->set_rules("email","*&nbsp;","trim|xss_clean|required|valid_email|callback__cek_email");
          $this->form_validation->set_rules("username","*&nbsp;","trim|xss_clean|htmlspecialchars|required|alpha_numeric|min_length[5]|is_unique[auth_person.username]",[
            "is_unique" => "* sudah digunakan"]);
          $this->_rules();
          if ($this->form_validation->run()) {
            $level = $this->input->post("status_level",true);
            if ($level==1) {
              $kd = "FON";
              $url =  "founder";
            }elseif ($level==2) {
              $kd = "COF";
              $url =  "co_founders";
            }elseif ($level==3) {
              $kd = "AGN";
              $url =  "agency";
            }elseif ($level==4) {
              $kd = "MEM";
              $url =  "member";
            }

            $kd_person = $this->_kd_reg($kd);
            $data = [
                      "kode_person"   => $kd_person,
                      "is_parent"     => $this->input->post("id_parent",true),
                      "id_level"     => $level,
                      "nik"          => $this->input->post("nik",true),
                      "nama"          => $this->input->post("nama",true),
                      "telepon1"      => $this->input->post("telepon1",true),
                      "telepon2"      => $this->input->post("telepon2",true),
                      "email"         => $this->input->post("email",true),
                      "tempat_lahir"  => $this->input->post("tempat_lahir",true),
                      "tanggal_lahir" => $this->input->post("tanggal_lahir",true),
                      "pekerjaan"     => $this->input->post("pekerjaan",true),
                      "alamat"        => $this->input->post("alamat",true),
                      "ukuran_baju"     => $this->input->post("ukuran_baju",true),
                      "waris_nama"    => $this->input->post("nama_ahli_waris",true),
                      "waris_telepon" => $this->input->post("telepon_ahli_waris",true),
                      "waris_hubungan" => $this->input->post("hubungan_ahli_waris",true),
                      "waris_alamat"  => $this->input->post("alamat_ahli_waris",true),
                      "is_active"     => $this->input->post("status",true),
                      "created"       => date('Y-m-d H:i:s')
                    ];

            $this->model->get_insert("tb_person",$data);

            $id_person = $this->db->insert_id();
            $this->load->helper('pass_has');
            $token = enc_uri(date('dmYhis'));
            $data_auth = ["id_person" => $id_person,
                          "username" => strtolower($this->input->post("username",true)),
                          "token" => $token,
                          "password"    => pass_encrypt($token,strtolower($this->input->post("username"))),
                          "created"       => date('Y-m-d H:i:s')
            ];
            $this->model->get_insert("auth_person",$data_auth);


            $data_rekening=["id_person"       => $id_person,
                            "bank"            =>  $this->input->post("bank",true),
                            "no_rekening"     =>  $this->input->post("no_rekening",true),
                            "nama_rekening"   =>  $this->input->post("nama_rekening",true),
            ];
            $this->model->get_insert("rekening_person",$data_rekening);


            $data_email = ["id_register"  => $kd_person,
                              "email"         => $this->input->post("email",true),
                              "tempat_lahir"  => $this->input->post("tempat_lahir",true),
                              "tanggal_lahir" => $this->input->post("tanggal_lahir",true),
                              "telepon"      => $this->input->post("telepon1",true),
                              "nik"         => $this->input->post("nik",true),
                              "nama"        => $this->input->post("nama",true),
                              "username" => $this->input->post("username",true),
              ];

              $this->_send_email($data_email);


            $json['alert'] = "add data successfully";
            $json['success'] =  true;
            $json['url'] =  site_url("backend/$url");
          }else {
            foreach ($_POST as $key => $value)
              {
                $json['alert'][$key] = form_error($key);
              }
          }

          echo json_encode($json);
      }
    }

    function _send_email($data_email)
      {
          $subject  = "Data Membership";

          $template = $this->load->view('content/personal/template_email',$data_email,TRUE);

          $config['charset']      = 'utf-8';
          $config['protocol']     = "smtp";
          $config['mailtype']     = "html";
          $config['smtp_host']    = "ssl://cheetahfibonacci.com";//pengaturan smtp
          $config['smtp_port']    = 465;
          $config['smtp_user']    = "no-reply@cheetahfibonacci.com"; // isi dengan email kamu
          $config['smtp_pass']    = "@@111111qwerty"; // isi dengan password kamu
          $config['smtp_timeout'] = 4; //4 second
          $config['crlf']         = "\r\n";
          $config['newline']      = "\r\n";

          $this->load->library('email',$config);
          //konfigurasi pengiriman

          $this->email->from($config['smtp_user'], setting_system("title"));
          $this->email->to($data_email['email']);
          $this->email->subject($subject);
          $this->email->message($template);
          if ($this->email->send()) {
            return true;
          }else {
            return false;
        }
      }


    function cek_data_person($id="")
    {
      if ($id!="") {
        if (isset($_GET['search'])) {
          $key = $_GET['search'];
          $qry = $this->db->select("tb_person.id_person,
                                      tb_person.kode_person,
                                      tb_person.is_active,
                                      tb_person.id_level,
                                      tb_person.nama,
                                      auth_person.username")
                                  ->from('tb_person')
                                  ->join('auth_person','auth_person.id_person = tb_person.id_person')
                                  ->where("tb_person.id_level",$id)
                                  ->like("tb_person.kode_person","$key")
                                  ->or_like("auth_person.username","$key")
                                  ->get();
          if ($qry->num_rows() > 0) {
            $list = array();
            $key=0;
            foreach ($qry->result() as $row) {
              $list[$key++]['id'] = $row->id_person;
              $list[$key++]['text'] = $row->nama;
            }
          echo json_encode($list);
          }else {
            echo "data tidak ditemukan";
          }
        }
      }else {
        echo "data tidak ditemukan";
      }
    }


    function update($id)
    {
      if (profile_admin("level")=="admin_supervisor") {
          redirect(site_url("backend/error_page/e403"));
      }else {
      if ($row = $this->model->get_where_person(dec_uri($id))) {
          $this->template->set_title("personal");
          $data = [
                    "action"          => site_url("backend/personal/update_action/$id"),
                    "button"          => "update",
                    "nik"            => set_value("nik",$row->nik),
                    "nama"            => set_value("nama",$row->nama),
                    "email"           => set_value("email",$row->email),
                    "tempat_lahir"    => set_value("tempat_lahir",$row->tempat_lahir),
                    "tanggal_lahir"   => set_value("tanggal_lahir",$row->tanggal_lahir),
                    "telepon1"        => set_value("telepon1",$row->telepon1),
                    "telepon2"        => set_value("telepon2",$row->telepon2),
                    "pekerjaan"       => set_value("pekerjaan",$row->pekerjaan),
                    "alamat"          => set_value("alamat",$row->alamat),
                    "waris_nama"      => set_value("waris_nama",$row->waris_nama),
                    "waris_telepon"   => set_value("waris_telepon",$row->waris_telepon),
                    "waris_alamat"    => set_value("waris_alamat",$row->waris_alamat),
                    "waris_hubungan"  => set_value("waris_hubungan",$row->waris_hubungan),
                    "username"        => set_value("username",$row->username),
                    "no_rekening"     => set_value("no_rekening",$row->no_rekening),
                    "ukuran_baju"     => set_value("ukuran_baju",$row->ukuran_baju),
                    "nama_rekening"   => set_value("nama_rekening",$row->nama_rekening),
                    "bank"            => set_value("bank",$row->bank),
                    "status"          => set_value("status",$row->is_active),
                    "level"  => set_value("level",$row->id_level),
                    "is_parent"  => set_value("is_parent",$row->is_parent),
                  ];
          $this->template->view("content/personal/form",$data);
      }
    }
    }


    function update_action($id)
    {
      if ($this->input->is_ajax_request()) {
          $json = array('success'=>false, 'alert'=>array());
          $this->form_validation->set_rules("nik","&nbsp;*","trim|xss_clean|required|min_length[16]|max_length[16]|numeric|callback__cek_nik_update[".$this->input->post("nik_lama",true)."]");
          $this->form_validation->set_rules("email","&nbsp;*","trim|xss_clean|required|htmlspecialchars|valid_email|callback__cek_email_update[".$this->input->post("email_lama",true)."]");
          $this->_rules();
          if ($this->form_validation->run()) {

            $level = $this->input->post("status_level",true);
            if ($level==1) {
              $url =  "founder";
            }elseif ($level==2) {
              $url =  "co_founders";
            }elseif ($level==3) {
              $url =  "agency";
            }elseif ($level==4) {
              $url =  "member";
            }
            $where = ["id_person"=>dec_uri($id)];
            $data = ["is_parent"     => $this->input->post("id_parent",true),
                      "id_level"     => $this->input->post("status_level",true),
                      "nik"          => $this->input->post("nik",true),
                      "nama"          => $this->input->post("nama",true),
                      "telepon1"      => $this->input->post("telepon1",true),
                      "telepon2"      => $this->input->post("telepon2",true),
                      "email"         => $this->input->post("email",true),
                      "tempat_lahir"  => $this->input->post("tempat_lahir",true),
                      "tanggal_lahir" => $this->input->post("tanggal_lahir",true),
                      "pekerjaan"     => $this->input->post("pekerjaan",true),
                      "ukuran_baju"     => $this->input->post("ukuran_baju",true),
                      "alamat"        => $this->input->post("alamat",true),
                      "waris_nama"    => $this->input->post("nama_ahli_waris",true),
                      "waris_telepon" => $this->input->post("telepon_ahli_waris",true),
                      "waris_hubungan" => $this->input->post("hubungan_ahli_waris",true),
                      "waris_alamat"  => $this->input->post("alamat_ahli_waris",true),
                      "is_active"     => $this->input->post("status",true),
                      "modified"       => date('Y-m-d H:i:s')
                    ];

            $this->model->get_update("tb_person",$data,$where);


            $data_rekening=["bank"            =>  $this->input->post("bank",true),
                            "no_rekening"     =>  $this->input->post("no_rekening",true),
                            "nama_rekening"   =>  $this->input->post("nama_rekening",true),
            ];
            $this->model->get_update("rekening_person",$data_rekening,$where);

            $json['alert'] = "update data successfully";
            $json['success'] =  true;
            $json['url'] =  site_url("backend/$url");
          }else {
            foreach ($_POST as $key => $value)
              {
                $json['alert'][$key] = form_error($key);
              }
          }

          echo json_encode($json);
      }
    }





    function _kd_reg($str)
    {
      $query = $this->db->select("MAX(kode_person) AS kd_max")
                        ->like("kode_person","$str")
                        ->get("tb_person")
                        ->row();
      $kdMax = $query->kd_max;
      $noUrut = (int) substr($kdMax, 4, 6);
      $noUrut++;
      $char = "$str-";
      $kdMax = $char . sprintf("%06s", $noUrut);
      return $kdMax;
    }


    //callbackk
    function _cek_nik($str)
      {
        $where =  array("nik"=>$str);
        if ($this->model->get_where("tb_person",$where)) {
          $this->form_validation->set_message('_cek_nik', '%s sudah digunakan.');
          return false;
        } else {
          return true;
        }
      }

      function _cek_email($str)
      {
        $where =  array("email"=>$str);
        if ($this->model->get_where("tb_person",$where)) {
          $this->form_validation->set_message('_cek_email', '{field} sudah digunakan.');
          return false;
        } else {
          return true;
        }
      }


      function _cek_nik_update($str,$nik_lama)
      {
        $row =  $this->db->get_where("tb_person",["nik !="=>$nik_lama,"nik"=>$str]);
        if ($row->num_rows() > 0) {
          $this->form_validation->set_message('_cek_nik_update', '* sudah digunakan');
          return false;
        }else {
          return true;
        }
      }

      function _cek_email_update($str,$email_lama)
        {
          $row =  $this->db->get_where("tb_person",["email !="=>$email_lama,"email"=>$str]);
          if ($row->num_rows() > 0) {
            $this->form_validation->set_message('_cek_email_update', '* sudah digunakan');
            return false;
          }else {
            return true;
          }
        }




          function reset_password($id="")
          {
            if ($this->input->is_ajax_request()) {
                if ($row =  $this->model->get_where("auth_person",["id_person"=>dec_uri($id)])) {
                  $data['action'] = site_url("backend/personal/reset_password_action/$id");
                  $data['row'] = $row;
                  $this->template->view("content/personal/reset_pwd",$data,false);
                }else {
                  echo "page not found";
                }
            }
          }

          function reset_password_action($id="")
          {
            if ($this->input->is_ajax_request()) {
              $json = array('success'=>false, 'alert'=>array());
              $this->form_validation->set_rules("password_verif","*&nbsp;","trim|xss_clean|required|callback__cek_password");
              $this->form_validation->set_rules('password', '*&nbsp;', 'required|min_length[5]');
              $this->form_validation->set_rules('v_password', '*&nbsp;', 'matches[password]',[
                "matches"=>"* password tidak valid"
              ]);
              $this->form_validation->set_error_delimiters('<label class="error mt-1 text-danger" style="font-size:11px">','</label>');

              if ($this->form_validation->run()) {
                $this->load->helper('pass_has');
                $token = enc_uri(date('dmYhis'));
                $data = [
                          "token"       => $token,
                          "password"    => pass_encrypt($token,$this->input->post("v_password")),
                        ];
                $this->model->get_update("auth_person",$data,["id_person"=>dec_uri($id)]);
                $json['success'] = true;
                $json['alert']   = 'Reset password successful';
              }else {
                foreach ($_POST as $key => $value)
                  {
                    $json['alert'][$key] = form_error($key);
                  }
              }

              echo json_encode($json);
            }
          }


  function export($id_level="")
  {
    $data['id_level'] = $id_level;
    $this->load->view("content/personal/export",$data);
  }


}
