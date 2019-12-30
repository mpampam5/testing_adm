<div class="row">
  <div class="col-md-10 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($title)?></li>
      </ol>
    </nav>
  </div>

  <div class="col-md-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <table class="table-detail">
          <tr>
            <th>Nama Perusahaan</th>
            <td>: <?=strtoupper($row->title)?></td>
          </tr>

          <tr>
            <th>Email</th>
            <td>: <?=$row->email?></td>
          </tr>

          <tr>
            <th>Telepon 1</th>
            <td>: <?=$row->telepon1?></td>
          </tr>

          <tr>
            <th>Telepon 2 (Wa)</th>
            <td>: <?=$row->telepon2?></td>
          </tr>

          <tr>
            <th>Alamat</th>
            <td>: <?=$row->alamat?></td>
          </tr>

        </table>

        <hr>

        <a href="<?=site_url("backend/setting_general/update/".enc_uri($row->id_setting_system))?>" class="btn btn-sm btn-primary text-white"><i class="ti-pencil-alt"></i> Update</a>

      </div>
    </div>
  </div>


  <div class="col-md-10 mx-auto mt-2">
    <div class="card">
      <div class="card-body">
        <!-- <h5 class="card-title"></h5> -->

        <div class="col-sm-12">
        <div id="data-info"></div>
        <div class="form-group" id="foto">
          <label class="label-title" id="foto_personal">Background Login</label>
          <input type="file" name="foto_personal" id="upload-foto" class="file-upload-default" accept="image/JPEG">
          <div class="input-group col-xs-12">
            <input type="text" name="foto_personal" id="image-foto" class="form-control file-upload-info" value="<?=setting_system("background")?>" readonly placeholder="Upload File">
            <span class="input-group-append">
              <button class="file-upload-browse btn btn-primary" id="btn-upload-foto" type="button">Pilih Gambar</button>
            </span>
          </div>
          <span class="text-primary mt-1" style="font-size:12px">* Max ukuran gambar 1mb dan format jpg. untuk kualitas yang bagus dimensi gambar 1280x682 pixel</span>

        </div>
      </div>

      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
$(function () {
    var fileupload = $("#upload-foto");
    var button = $("#btn-upload-foto");
    button.click(function () {
        fileupload.click();
    });
    fileupload.change(function () {
        var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
        // $("#data-info").text(fileName);

        var file_data = $('#upload-foto').prop('files')[0];
        var form_data = new FormData();
        $("#image-foto").val(fileName);
        $("#btn-upload-foto").html('<div class="spinner-border spinner-border-sm text-white"></div>');

        form_data.append('foto_personal', file_data);

        $.ajax({
            url: '<?=site_url("backend/setting_general/do_upload")?>',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(json){
              if (json.success==true) {
                button.html('Upload');
                $("#image-foto").val(json.file_name);
                $("#foto_personal")
                .closest('.form-group')
                .find('.error').remove();
                $.toast({
                  text: json.alert,
                  showHideTransition: 'slide',
                  icon: json.header_alert,
                  loaderBg: '#f96868',
                  position: 'top-center',
                });

              }else {
                button.html('Pilih Gambar');
                $("#foto_personal")
                .closest('.form-group')
                .find('.error').remove();
                $.toast({
                  text: json.alert,
                  showHideTransition: 'slide',
                  icon: json.header_alert,
                  loaderBg: '#f96868',
                  position: 'top-center',
                });
              }
            }
        });

    });
});
</script>
