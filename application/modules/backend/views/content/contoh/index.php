<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="<?=base_url()?>_template/backend/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>


<div class="row">
  <div class="col-md-10 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($title)?></li>
      </ol>
    </nav>
  </div>


  <div class="col-md-10 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="col-12 mb-1">
          <a href="<?=site_url("backend/contoh/add")?>" class="btn btn-success btn-sm"><span class="ti-files"></span> Add</a>
          <button type="button" class="btn btn-primary btn-sm" id="search"><i class="fa fa-search"></i> Search</button>
          <button type="button" class="btn btn-warning btn-sm text-white" id="reload_table"><i class="fa fa-refresh"></i> Reload</button>
        </div>

        <div id="search_collapse" class="collapse col-12">
            <div class="stretch-card mb-1">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Search Filter </h4>
                  <hr>
                    <form id="form-filter" autocomplete="off">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Nama</label>
                              <input type="text" class="form-control form-control-sm" id="nama">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Telepon</label>
                              <input type="text" class="form-control form-control-sm" id="telepon">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Email</label>
                              <input type="text" class="form-control form-control-sm" id="email">
                            </div>
                          </div>

                        </div>

                        <button type="button" id="btn-filter" name="button" class="btn btn-sm btn-primary">Filter Search</button>
                        <button type="button" id="hide_collapse" class="btn btn-danger btn-sm">Cancel</button>


                    </form>

                </div>
              </div>
            </div>
          </div>

        <div class="col-12 mt-0">
            <table id="table" class="table table-bordered">
              <thead class=" bg-black text-silver">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>telepon</th>
                  <th>Email</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
            </table>
        </div>


      </div>
    </div>
  </div>


</div>


<script type="text/javascript">
$(document).ready(function(){
  var table;
  //datatables
    table = $('#table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "lengthChange": false,
        "searching": false,
        oLanguage: {
            sProcessing: '<div class="spinner-border spinner-border-sm text-warning"></div> Loading'
        },

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/contoh/json')?>",
            "type": "POST",
            "data": function ( data ) {
                data.nama = $('#nama').val();
                data.username = $('#telepon').val();
                data.email = $('#email').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "className": "text-center",
            "targets": 0, //first column / numbering column
            "orderable": false,
        },
        {
            "className": "text-center",
            "targets": 4,
            "orderable": false,
        },
        ],
      });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });

    $("#reload_table").click(function(){
      $('#form-filter')[0].reset();
      $("#search_collapse").collapse('hide');
        table.ajax.reload();
    });

    $("#search").click(function(){
      $("#search_collapse").collapse('toggle');
      $('#form-filter')[0].reset();
    });

    $("#hide_collapse").click(function(){
      $("#search_collapse").collapse('hide');
      $('#form-filter')[0].reset();
    });


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
              position: 'bottom-right'
            });
            $('#table').DataTable().ajax.reload();
          }
        });
});


</script>
