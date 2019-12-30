<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

function balance($id)
{

  $deposit = total_deposit($id);
  $investment = total_investment($id);
  $total = $deposit-$investment;
  return $total;
}


function total_deposit($id)
{
  $ci=& get_instance();
  $qry = $ci->db->query("SELECT
                          	deposit.id_deposit,
                          	deposit.id_person,
                          	Sum( deposit.amount_acc) AS amount,
                          	deposit.status
                          FROM
                          	deposit
                          WHERE
                          	deposit.id_person = ".$id." AND deposit.status = 'approved'
                          ")->row();
  return $qry->amount;
}


function total_investment($id)
{
  $ci=& get_instance();
  $qry = $ci->db->query("SELECT
                          	investment.id_invest,
                          	investment.kode_invest,
                          	investment.id_person,
                          	Sum( investment.amount ) AS amount,
                          	investment.status,
                          	investment.created
                          FROM
                          	investment
                          WHERE
                          	investment.id_person = ".$id." AND
                            investment.status = 'ongoing'")->row();
  return $qry->amount;
}


function total_investment_profit($id)
{
  $ci=& get_instance();
  $qry = $ci->db->query("SELECT
                          	investment.id_invest,
                          	investment.id_person,
                          	Sum( investment_profit.amount_profit ) AS amount_profit
                          FROM
                          	investment
                          INNER JOIN
                            investment_profit ON investment_profit.id_invest = investment.id_invest
                          WHERE
                          	investment.id_person = ".$id." AND
                            investment_profit.amount_profit IS NOT NULL")->row();
  return $qry->amount_profit;
}


function total_investment_dividen($id){
  $ci=& get_instance();
  $qry = $ci->db->select("investment_dividen.id_invest_dividen,
                          investment_dividen.id_person,
                          investment_dividen.persentase,
                          SUM(investment_dividen.amount) AS amount_dividen")
                  ->from("investment_dividen")
                  ->where("investment_dividen.id_person",$id)
                  ->get()
                  ->row();
  return $qry->amount_dividen;
}



function total_all_deposit()
{
  $ci=& get_instance();
  $qry = $ci->db->query("SELECT
                              deposit.id_deposit,
                              SUM( deposit.amount_acc) AS amount,
                              deposit.status
                            FROM
                              	deposit
                            WHERE
                              deposit.status = 'approved'");
  return $qry->row()->amount;
}


function total_all_investasi_aktif()
{
  $ci=& get_instance();
  $qry = $ci->db->query("SELECT
                            investment.id_invest,
                            SUM(investment.amount) AS amount,
                            investment.status
                          FROM
                            investment
                          WHERE
                            investment.status = 'ongoing'");
  return $qry->row()->amount;
}


function total_all_investasi()
{
  $ci=& get_instance();
  $qry = $ci->db->query("SELECT
                            investment.id_invest,
                            SUM(investment.amount) AS amount,
                            investment.status
                          FROM
                            investment");
  return $qry->row()->amount;
}


function total_member($id_level)
{
  $ci=& get_instance();
  $qry = $ci->db->query("SELECT
                          tb_person.id_person,
                          tb_person.id_level
                        FROM
                          tb_person
                        WHERE
                          tb_person.id_level = $id_level");
  return $qry->num_rows();
}
