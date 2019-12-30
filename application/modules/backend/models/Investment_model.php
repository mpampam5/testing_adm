<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Investment_model extends MY_Model{

    var $column_order = array(null, 'investment.kode_invest','investment.created','investment.amount','investment.status');
    var $column_search = array('investment.kode_invest','tb_person.kode_person','investment.status','tb_person.nama');
    var $order = array('id_invest'=>"DESC");

    private function _get_datatables_query()
      {

        $this->db->select("investment.id_invest,
                        investment.kode_invest,
                        investment.id_person,
                        investment.amount,
                        investment.`status`,
                        investment.created,
                        investment.kontrak_start,
                        investment.kontrak_end,
                        tb_person.kode_person,
                        tb_person.nama");
        $this->db->from("investment");
        $this->db->join("tb_person","tb_person.id_person = investment.id_person");



          if($this->input->post('kode_invest'))
          {
              $this->db->like('investment.kode_invest', $this->input->post('kode_invest'));
          }
          if($this->input->post('kode_person'))
          {
              $this->db->like('tb_person.kode_person', $this->input->post('kode_person'));
          }
          if($this->input->post('nama'))
          {
              $this->db->like('tb_person.nama', $this->input->post('nama'));
          }
          if($this->input->post('status'))
          {
              $this->db->like('investment.status', $this->input->post('status'));
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
          $this->db->from("investment");
          return $this->db->count_all_results();
      }


function get_detail_invest($id)
  {
    $qry = $this->db->select("investment.id_invest,
                              investment.kode_invest,
                              investment.id_person,
                              investment.amount,
                              investment.`status`,
                              investment.qr_code,
                              investment.created,
                              investment.kontrak_start,
                              investment.kontrak_end,
                              investment.alamat_kirim_spk,
                              tb_person.kode_person,
                              tb_person.nik,
                              tb_person.nama,
                              tb_person.tempat_lahir,
                              tb_person.tanggal_lahir,
                              tb_person.alamat,
                              tb_person.telepon1,
                              tb_person.telepon2,
                              rekening_person.nama_rekening,
                              rekening_person.no_rekening,
                              rekening_person.bank,
                              rekening_person.file_foto_rek,
                              tb_person.file_foto,
                              tb_person.file_ktp")
                    ->from("investment")
                    ->join("tb_person","tb_person.id_person = investment.id_person","left")
                    ->join("rekening_person","rekening_person.id_person = tb_person.id_person","left")
                    ->where("investment.id_invest",dec_uri($id))
                    ->get()
                    ->row();
    return $qry;
  }

  function json_profit()
    {
      $this->datatables->select("investment_profit.id_invest_profit,
                                  investment_profit.id_invest,
                                  investment_profit.no_profit,
                                  DATE_FORMAT(investment_profit.time_profit,'%d-%m-%Y') AS time_profit,
                                  investment_profit.name_profit,
                                  FORMAT(investment_profit.amount_profit,0) AS amount_profit,
                                  investment.id_person,
                                  investment.kode_invest AS kode_invest,
                                  FORMAT(investment.amount,0) AS amount,
                                  tb_person.nama,
                                  auth_person.username");
      $this->datatables->from("investment_profit");
      $this->datatables->join("investment","investment.id_invest = investment_profit.id_invest","left");
      $this->datatables->join("tb_person","tb_person.id_person = investment.id_person","left");
      $this->datatables->join("auth_person","auth_person.id_person = investment.id_person","left");
      $this->datatables->where("investment_profit.amount_profit !=","");
      return $this->datatables->generate();
    }


    function json_dividen()
  {
    $this->datatables->select("investment_dividen.id_invest_dividen,
                              investment_dividen.id_invest,
                              investment_dividen.id_person,
                              investment_dividen.no_dividen,
                              DATE_FORMAT(investment_dividen.time_dividen,'%d-%m-%Y') AS time_dividen,
                              investment_dividen.persentase,
                              FORMAT(investment_dividen.amount,0) AS amount_dividen,
                              investment.kode_invest,
                              investment.kontrak_start,
                              investment.kontrak_end,
                              FORMAT(investment.amount,0) AS amount_invest,
                              tb_person.kode_person,
                              tb_person.nama,
                              level_person.`level`");
    $this->datatables->from("investment_dividen");
    $this->datatables->join("investment","investment.id_invest = investment_dividen.id_invest");
    $this->datatables->join("tb_person","tb_person.id_person = investment_dividen.id_person");
    $this->datatables->join("level_person","level_person.id_level = tb_person.id_level");
    return $this->datatables->generate();

  }

function export_excel($group="")
{
  $this->db->select("investment.id_invest,
                      investment.kode_invest,
                      investment.id_person,
                      investment.amount,
                      investment.status,
                      investment.created,
                      investment.kontrak_start,
                      investment.kontrak_end,
                      investment.group,
                      tb_person.nik,
                      tb_person.kode_person,
                      tb_person.nama,
                      rekening_person.nama_rekening,
                      rekening_person.no_rekening,
                      rekening_person.bank");
  $this->db->from("investment");
  $this->db->join("tb_person","tb_person.id_person = investment.id_person");
  $this->db->join("rekening_person","rekening_person.id_person = tb_person.id_person");
  if ($group!="") {
    $this->db->where("investment.group",$group);
  }
  $this->db->order_by("id_invest","desc");

  $qry = $this->db->get();
  return $qry;
}

function export_excel_dividen($group)
{
  $qry = $this->db->query("SELECT
                              investment_dividen.id_invest_dividen,
                              investment_dividen.id_invest,
                              investment_dividen.id_person,
                              investment_dividen.no_dividen,
                              investment_dividen.time_dividen,
                              investment_dividen.persentase,
                              investment_dividen.amount,
                              investment.kode_invest,
                              investment.group,
                              investment.amount AS amount_invest,
                              investment.kontrak_start,
                              investment.kontrak_end,
                              tb_person.kode_person,
                              tb_person.nik,
                              tb_person.nama,
                              level_person.level,
                              auth_person.username,
                              rekening_person.nama_rekening,
                              rekening_person.no_rekening,
                              rekening_person.bank
                            FROM
                              investment_dividen
                            INNER JOIN
                              investment ON investment.id_invest = investment_dividen.id_invest
                            INNER JOIN
                              tb_person ON tb_person.id_person = investment_dividen.id_person
                            INNER JOIN
                              level_person ON level_person.id_level = tb_person.id_level
                            INNER JOIN
                              auth_person ON auth_person.id_person = tb_person.id_person
                            INNER JOIN
                              rekening_person ON rekening_person.id_person = tb_person.id_person
                            WHERE
                              investment.group = $group
                            ORDER BY id_invest_dividen DESC");
    return $qry;
}



}
