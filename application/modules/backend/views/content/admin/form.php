<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="<?=base_url()?>_template/backend/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<div class="row">
  <div class="col-md-7 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item" aria-current="page"><?=ucfirst($title)?></li>
        <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($button)?></li>
      </ol>
    </nav>
  </div>



  <div class="col-md-7 mx-auto">
    <div class="card">
      <div class="card-body">
        <form action="<?=$action?>" id="form" autocomplete="off">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?=$nama?>">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Telepon</label>
                  <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Telepon" value="<?=$telepon?>">
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?=$email?>">
                </div>
              </div>


              <div class="col-sm-12">
                <a href="<?=site_url("backend/".$this->uri->segment(2))?>" class="btn btn-sm btn-secondary text-white"> Cancel</a>
                <button type="submit" name="button" id="submit" class="btn btn-primary btn-sm"> <?=$button?></button>
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
  $("#submit").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Memproses...');
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
              $('.form-group').removeClass('.has-error')
                              .removeClass('.has');
              $.toast({
                text: json.alert,
                showHideTransition: 'slide',
                icon: "success",
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
