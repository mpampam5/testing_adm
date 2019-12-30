<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="<?=base_url()?>_template/backend/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="table-modal">
      <thead class="text-silver bg-black">
        <tr>
          <th></th>
          <th>ID.REG</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Pilih</th>
        </tr>
      </thead>
    </table>

    <button type='button' class='btn btn-secondary text-white btn-sm' data-dismiss='modal'>Cancel</button>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    var t = $("#table-modal").dataTable({
        oLanguage: {
            sProcessing: "Memuat Data..."
        },
        "bLengthChange": false,
        "ordering": false,
        processing: true,
        serverSide: true,
        ajax: {"url": "<?=base_url()?>backend/personal/json_personal/<?=$id?>", "type": "POST"},
        columns: [
            {
              "data": "id_person",
              "orderable": false,
              "visible":false
            },
            {"data":"kode_person"},
            {"data":"nama"},
            {"data":"username"},
            {
              "data":"action",
              "className": "text-center"
            },

        ],
        order: [[0, 'desc']],
    });
});


$(document).on("click","#pilih-person",function(e){
  e.preventDefault();
  $("#name-parent").val($(this).attr('data-nama'));
  $("#id_parent").val($(this).attr('data-id'));
  $("#modalGue").modal('hide');
});
</script>
