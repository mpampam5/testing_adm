<div class="row">
  <div class="col-md-8 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item" aria-current="page"><?=ucfirst($title)?></li>
        <li class="breadcrumb-item active" aria-current="page">Form <?=ucfirst($button)?></li>
      </ol>
    </nav>
  </div>



  <div class="col-md-8 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <form action="<?=$action?>" id="form" autocomplete="off">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Nama Perusahaan</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Perusahaan" value="<?=$nama?>">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Telepon 1</label>
                  <input type="text" class="form-control" id="telepon1" name="telepon1" placeholder="Telepon"value="<?=$telepon1?>">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Telepon 2 (wa)</label>
                  <input type="text" class="form-control" id="telepon2" name="telepon2" placeholder="Telepon"value="<?=$telepon2?>">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?=$email?>">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Alamat</label>
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" rows="4" cols="80"><?=$alamat?></textarea>
                </div>
              </div>


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
