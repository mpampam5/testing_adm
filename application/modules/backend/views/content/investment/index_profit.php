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
        <li class="breadcrumb-item" aria-current="page">Investment</li>
        <li class="breadcrumb-item active" aria-current="page">Share Profit</li>
      </ol>
    </nav>
  </div>

    <div class="col-md-12 mx-auto">
      <div class="card">
        <div class="card-body">
            <table id="table" class="table table-bordered">
              <thead class=" bg-black text-silver">
                <tr>
                  <th></th>
                  <th>Date</th>
                  <th>KD.INVEST <i class="ti-angle-double-right"></i> Profit <i class="ti-angle-double-right"></i> Username <i class="ti-angle-double-right"></i> Nama</th>
                  <th>Total Invest</th>
                  <th>Profit</th>
                </tr>
              </thead>


            </table>
        </div>
      </div>
    </div>

</div>

<script type="text/javascript">
$(document).ready(function() {
    var table_profit = $("#table").dataTable({
        oLanguage: {
            sProcessing: '<div class="spinner-border spinner-border-sm text-warning"></div> Loading'
        },
        "searching": false,
        "info": false,
        processing: true,
        serverSide: true,
        ajax: {"url": "<?=base_url()?>backend/investment/json_profit", "type": "POST"},
        columns: [
            {
              "data": "id_invest_profit",
              "visible":false,
              searchable: false
            },
            {"data":"time_profit"},
            {
              "data":"kode_invest",
              "orderable": false,
              render:function(data,type,row,meta)
              {
                return '<span class="text-primary">'+data+'</span> <i class="ti-angle-double-right"></i> <span class="text-danger">Profit Ke '+row.no_profit+'</span> <i class="ti-angle-double-right"></i> <span class="text-primary">'+row.username+'</span> <i class="ti-angle-double-right"></i> <span class="text-primary">'+row.nama+'</span>';
              }
            },
            {
              "data":"amount",
              render:function(data,type,row,meta)
              {
                return '<span class="text-success">Rp.'+data+'</span>';
              }
            },
            {
              "data":"amount_profit",
              render:function(data,type,row,meta)
              {
                return '<span class="text-success">Rp.'+data+'</span>';
              }
            },
            {"data":"no_profit","visible":false},
            {"data":"nama","visible":false},
            {"data":"username","visible":false},
        ],
        order: [[0, 'DESC']],
    });
});
</script>
