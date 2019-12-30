<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="<?=base_url()?>_template/backend/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>


<div class="row">
  <div class="col-md-12 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($title)?></li>
      </ol>
    </nav>
  </div>


  <div class="col-md-12 grid-margin mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="col-12 mb-1">
          <button type="button" class="btn btn-primary btn-sm" id="search"><i class="fa fa-search"></i> Search</button>
          <button type="button" class="btn btn-warning btn-sm text-white" id="reload_table"><i class="fa fa-refresh"></i> Reload</button>

          <?php if (profile_admin("level")!="admin_supervisor"): ?>
          <div class="pull-right">
            <a href="<?=site_url("backend/investment/export_excel/1")?>" class="btn btn-success btn-sm text-white" target="_blank"><i class="fa fa-file-excel-o"></i> Export Tgl 01</a>
            <a href="<?=site_url("backend/investment/export_excel/15")?>" class="btn btn-success btn-sm text-white" target="_blank"><i class="fa fa-file-excel-o"></i> Export Tgl 15</a>
          </div>
        <?php endif; ?>
          
        </div>

        <div id="search_collapse" class="collapse col-12">
            <div class="stretch-card mb-1">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Search Filter </h4>
                  <hr>
                    <form id="form-filter" autocomplete="off">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">KD.INVESMENT</label>
                              <input type="text" class="form-control form-control-sm" id="kode_invest">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">ID.REG Member</label>
                              <input type="text" class="form-control form-control-sm" id="kode_person">
                            </div>
                          </div>

                          <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Nama Member </label>
                                <input type="text" class="form-control form-control-sm" id="nama">
                              </div>
                            </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Status</label>
                              <select class="form-control form-control-sm" id="status">
                                <option value=""></option>
                                <option value="ongoing"> Ongoing</option>
                                <option value="done"> Done</option>
                              </select>
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

        <div class="col-12 mx-auto">
            <table id="table" class="table table-bordered">
              <thead class=" bg-black text-silver">
                <tr>
                  <th>KD.INVESMENT</th>
                  <th>Date</th>
                  <th>Member</th>
                  <th>Amount</th>
                  <th>Is Parent</th>
                  <th>Status</th>
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
            "url": "<?php echo site_url('backend/investment/json')?>",
            "type": "POST",
            "data": function ( data ) {
                data.kode_invest = $('#kode_invest').val();
                data.kode_person = $('#kode_person').val();
                data.nama = $('#nama').val();
                data.status = $('#status').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "className": "text-center",
            "targets": 1,
        },
        {
            "targets": 2,
            "orderable": false,
        },
        {
            "targets": 4,
            "orderable": false,
        },
        {
            "className": "text-center",
            "targets": 5,
            "orderable": false
        },
        {
            "className": "text-center",
            "targets": 6,
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


</script>
