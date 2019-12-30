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



  <div class="col-md-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="btn-group-header">
          <a href="#" class="btn btn-primary btn-sm btn-icon-text" id="table-reload"> <i class="fa fa-refresh btn-icon-prepend"></i></a>
          <a href="<?=site_url("backend/admin/add")?>" class="btn btn-success btn-sm btn-icon-text"><i class="fa fa-plus btn-icon-prepend"></i> Tambah</a>
        </div>

      <hr>

        <div class="col-sm-12">
          <table id="table" class="table table-bordered">
            <thead class="text-yell bg-black">
              <tr>
                  <th width="10px">No</th>
                  <th>Nama</th>
                  <th>Telepon</th>
                  <th>Email</th>
                  <th>Actions</th>
              </tr>
            </thead>

          </table>
        </div>
      </div>
    </div>

  </div>

</div>


<script type="text/javascript">
$(document).ready(function() {
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
    {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };

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
          searching : false,
          serverSide: true,
          ajax: {"url": "<?=base_url()?>backend/admin/json", "type": "POST"},
          columns: [
              {
                  "data": "id",
                  "orderable": false
              },
              {"data":"nama"},
              {"data":"telepon"},
              {
                "data":"email"
              },
              {
                  "data" : "action",
                  "orderable": false,
                  "className" : "text-center"
              }
          ],
          order: [[0, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              var index = page * length + (iDisplayIndex + 1);
              $('td:eq(0)', row).html(index);
          }
      });
});


$(document).on("click","#delete",function(e){
  e.preventDefault();
  $('.modal-dialog').removeClass('modal-lg')
                    .removeClass('modal-md')
                    .addClass('modal-sm');
  $("#modalTitle").text('Please Confirm');
  $('#modalContent').html(`<p>Yakin ingin menghapus?</p><br>
                            <button type='button' class='btn btn-secondary text-white btn-sm' data-dismiss='modal'>Tidak</button>
                            <button type='button' class='btn btn-primary btn-sm' id='ya-hapus'  data-url=`+$(this).attr('href')+`>Ya, Saya Ingin</button>
                          `);
  $("#modalGue").modal('show');
});

$(document).on('click','#ya-hapus',function(e){
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
