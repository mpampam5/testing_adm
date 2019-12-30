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


  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="col-12 mb-1">
          <a href="<?=site_url("backend/setting_rekening/add")?>" class="btn btn-success btn-sm"><span class="ti-files"></span> Add</a>
        </div>


        <div class="col-12 mt-0">
            <table id="table" class="table table-bordered">
              <thead class=" bg-black text-silver">
                <tr>
                  <th>Nama Rekening</th>
                  <th>No.Rekening</th>
                  <th>Bank</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($row->result() as $rek): ?>
                <tr>
                  <td><?=$rek->nama_rekening?></td>
                  <td><?=$rek->no_rekening?></td>
                  <td><?=$rek->bank?></td>
                  <td>
                    <a href="<?=site_url("backend/setting_rekening/update/".enc_uri($rek->id_rekening))?>" class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="UPDATE"><i class="ti-pencil-alt"></i></a>
                    <a href="<?=site_url("backend/setting_rekening/delete/".enc_uri($rek->id_rekening))?>" class="badge badge-danger" id="delete" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="REMOVE"><i class="ti-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
        </div>

      </div>
    </div>
  </div>


</div>


<script type="text/javascript">
$('#table').DataTable({
    "lengthChange": false,
    "searching": false,
    "ordering":false,
    "columnDefs": [
      {
          "className": "text-center",
          "targets": 3
      },
    ],
  });

$(document).on("click","#delete",function(e){
  e.preventDefault();
  $('.modal-dialog').removeClass('modal-lg')
                    .removeClass('modal-md')
                    .addClass('modal-sm');
  $("#modalTitle").text('Please Confirm');
  $('#modalContent').html(`<p class="pb-3">Are you sure you want to delete?</p>
                            <button type='button' class='btn btn-secondary text-white btn-sm' data-dismiss='modal'>Cancel</button>
                            <button type='button' class='btn btn-primary btn-sm' id='ya-hapus' data-id=`+$(this).attr('alt')+`  data-url=`+$(this).attr('href')+`>Yes, i'm sure</button>
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
