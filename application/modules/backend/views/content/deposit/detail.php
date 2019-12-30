<div class="row">
  <div class="col-md-7 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Deposit</li>
        <li class="breadcrumb-item" aria-current="page"><?=$status?></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
      </ol>
    </nav>
  </div>

  <div class="col-md-7 mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title border-bottom">DETAIL DEPOSIT <span class="text-primary">#<?=$row->kode_transaksi?></span></h5>
        <table class="table-detail">
          <tr>
            <th>NO.REG</th>
            <td class="text-primary">: <?=$row->kode_transaksi?></td>
          </tr>

          <tr>
            <th>Date</th>
            <td>: <?=date('d/m/Y H:i',strtotime($row->created))?></td>
          </tr>

          <tr>
            <th>Amount</th>
            <td>: Rp.<?=format_rupiah($row->amount)?></td>
          </tr>

          <tr>
            <th>Biaya administrasi</th>
            <td>: Rp.<?=format_rupiah($row->biaya_admin)?></td>
          </tr>

          <?php if ($row->status=="approved"): ?>
            <tr>
              <th>Amount Acc</th>
              <td>: Rp.<?=format_rupiah($row->amount_acc)?></td>
            </tr>
          <?php endif; ?>

          <tr>
            <th>Status</th>
            <td>:
                  <?php if ($row->status=="approved"): ?>
                    <span class="badge badge-success"><?=$row->status?></span>
                  <?php endif; ?>

                  <?php if ($row->status=="process"): ?>
                    <span class="badge badge-warning text-white"><?=$row->status?></span>
                  <?php endif; ?>

                  <?php if ($row->status=="cancel"): ?>
                    <span class="badge badge-danger"><?=$row->status?></span>
                  <?php endif; ?>
              </td>
          </tr>

          <?php if ($row->status=="cancel"): ?>
          <tr>
            <th>Keterangan</th>
            <td>: <?=$row->keterangan?></td>
          </tr>
        <?php endif; ?>

        </table>

        <hr>
        <b class="pl-1 pb-1" style="font-size:13px;color:#5e5e5e;">Data Personal:</b>
        <table class="table-detail">
          <tr>
            <th>ID.REG</th>
            <td>: <?=$row->kode_person?></td>
          </tr>

          <tr>
            <th>Nama</th>
            <td>: <?=$row->nama?></td>
          </tr>

          <tr>
            <th>Username</th>
            <td>: <?=$row->username?></td>
          </tr>
        </table>

        <hr>
        <b class="pl-1 pb-1" style="font-size:13px;color:#5e5e5e;">Pembayaran Ke:</b>
        <table class="table-detail">
          <tr>
            <th>Nama Rek.</th>
            <td>: <?=$row->nama_rekening?></td>
          </tr>

          <tr>
            <th>No.Rek</th>
            <td>: <?=$row->no_rekening?></td>
          </tr>

          <tr>
            <th>BANK</th>
            <td>: <?=$row->bank?></td>
          </tr>
        </table>

        <?php if ($row->status=="process"): ?>
          <?php if (profile_admin("level")!="admin_supervisor"): ?>
          <hr>
          <div class="col-sm-8 mt-5 mx-auto">
            <form class="" action="<?=site_url("backend/deposit/status_action/process/".enc_uri($row->id_deposit))?>" id="form">
              <div class="form-group">
                <label for="">Jumlah deposit</label>
                <input type="text" class="form-control" readonly value="<?=format_rupiah(($row->amount+$row->biaya_admin))?>">
              </div>

              <div class="form-group">
                <label id="amount">Jumlah yang akan di proses</label>
                <input type="text" class="form-control rupiah" name="amount" value="<?=format_rupiah(substr($row->amount,0,-3)."000")?>">
                <span class="text-primary" style="font-size:10px">* Pastikan Amount sama dengan yang tertera pada bukti transfer</span>
              </div>

              <div class="form-group">
                <label id="status">Status</label>
                <select class="form-control" name="status" onchange="mySelect()" id="stats">
                  <option value="">--Pilih--</option>
                  <option value="approved">Approved</option>
                  <option value="cancel">Cancel</option>
                </select>
              </div>


              <div class="form-group" id="keterangan" style="display:none">
                <label for="">keterangan/Alasan</label>
                <textarea name="keterangan" class="form-control" rows="3" cols="80" placeholder="Masukkan keterangan/alasan"></textarea>
              </div>

              <div class="form-group">
                <label id="password">Passoword Verifikasi</label>
                <input type="password" class="form-control" name="password" placeholder="Masukkan Passoword">
              </div>

              <input type="hidden" name="id_person" value="<?=$row->id_person?>">


              <a href="javascript:history.back()" class="btn btn-sm btn-secondary text-white">Back</a>
              <button type="submit" class="btn btn-sm btn-primary" name="submit" id="submit">Proses</button>
            </form>
          </div>
        <?php endif; ?>
        <?php endif; ?>


      </div>
    </div>
  </div>


</div>


<?php if ($row->status=="process"): ?>
  <script type="text/javascript">
$(document).ready(function(){
  $('.rupiah').mask('00.000.000.000', {reverse: true});
});


function mySelect() {
  var x = document.getElementById("stats").value;
  if (x==="cancel") {
    $("#keterangan").fadeIn(500).show();
  }else {
    $("#keterangan").fadeOut(500);
  }
}


$("#form").submit(function(e){
e.preventDefault();
var me = $(this);
$("#submit").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Loading...');
$.ajax({
      url             : me.attr('action'),
      type            : 'post',
      data            :  new FormData(this),
      contentType     : false,
      cache           : false,
      dataType        : 'JSON',
      processData     :false,
      success:function(json){
        if (json.success==true) {
            $.toast({
              text: json.alert,
              showHideTransition: 'slide',
              icon: 'success',
              loaderBg: '#f96868',
              position: 'bottom-right',
              afterHidden: function () {
                  location.href=json.url;
              }
            });
        }else {
          $("#submit").prop('disabled',false)
                      .html('Proses');
          $.each(json.alert, function(key, value) {
            var element = $('#' + key);
            $(element)
            .closest('.form-group')
            .find('.text-danger').remove();
            $(element).after(value);
          });
        }
      }
});
});
</script>
<?php endif; ?>
