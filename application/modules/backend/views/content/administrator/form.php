<div class="row">
  <div class="col-md-10 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item">Setting</li>
        <li class="breadcrumb-item" aria-current="page"><?=ucfirst($title)?></li>
        <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($button)?></li>
      </ol>
    </nav>
  </div>



  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <form action="<?=$action?>" id="form" autocomplete="off">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?=$nama?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Telepon</label>
                  <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Telepon"value="<?=$telepon?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?=$email?>">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Status</label>
                  <select class="form-control" name="is_active" id="is_active">
                    <?php if ($button!="update"): ?>
                      <option value="">-- Pilih --</option>
                    <?php endif; ?>
                    <option <?=($is_active=="y")?"selected":""?> value="y"> Aktif</option>
                    <option <?=($is_active=="n")?"selected":""?> value="n"> Tidak Aktif</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Level</label>
                  <select class="form-control" name="level" id="level">
                    <?php if ($button!="update"): ?>
                      <option value="">-- Pilih --</option>
                    <?php endif; ?>
                    <option <?=($level=="admin")?"selected":""?> value="admin"> Admin</option>
                    <option <?=($level=="admin_spk")?"selected":""?> value="admin_spk"> Admin SPK</option>
                    <option <?=($level=="admin_supervisor")?"selected":""?> value="admin_supervisor"> Admin Supervisor</option>
                    <option <?=($level=="superadmin")?"selected":""?> value="superadmin"> Superadmin</option>
                  </select>
                </div>
              </div>


              <?php if ($button!="update"): ?>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Ulangi Password</label>
                  <input type="password" class="form-control" id="v_password" name="v_password" placeholder="Ulangi Password">
                </div>
              </div>

              <?php endif; ?>

              <div class="col-sm-12 m-t-20">
                <a href="<?=site_url("backend/".$this->uri->segment(2))?>" class="btn btn-sm btn-secondary text-white"> Cancel</a>
                <button type="submit" name="button" id="submit" class="btn btn-primary btn-sm"> <?=ucfirst($button)?></button>
              </div>
            </div>

          </form>

      </div>
    </div>
  </div>

</div>

<script type="text/javascript">
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
                  location.href="<?=site_url('backend/'.$this->uri->segment(2))?>";
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
