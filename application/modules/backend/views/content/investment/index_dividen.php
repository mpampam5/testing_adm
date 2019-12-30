<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="<?=base_url()?>_template/backend/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>

<style media="screen">
  tr td .data-person-mem{
    padding-right: 10px;
  }
</style>

<div class="row">
  <div class="col-md-12 mx-auto">
    <nav aria-label="breadcrumb mb-1">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item active" aria-current="page">Comission</li>
      </ol>
    </nav>
  </div>

    <div class="col-md-12 mx-auto">
      <div class="card">
        <div class="card-body">
          <?php if (profile_admin("level")!="admin_supervisor"): ?>
          <div class="pull-right">
            <a href="<?=site_url("backend/investment/export_excel_dividen/1")?>" class="btn btn-success btn-sm text-white" target="_blank"><i class="fa fa-file-excel-o"></i> Export Tgl 01</a>
            <a href="<?=site_url("backend/investment/export_excel_dividen/15")?>" class="btn btn-success btn-sm text-white" target="_blank"><i class="fa fa-file-excel-o"></i> Export Tgl 15</a>
          </div>
          <?php endif; ?>
            <table id="table" class="table table-bordered">
              <thead class=" bg-black text-silver">
                <tr>
                  <th></th>
                  <th>Date</th>
                  <th>KD.INVEST <i class="ti-angle-double-right"></i> Amount <i class="ti-angle-double-right"></i> Profit</th>
                  <th>Data Penerima</th>
                  <th>Dividen</th>
                </tr>
              </thead>


            </table>
        </div>
      </div>
    </div>

</div>

<script type="text/javascript">
$(document).ready(function() {
    var table_dividen = $("#table").dataTable({
        oLanguage: {
            sProcessing: '<div class="spinner-border spinner-border-sm text-warning"></div> Loading'
        },
        "searching": false,
        "info": false,
        processing: true,
        serverSide: true,
        ajax: {"url": "<?=base_url()?>backend/investment/json_dividen", "type": "POST"},
        columns: [
            {
              "data": "id_invest_dividen",
              "visible":false,
              searchable: false
            },
            {"data":"time_dividen"},
            {
              "data":"kode_invest",
              "orderable": false,
              render:function(data,type,row,meta)
              {
                return '<span class="text-primary">'+data+'</span><i class="ti-angle-double-right"></i> <span class="text-success">Rp.'+row.amount_invest+'</span> <i class="ti-angle-double-right"></i> <span class="text-danger">Profit Ke '+row.no_dividen+'</span>';
              }
            },
            {
              "data":"kode_person",
              render:function(data,type,row,meta)
              {
                return '<span class="text-primary">'+data+'</span> <i class="ti-angle-double-right"></i> <span class="text-success">'+row.nama+'</span> <i class="ti-angle-double-right"></i> <span class="text-danger">'+row.level+'</span>';
              }
            },
            {
              "data":"amount_dividen",
              render:function(data,type,row,meta)
              {
                return '<span class="text-success">Rp.'+data+'('+row.persentase+'%)</span>';
              }
            },
            {"data":"no_dividen","visible":false},
            {"data":"persentase","visible":false},
            {"data":"nama","visible":false},
            {"data":"level","visible":false},
        ],
        order: [[0, 'DESC']],
    });
});
</script>
