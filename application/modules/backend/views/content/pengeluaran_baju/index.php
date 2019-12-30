<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="<?=base_url()?>_template/backend/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<div class="row">
  <div class="col-md-10 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page">Setting</li>
        <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($title)?></li>
      </ol>
    </nav>
  </div>

  <div class="col-md-10 mx-auto mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="mb-1">
          <span class="badge badge-primary ml-3" style="font-size:16px;">S : <?=$this->model->get_baju("S")?></span>
          <span class="badge badge-primary ml-3" style="font-size:16px;">M : <?=$this->model->get_baju("M")?></span>
          <span class="badge badge-primary ml-3" style="font-size:16px;">L : <?=$this->model->get_baju("L")?></span>
          <span class="badge badge-primary ml-3" style="font-size:16px;">XL : <?=$this->model->get_baju("XL")?></span>
          <span class="badge badge-primary ml-3" style="font-size:16px;">XXL : <?=$this->model->get_baju("XXL")?></span>
        </div>

        <hr>

        <?php if (profile_admin("level")!="admin_supervisor"): ?>
        <a href="<?=site_url("backend/pengeluaran_baju/export")?>" class="btn btn-sm btn-success"> <i class="ti ti-file"></i> Export Excel</a>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <div class="col-md-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <table id="table" class="table table-bordered table-striped">
          <thead class="bg-black text-yell">
            <tr>
              <th></th>
              <th>Nama & Username</th>
              <th>Ukuran Baju</th>
              <th>Status</th>
              <th>#</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>

</div>


<script type="text/javascript">
$(document).ready(function() {


      var t = $("#table").dataTable({
          initComplete: function() {

            $(document).on('click', '#table-reload', function(){
                api.search('').draw();
                $('#table_filter input').val('');
              });

              var api = this.api();
              $('#table_filter input')
                      .off('.DT')
                      .on('keyup.DT', function(e) {
                          if (e.keyCode == 13) {
                              api.search(this.value).draw();
                  }
              });
          },
          oLanguage: {
              sProcessing: "Memuat Data..."
          },
          processing: true,
          serverSide: true,
          ajax: {"url": "<?=base_url()?>backend/pengeluaran_baju/json", "type": "POST"},
          columns: [
              {
                  "data": "id",
                  "orderable": false,
                  "visible":false
              },
              {
                "data":"nama",
                "orderable": false,
                render:function(data,type,row,meta)
                {
                  return data+'&nbsp;[<span class="text-primary"> '+row.username+' </span>]';
                }
              },
              {"data":"ukuran_baju","orderable": false,"class":"text-center"},
              {
                "data":"status",
                "orderable": false,
                "class":"text-center",
                render:function(data,type,row,meta)
                {
                  if (data=="sudah") {
                      return '<span class="badge badge-primary badge-pill">sudah di proses</span>';
                  }else {
                      return '<span class="badge text-white badge-warning badge-pill">belum di proses</span>';
                  }
                }
              },
              {
                  "data" : "action",
                  "orderable": false,
                  "className" : "text-center",
                  render:function(data,type,row,meta)
                  {
                    <?php if (profile_admin("level")!="admin_supervisor"): ?>
                    if (row.status=="sudah") {
                        return '<a href="<?=base_url()?>backend/pengeluaran_baju/ubah_status/'+row.id+'/belum" id="status_action" class="btn btn-danger btn-sm">batalkan proses</a>';
                    }else {
                        return '<a href="<?=base_url()?>backend/pengeluaran_baju/ubah_status/'+row.id+'/sudah" id="status_action" class="btn btn-success btn-sm">Set telah di proses</a>';
                    }
                    <?php else:?>
                    return "-";
                    <?php endif; ?>
                  }
              },
              {"data":"username","visible": false},
          ],
          order: [[0, 'desc']],

      });
});


$(document).on("click","#status_action",function(e){
  e.preventDefault();
  $('.modal-dialog').removeClass('modal-lg')
                    .removeClass('modal-md')
                    .addClass('modal-sm');
  $("#modalTitle").text('Please Confirm');
  $('#modalContent').html(`<p>Yakin ingin mengubah status?</p><br>
                            <button type='button' class='btn btn-secondary text-white btn-sm' data-dismiss='modal'>Tidak</button>
                            <button type='button' class='btn btn-primary btn-sm' id='ya-ubah'  data-url=`+$(this).attr('href')+`>Ya, Saya Ingin</button>
                          `);
  $("#modalGue").modal('show');
});

$(document).on('click','#ya-ubah',function(e){
  $(this).prop('disabled',true)
          .text('Processing...');
  $.ajax({
          url:$(this).data('url'),
          type:'post',
          cache:false,
          dataType:'json',
          success:function(json){
            $('#modalGue').modal('hide');
            $.toast({
              text: json.alert,
              showHideTransition: 'slide',
              icon: json.success,
              loaderBg: '#f96868',
              position: 'bottom-right',
              afterHidden: function () {
                  location.reload();
              }
            });
          }
        });
});
</script>
