<!DOCTYPE html>
<?php

 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename= data-pengeluaran_baju-".date('d-m-y H-i-s').".xls");


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

      <p >DATA PENGELUARAN BAJU (export tanggal <?=date('d/m/Y')?> jam <?=date('H:i:s')?>)<br>

      <?=strtoupper(setting_system("alamat"))?></p>


      <span class="badge badge-primary ml-3" style="font-size:16px;">S : <?=$this->model->get_baju("S")?></span> |
      <span class="badge badge-primary ml-3" style="font-size:16px;">M : <?=$this->model->get_baju("M")?></span> |
      <span class="badge badge-primary ml-3" style="font-size:16px;">L : <?=$this->model->get_baju("L")?></span> |
      <span class="badge badge-primary ml-3" style="font-size:16px;">XL : <?=$this->model->get_baju("XL")?></span> |
      <span class="badge badge-primary ml-3" style="font-size:16px;">XXL : <?=$this->model->get_baju("XXL")?></span>

    </center>

    <div class="row">
        <table border="1" style="margin: 20px auto;border-collapse: collapse;">
            <tr style="background:#282828;color:#e3b017">
              <th>No</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Ukuran Baju</th>
              <th>Status</th>
            </tr>




            <?php $no = 1;?>
            <?php foreach ($row as $row): ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=$row->nama?></td>
                <td><?=$row->username?></td>
                <td><?=$row->ukuran_baju?></td>
                <td><?=$row->status=="sudah"? "SUDAH TERKIRIM":"BELUM TERKIRIM"?></td>
              </tr>
            <?php endforeach; ?>

        </table>
    </div>

  </body>
</html>
