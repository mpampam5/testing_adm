<!DOCTYPE html>
<?php

 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename= data-deposit-$status-".date('d-m-y H-i-s').".xls");


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

      <p >DATA DEPOSIT <span style="color:#0b7ac2"><?=strtoupper($status)?></span> (export tanggal <?=date('d/m/Y')?> jam <?=date('H:i:s')?>)<br>

      <?=strtoupper(setting_system("alamat"))?></p>

    </center>

    <div class="row">
        <table border="1" style="margin: 20px auto;border-collapse: collapse;">
            <tr style="background:#282828;color:#e3b017">
              <th rowspan="2">No</th>
              <th rowspan="2">Tanggal Deposit</th>
              <th colspan="6">Data Member</th>
              <th colspan="3">Pembayaran Ke</th>
              <th colspan="4">Deposit</th>
            </tr>
            <tr style="background:#282828;color:#e3b017">

              <th>KD.REG</th>
              <th>Nik</th>
              <th>Nama</th>
              <th>Telepon</th>
              <th>Status Level</th>
              <th>Username</th>
              <th>Nama Rekening</th>
              <th>No. Rekening</th>
              <th>Bank</th>
              <th>Status</th>
              <th>Biaya Admin</th>
              <th>Jumlah</th>
              <th>Jumlah Acc</th>
            </tr>



            <?php
            $no = 1;
            $qry = $this->model->export($status); ?>
            <?php foreach ($qry->result() as $row): ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=date("d-m-Y",strtotime($row->created))?></td>
                <td><?=$row->kode_person?></td>
                <td style="mso-number-format:\@;"><?=$row->nik?></td>
                <td><?=$row->nama?></td>
                <td style="mso-number-format:\@;"><?=$row->telepon1?></td>
                <td><?=$row->level?></td>
                <td><?=$row->username?></td>
                <td><?=$row->nama_rekening?></td>
                <td style="mso-number-format:\@;"><?=$row->no_rekening?></td>
                <td><?=$row->bank?></td>
                <td><?=$row->status?></td>
                <td><?=$row->biaya_admin?></td>
                <td><?=$row->amount?></td>
                <td><?=$row->amount_acc?></td>
              </tr>
            <?php endforeach; ?>

        </table>
    </div>

  </body>
</html>
