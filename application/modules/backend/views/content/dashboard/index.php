
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-5 mb-4 mb-xl-0">
                  <h4 class="font-weight-bold">Hi, Welcome!</h4>
                  <h4 class="font-weight-normal mb-0"><?=ucfirst(profile_admin("nama"))?></h4>
                </div>
                <div class="col-12 col-xl-7">
                  <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="border-left pl-2 mb-3 mb-xl-0">
                      <p class="text-muted"><i class="ti-user"></i> username</p>
                      <h4 class="mb-0 font-weight-bold"><?=profile_admin("username")?></h4>
                    </div>
                    <div class="border-left pl-2 mb-3 mb-xl-0">
                      <p class="text-muted"><i class="ti-email"></i> Email</p>
                      <h4 class="mb-0 font-weight-bold"><?=profile_admin("email")?></h4>
                    </div>
                    <div class="border-left pl-2 mb-3 mb-xl-0">
                      <p class="text-muted"><i class="ti-calendar"></i> Waktu Server</p>
                      <h4 class="mb-0 font-weight-bold text-success"><?=date_indo(date('Y-m-d')).'&nbsp;|&nbsp;'.date("H:i");?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



<?php if (profile_admin("level")!="admin_spk"): ?>
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card" style="background-color:#11a844;">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left text-white">Total Deposit</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <h5 class="mb-0 mb-md-2 mb-xl-0 order-md-1 text-white order-xl-0">Rp.<?=format_rupiah(total_all_deposit())?></h5>
                    <i class="ti-wallet icon-md text-white mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card" style="background-color:#dd4b39 ;">
                <div class="card-body">
                  <p class="card-title text-md-center text-white text-xl-left">Total Investasi Aktif</p>
                  <div class="d-flex flex-wrap text-white justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <h5 class="mb-0 mb-md-2 mb-xl-0 text-white order-md-1 order-xl-0">Rp.<?=format_rupiah(total_all_investasi_aktif())?></h5>
                    <i class="ti-layers-alt icon-md text-white mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card" style="background-color:#0b73d4;">
                <div class="card-body">
                  <p class="card-title text-md-center text-white text-xl-left">Total Semua Investasi</p>
                  <div class="d-flex flex-wrap text-white justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <h5 class="mb-0 mb-md-2 mb-xl-0 text-white order-md-1 order-xl-0">Rp.<?=format_rupiah(total_all_investasi())?></h5>
                    <i class="ti-layers-alt icon-md text-white mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card" style="background-color:#00c0ef;">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left text-white">Total Member</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <h5 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0 text-white"><?=total_member(4)?></h5>
                    <i class="ti-user icon-md text-white mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card" style="background-color:#11a844;">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left text-white">Total Agency</p>
                  <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <h5 class="mb-0 mb-md-2 mb-xl-0 order-md-1 text-white order-xl-0"><?=total_member(3)?></h5>
                    <i class="ti-user icon-md text-white mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card" style="background-color:#dd4b39 ;">
                <div class="card-body">
                  <p class="card-title text-md-center text-white text-xl-left">Total CO FOunder</p>
                  <div class="d-flex flex-wrap text-white justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <h5 class="mb-0 mb-md-2 mb-xl-0 text-white order-md-1 order-xl-0"><?=total_member(2)?></h5>
                    <i class="ti-user icon-md text-white mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card" style="background-color:#f39c12;">
                <div class="card-body">
                  <p class="card-title text-md-center text-white text-xl-left">Total Founder</p>
                  <div class="d-flex flex-wrap text-white justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                    <h5 class="mb-0 mb-md-2 mb-xl-0 text-white order-md-1 order-xl-0"><?=total_member(1)?></h5>
                    <i class="ti-user icon-md text-white mb-0 mb-md-3 mb-xl-0"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
<?php endif; ?>
