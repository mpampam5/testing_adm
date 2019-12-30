<div class="row">
  <div class="col-md-10 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Personal</li>
        <!-- <li class="breadcrumb-item" aria-current="page">Data <?=ucfirst($title)?></li> -->
        <li class="breadcrumb-item active" aria-current="page">Form <?=ucfirst($button)?></li>
      </ol>
    </nav>
  </div>



  <form action="<?=$action?>" id="form" autocomplete="off">
  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"> Data Personal</h5>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">NIK</label><span style="font-size:11px" class="text-primary pl-2">*</span>
                  <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" value="<?=$nik?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Nama</label><span style="font-size:11px" class="text-primary pl-2">* Sesuai nama pada buku rekening</span>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?=$nama?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Tempat Lahir</label><span style="font-size:11px" class="text-primary pl-2">* Sesuai kartu identitas</span>
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat lahir" value="<?=$tempat_lahir?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Tanggal Lahir</label><span style="font-size:11px" class="text-primary pl-2">* Sesuai kartu identitas</span>
                  <input type="text" class="form-control tanggal" id="tanggal_lahir" readonly name="tanggal_lahir" placeholder="Tanggal Lahir" value="<?=$tanggal_lahir?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Telepon 1</label><span style="font-size:11px" class="text-primary pl-2">* No.telepon yang aktif</span>
                  <input type="text" class="form-control" id="telepon1" name="telepon1" placeholder="Telepon 1"value="<?=$telepon1?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Telepon 2</label>
                  <input type="text" class="form-control" id="telepon2" name="telepon2" placeholder="Telepon 2"value="<?=$telepon2?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Email</label><span style="font-size:11px" class="text-primary pl-2">* Email harus aktif</span>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?=$email?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Pekerjaan</label>
                  <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan" value="<?=$pekerjaan?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Ukuran Baju</label>
                  <select class="form-control" id="ukuran_baju" name="ukuran_baju">
                    <option value="">-- pilih ukuran baju--</option>
                    <option <?=strtoupper($ukuran_baju)=="S" ? "selected" : ""?> value="S">S</option>
                    <option <?=strtoupper($ukuran_baju)=="M" ? "selected" : ""?> value="M">M</option>
                    <option <?=strtoupper($ukuran_baju)=="L" ? "selected" : ""?> value="L">L</option>
                    <option <?=strtoupper($ukuran_baju)=="XL" ? "selected" : ""?> value="XL">XL</option>
                    <option <?=strtoupper($ukuran_baju)=="XXL" ? "selected" : ""?> value="XXL">XXL</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Alamat</label><span style="font-size:11px" class="text-primary pl-2">* Sesuai kartu identitas/domisili</span>
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" rows="3" cols="80"><?=$alamat?></textarea>
                </div>
              </div>

            </div>

      </div>
    </div>
  </div>


  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"> Data Ahli Waris</h5>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Nama</label>
              <input type="text" class="form-control" id="nama_ahli_waris" name="nama_ahli_waris" placeholder="Nama" value="<?=$waris_nama?>">
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Hubungan Keluarga</label>
              <input type="text" class="form-control" id="hubungan_ahli_waris" name="hubungan_ahli_waris" placeholder="Hubungan Keluarga" value="<?=$waris_hubungan?>">
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Telepon</label>
              <input type="text" class="form-control" id="telepon_ahli_waris" name="telepon_ahli_waris" placeholder="Telepon" value="<?=$waris_telepon?>">
            </div>
          </div>

          <div class="col-sm-12">
            <div class="form-group">
              <label for="">Alamat</label>
              <textarea class="form-control" id="alamat_ahli_waris" name="alamat_ahli_waris" placeholder="Alamat" rows="3" cols="80"><?=$waris_alamat?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"> Data Rekening</h5>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Nama Rekening</label>
              <input type="text" class="form-control" id="nama_rekening" name="nama_rekening" placeholder="Nama Rekening" value="<?=$nama_rekening?>">
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="">No.rekening</label>
              <input type="text" class="form-control" id="no_rekening" name="no_rekening" placeholder="No.Rekening" value="<?=$no_rekening?>">
            </div>
          </div>


          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Bank</label>
              <select class="form-control" id="bank" name="bank">
                <option value="">-- pilih BANK --</option>
                <option <?=strtoupper($bank)=="BRI" ? "selected":""?> value="BRI">BRI</option>
                <option <?=strtoupper($bank)=="BCA" ? "selected":""?> value="BCA">BCA</option>
                <option <?=strtoupper($bank)=="MANDIRI" ? "selected":""?> value="MANDIRI">MANDIRI</option>
              </select>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"> Data account</h5>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Username</label><span style="font-size:11px" class="text-primary pl-2">*</span>
              <?php if ($button=="add"): ?>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?=$username?>">
                <?php else: ?>
                  <input type="text" class="form-control" readonly placeholder="Username" value="<?=$username?>">
                  <input type="hidden" name="nik_lama" value="<?=$nik?>">
                  <input type="hidden" name="email_lama" value="<?=$email?>">
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"> Status</h5>

        <div class="row">
          <?php if (profile_admin("level")!="superadmin"): ?>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Status Aktif</label>
                <input class="form-control" type="text" readonly value="<?=$status=="1" ? "ON" : "OFF"?>">
                <input type="hidden" id="status" name="status" value="<?=$status?>">
              </div>
            </div>
            <?php else: ?>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Status Aktif</label>
                  <select class="form-control" id="status" name="status">
                    <option <?=$status=="1" ? "selected" : ""?> value="1">ON</option>
                    <option <?=$status=="0" ? "selected" : ""?> value="0">OFF</option>
                  </select>
                </div>
              </div>
          <?php endif; ?>


          <?php if ($button!="update"): ?>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Status Personal</label><span style="font-size:11px" class="text-primary pl-2">*</span>
                <select class="form-control" id="status_level" name="status_level" onChange="FunctionReset()">
                  <option value="">-- pilih --</option>
                  <option <?=$level==1 ? "selected" : ""?> data-op="0" value="1">FOUNDER</option>
                  <option <?=$level==2 ? "selected" : ""?> data-op="1" value="2">CO FOUNDER</option>
                  <option <?=$level==3 ? "selected" : ""?> data-op="2" value="3">AGENCY</option>
                  <option <?=$level==4 ? "selected" : ""?> data-op="3" value="4">MEMBER</option>
                </select>
              </div>
            </div>


            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Is Parent</label><span style="font-size:11px" class="text-primary pl-2">*</span>
                <div class="input-group">
                  <input type="text" id="name-parent" class="form-control" value="<?=$is_parent=="0"? "admin":dataname($is_parent)?>">
                  <div class="input-group-append">
                    <button class="btn btn-sm btn-primary" id="add_parent" type="button">Add parent</button>
                  </div>
                </div>
                <input type="hidden" name="id_parent" id="id_parent" value="<?=$is_parent?>">
              </div>
            </div>

            <?php else: ?>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Status Personal</label>
                  <input type="text" class="form-control" readonly value="<?=level_person($level,"level")?>">
                  <input type="hidden" id="status_level" name="status_level" value="<?=$level?>">
                </div>
              </div>


              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Is Parent</label>
                  <input type="text" class="form-control" readonly value="<?=$is_parent=="0"? "admin":dataname($is_parent)?>">
                  <input type="hidden" name="id_parent" id="id_parent" value="<?=$is_parent?>">
                </div>
              </div>


          <?php endif; ?>





        </div>
      </div>
    </div>
  </div>

  <div class="col-md-10 grid-margin mx-auto">
        <div class="row">
          <div class="col-sm-12 m-t-20">
            <a href="javascript:history.back()" class="btn btn-sm btn-secondary text-white"> Cancel</a>
            <button type="submit" name="button" id="submit" class="btn btn-primary btn-sm"> <?=ucfirst($button)?></button>
          </div>
        </div>
  </div>


</form>

</div>

<script type="text/javascript">
$(document).ready(function(){
$('.tanggal').datepicker({
  format: 'yyyy-mm-dd',
  autoclose: true
});
});


<?php if ($button!="update"): ?>
function FunctionReset(){
  var status_level = $("#status_level").val();
  if (status_level=="1") {
    $("#name-parent").val("admin");
    $("#id_parent").val("0");
    $("#add_parent").prop('disabled',true);
  }else {
    $("#add_parent").prop('disabled',false);
    if (status_level=="<?=$level?>") {
      $("#name-parent").val("<?=dataname($is_parent)?>");
      $("#id_parent").val("<?=$is_parent?>");
    }else {
      $("#name-parent").val("");
      $("#id_parent").val("");
    }
  }
}

  $(document).on("click","#add_parent",function(e){
    e.preventDefault();
    var status_level = $("#status_level option:selected").attr("data-op");

    $('.modal-dialog').removeClass('modal-md')
                      .removeClass('modal-sm')
                      .addClass('modal-lg');
    if (status_level=="0") {
      $("#modalTitle").text('Alert');
      $('#modalContent').html("<h5 class='text-center'>Tidak ada pilihan untuk founder</h5>");
    }else if (status_level=="1") {
      $("#modalTitle").text('Founder');
      $('#modalContent').load("<?=base_url()?>backend/personal/add_parent/1");
    }else if (status_level=="2") {
      $("#modalTitle").text('CO Founder');
      $('#modalContent').load("<?=base_url()?>backend/personal/add_parent/2");
    }else if (status_level=="3") {
      $("#modalTitle").text('Agency');
      $('#modalContent').load("<?=base_url()?>backend/personal/add_parent/3");
    }else {
      $("#modalTitle").text('.');
      $('#modalContent').html("<h5 class='text-center'>silahkan pilih status level</h5>");
    }

    $("#modalGue").modal('show');
  });
<?php endif; ?>


$("#form").submit(function(e){
e.preventDefault();
var me = $(this);
$("#submit").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Processing...');
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
                      .html('<?=ucfirst($button)?>');
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
