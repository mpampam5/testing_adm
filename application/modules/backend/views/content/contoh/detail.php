<div class="row">
  <div class="col-md-10 mx-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-black">
        <li class="breadcrumb-item" aria-current="page"><?=ucfirst($title)?></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
      </ol>
    </nav>
  </div>

  <div class="col-md-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <table class="table-detail">
          <tr>
            <th>Nama</th>
            <td>: <?=$row->nama?></td>
          </tr>

          <tr>
            <th>Email</th>
            <td>: <?=$row->email?></td>
          </tr>

          <tr>
            <th>telepon</th>
            <td>: <?=$row->telepon?></td>
          </tr>

        </table>

        <hr>

        <a href="<?=site_url("backend/".$this->uri->segment(2))?>" class="btn btn-sm btn-secondary text-white"> Back</a>
      </div>
    </div>
  </div>
</div>
