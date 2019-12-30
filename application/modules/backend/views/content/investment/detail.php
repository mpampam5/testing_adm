<?php
$parent = is_parent($row->id_person);
  if (profile_person($row->id_person,"id_level")=="4") {
    $is_prt =  '- <label><span class="text-primary">'.profile_person($parent[1],"level").'</span> : '.profile_person($parent[2],"nama").'</label></br>
                - <label><span class="text-primary">'.profile_person($parent[1],"level").'</span> : '.profile_person($parent[1],"nama").'</label></br>
                - <label><span class="text-primary">'.profile_person($parent[0],"level").'</span> : '.profile_person($parent[0],"nama").'</label>
                ';
  }elseif (profile_person($row->id_person,"id_level")=="3") {
    $is_prt =  '  - <label><span class="text-primary">'.profile_person($parent[1],"level").'</span> : '.profile_person($parent[1],"nama").'</label></br>
                  - <label><span class="text-primary">'.profile_person($parent[0],"level").'</span> : '.profile_person($parent[0],"nama").'</label>';
  }elseif (profile_person($row->id_person,"id_level")=="2") {
    $is_prt =  '- <label><span class="text-primary">'.profile_person($parent[0],"level").'</span> : '.profile_person($parent[0],"nama").'</label>';
  }else {
    $is_prt = "-";
  }
 ?>

<div class="row">
  <div class="col-md-7 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Invesment</li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
      </ol>
    </nav>
  </div>

  <div class="col-md-7 mx-auto mb-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title border-bottom">
          DETAIL INVESTMENT
          <span class="text-primary">#<?=$row->kode_invest?></span>
        </h5>
        <table class="table-detail">
          <tr>
            <th>Nama member</th>
            <td>: <span class="text-warning"><?=$row->kode_person?></span> **<?=$row->nama?></td>
          </tr>

          <tr>
            <th>KD.INVESTMENT</th>
            <td class="text-primary">: <?=$row->kode_invest?></td>
          </tr>

          <tr>
            <th>Date Invest</th>
            <td>: <?=date("d-m-Y",strtotime($row->created))?></td>
          </tr>

          <tr>
            <th>Amount</th>
            <td>: Rp.<?=format_rupiah($row->amount)?></td>
          </tr>


          <tr>
            <th>Masa Kontrak</th>
            <td>: <?=date("d-m-Y",strtotime($row->kontrak_start))?> s/d <?=date("d-m-Y",strtotime($row->kontrak_end))?></td>
          </tr>

          <tr>
            <th>Alamat Pengiriman SPK</th>
            <td>: <?=$row->alamat_kirim_spk?></td>
          </tr>


          <tr>
            <th>Status</th>
            <td>:
              <?php if ($row->status=="ongoing"): ?>
                <span class="badge badge-success">ongoing</span>
                <?php else: ?>
                <span class="badge badge-danger">done</span>
              <?php endif; ?>
            </td>
          </tr>
        </table>

        <table class="table-detail mt-3">


          <tr>
            <th>Is Parent</th>
            <td> <?=$is_prt;?></td>
          </tr>

          <?php if ($row->amount >= 5000000): ?>

          <tr>
            <th>Ukuran Baju</th>
            <td>: <span class="badge badge-pill badge-primary"><?=profile_person($row->id_person,"ukuran_baju")?></span></td>
          </tr>
        <?php endif; ?>
        </table>

        <?php if (profile_admin("level")!="admin_spk"): ?>
          <?php if (profile_admin("level")!="admin_supervisor"): ?>
          <a target="_blank" href="<?=site_url("backend/investment/get_spk/".enc_uri($row->id_invest))?>" class="btn btn-primary btn-sm text-white pull-right"><i class="ti-download"></i> Download SPK</a>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <div class="col-md-7 mx-auto mb-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Data Profit</h5>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">Date</th>
              <th class="text-center">Profit</th>
              <th class="text-center">Amount</th>
            </tr>
          </thead>

          <tbody>
            <?php $profit = $this->db->get_where("investment_profit",["id_invest"=>$row->id_invest]); ?>
            <?php foreach ($profit->result() as $profit): ?>
            <tr>
              <td class="text-center text-primary"><?=date("d-m-Y", strtotime($profit->time_profit))?></td>
              <td class="text-center"><?=$profit->name_profit?></td>
              <td class="text-center"><?=$profit->amount_profit!="" ? "Rp.".format_rupiah($profit->amount_profit):"-"?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>




  <style media="screen">
    .table-dividen tr td{
      font-size: 12px!important;
      padding: 4px!important;
    }
  </style>

  <?php
      $dividen = $this->db->select("investment_dividen.id_invest,
                                    investment_dividen.no_dividen,
                                    investment_dividen.time_dividen,
                                    investment_dividen.persentase,
                                    investment_dividen.amount,
                                    tb_person.kode_person,
                                    tb_person.nama,
                                    tb_person.id_level,
                                    level_person.level")
                          ->from("investment_dividen")
                          ->join("tb_person","tb_person.id_person = investment_dividen.id_person")
                          ->join("level_person","level_person.id_level = tb_person.id_level")
                          ->where("investment_dividen.id_invest",$row->id_invest)
                          ->order_by("no_dividen","asc")
                          ->order_by("id_level","asc")
                          ->get();
   ?>

<?php if ($dividen->num_rows() > 0): ?>
  <div class="col-md-7 mx-auto mb-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          Dividen
        </h5>
        <table class="table table-bordered table-dividen">
          <tr>
            <td class="text-danger">#</td>
            <td class="text-danger">Person</td>
            <td class="text-danger">Dividen</td>
          </tr>
          <?php foreach ($dividen->result() as $div): ?>
            <tr>
              <td><?=date('d-m-Y')?> | Profit Ke <?=$div->no_dividen?></td>
              <td>
                <?=$div->kode_person?> | <?=$div->level?><br>
                <label class="pt-2"><?=$div->nama?></label>
              </td>
              <td class="text-success">Rp.<?=format_rupiah($div->amount)?> (<?=$div->persentase?>%)</td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
<?php endif; ?>





</div>
