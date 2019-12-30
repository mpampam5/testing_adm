<!DOCTYPE html>
<?php

 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename= data-personal-".date('d-m-y H-i-s').".xls");

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

      <p>DATA PERSONAL  (export tanggal <?=date('d/m/Y')?> jam <?=date('H:i:s')?>)<br>

      <?=strtoupper(setting_system("alamat"))?></p>

    </center>

    <div class="row">
        <table border="1" style="margin: 20px auto;border-collapse: collapse;">
            <tr style="background:#a70f0f;color:#ffffff">
              <th rowspan="2">No</th>
              <th rowspan="2">Tanggal Bergabung</th>
              <th colspan="10">Data Personal</th>
              <th colspan="3">Data Ahli Waris</th>
              <th colspan="3">Data Rekening</th>
              <th rowspan="2">Status</th>
            </tr>
            <tr style="background:#a70f0f;color:#ffffff">

              <th>ID.REG</th>
              <th>Username</th>
              <th>Nik</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Telepon 1</th>
              <th>Telepon 2</th>
              <th>Pekerjaan</th>
              <th>Alamat</th>
              <th>Balance</th>
              <th>Nama Ahli Waris</th>
              <th>Telepon Ahli Waris</th>
              <th>Alamat Ahli Waris</th>
              <th>Nama Rekening</th>
              <th>No. Rekening</th>
              <th>Bank</th>
            </tr>


            <?php
            $no = 1;
            $qry = $this->model->export($id_level); ?>
            <?php foreach ($qry->result() as $row): ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=date("d-m-Y",strtotime($row->created))?></td>
                <td><?=$row->kode_person?></td>
                <td><?=$row->username?></td>
                <td style="mso-number-format:\@;"><?=$row->nik?></td>
                <td><?=$row->nama?></td>
                <td><?=$row->email?></td>
                <td style="mso-number-format:\@;"><?=$row->telepon1?></td>
                <td style="mso-number-format:\@;"><?=$row->telepon2?></td>
                <td><?=$row->pekerjaan?></td>
                <td><?=$row->alamat?></td>
                <td>Rp.<?=format_rupiah(balance($row->id_person))?></td>
                <td><?=$row->waris_nama?></td>
                <td><?=$row->waris_telepon?></td>
                <td><?=$row->waris_alamat?></td>
                <td><?=$row->nama_rekening?></td>
                <td style="mso-number-format:\@;"><?=$row->no_rekening?></td>
                <td><?=$row->bank?></td>
                <td><?=$row->level?></td>
              </tr>
            <?php endforeach; ?>

        </table>
    </div>

  </body>
</html>
