<!DOCTYPE html>
<?php

 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename= data-invest-".date('d-m-y H-i-s').".xls");


  ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      table tr th{
        padding:5px;
      }
    </style>
  </head>
  <body style="background-color:none!important;">
    <center>

      <h2 ><?=strtoupper(setting_system("title"))?></h2>

      <p >DATA INVESMENT (export tanggal <?=date('d/m/Y')?> jam <?=date('H:i:s')?>)<br>

      <?=strtoupper(setting_system("alamat"))?></p>

    </center>

    <div class="row">
        <table border="1" style="margin: 20px auto;border-collapse: collapse;">
            <tr style="background:#282828;color:#e3b017">
              <th rowspan="2">No</th>
              <th colspan="7">Data Member</th>
              <th colspan="3">Data Investasi</th>
              <th colspan="6">Profit</th>
            </tr>
            <tr style="background:#282828;color:#e3b017">

              <th>Data Member</th>
              <th>Founder</th>
              <th>Co Founder</th>
              <th>Agency</th>
              <th>Nama Rekening</th>
              <th>No. Rekening</th>
              <th>Bank</th>
              <th>kode_invest</th>
              <th>Masa Kontrak</th>
              <th>Jumlah Investasi</th>
              <th>Profit 1</th>
              <th>Profit 2</th>
              <th>Profit 3</th>
              <th>Profit 4</th>
              <th>Profit 5</th>
              <th>Profit 6</th>
            </tr>



            <?php
            $no = 1;
            $qry = $this->model->export_excel($group); ?>
            <?php foreach ($qry->result() as $row): ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=$row->kode_person?> | <span style="mso-number-format:\@;"><?="$row->nik"?></span> | <?=$row->nama?></td>
                <?php
                $parent = is_parent($row->id_person);
                  if (profile_person($row->id_person,"id_level")=="4") {
                    echo  ' <td>'.profile_person($parent[2],"nama").'</td>
                            <td>'.profile_person($parent[1],"nama").'</td>
                            <td>'.profile_person($parent[0],"nama").'</td>
                                ';
                  }elseif (profile_person($row->id_person,"id_level")=="3") {
                    echo  ' <td>'.profile_person($parent[1],"nama").'</td>
                            <td>'.profile_person($parent[0],"nama").'</td>
                            <td>-</td>';
                  }elseif (profile_person($row->id_person,"id_level")=="2") {
                    echo  ' <td>'.profile_person($parent[0],"nama").'</td>
                            <td>-</td>
                            <td>-</td>
                            ';
                  }else {
                    echo  ' <td>-</td>
                            <td>-</td>
                            <td>-</td>';
                  }
                 ?>


                <td><?=$row->nama_rekening?></td>
                <td style="mso-number-format:\@;"><?=$row->no_rekening?></td>
                <td><?=strtoupper($row->bank)?></td>
                <td><?=$row->kode_invest?></td>
                <td><?=date("d-m-Y",strtotime($row->kontrak_start))?> s/d <?=date("d-m-Y",strtotime($row->kontrak_end))?></td>
                <td><?=$row->amount?></td>
                <?php $profit = $this->db->get_where("investment_profit",["id_invest"=>$row->id_invest]); ?>
                <?php foreach ($profit->result() as $key): ?>
                  <td><?=$key->amount_profit?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>

        </table>
    </div>

  </body>
</html>
