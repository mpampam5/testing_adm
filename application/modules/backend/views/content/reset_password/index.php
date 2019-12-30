<div class="row">
  <div class="col-md-7 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item">Setting</li>
        <li class="breadcrumb-item active" aria-current="page">Ganti Password</li>
      </ol>
    </nav>
  </div>



  <div class="col-md-7 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <form action="<?=site_url("backend/reset_password/action")?>" id="form" autocomplete="off">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Username</label>
                  <input type="text" class="form-control" readonly value="<?=profile_admin("username")?>">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Masukkan Password lama</label>
                  <input type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Password Lama" >
                </div>
              </div>


              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Masukkan Password baru</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Ulangi Password baru</label>
                  <input type="password" class="form-control" id="v_password" name="v_password" placeholder="Ulangi Password">
                </div>
              </div>


              <div class="col-sm-12 m-t-20">
                <button type="submit" name="button" id="submit" class="btn btn-primary btn-sm"> Ganti Password</button>
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
                  location.reload();
              }
            });
        }else {
          $("#submit").prop('disabled',false)
                      .html('Ganti Password');
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
