<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name='robots' content='noindex, follow' />
  <title><?=$title?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?=base_url()?>_template/backend/css/style.css">
  <link rel="stylesheet" href="<?=base_url()?>_template/backend/css/custom.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?=base_url()?>_template/backend/images/favicon.png" />

  <link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/jquery-toast-plugin/jquery.toast.min.css">
  <link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <!-- plugins:js -->
  <script src="<?=base_url()?>_template/backend/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?=base_url()?>_template/backend/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>


</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="<?=site_url("backend/dashboard")?>"><img src="<?=base_url()?>_template/backend/images/logo-white.png" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="<?=site_url("backend/dashboard")?>"><img src="<?=base_url()?>_template/backend/images/cheeta.png" alt="logo"/></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="ti-menu"></span>
            </button>
          </div>
        </div>
      </nav>
      <nav class="bottom-navbar">
        <div class="container">
          <ul class="nav page-navigation">
            <li class="nav-item">
              <a class="nav-link" href="<?=site_url("backend/dashboard")?>">
                <i class="ti-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>


            <?php if (profile_admin("level")!="admin_spk"): ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="ti-user menu-icon"></i>
                <span class="menu-title">Personal</span>
                <i class="menu-arrow"></i></a>
              <div class="submenu">
                <ul class="submenu-item">
                  <?php if (profile_admin("level")!="admin_supervisor"): ?>
                    <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/personal/add")?>">Add Personal</a></li>
                  <?php endif; ?>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/founder")?>">Data Founder</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/co_founders")?>">Data CO Founder</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/agency")?>">Data Agency</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/member")?>">Data Member</a></li>
                </ul>
              </div>
            </li>
            <?php endif; ?>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="ti-receipt menu-icon"></i>
                <span class="menu-title">Invesment</span>
                <i class="menu-arrow"></i></a>
              <div class="submenu">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/investment")?>">All Investment</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/investment/profit")?>">Share Profit</a></li>
                </ul>
              </div>
            </li>

            <?php if (profile_admin("level")!="admin_spk"): ?>
            <li class="nav-item">
              <a href="<?=site_url("backend/investment/dividen")?>" class="nav-link">
                <i class="ti-stats-up menu-icon"></i>
                <span class="menu-title">Comission</span></a>
            </li>
            <?php endif; ?>

            <?php if (profile_admin("level")!="admin_spk"): ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="ti-share-alt menu-icon"></i>
                <span class="menu-title">Deposit</span>
                <i class="menu-arrow"></i></a>
              <div class="submenu">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/deposit/get/process")?>">Proccess</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/deposit/get/approved")?>">Approved</a></li>
                </ul>
              </div>
            </li>
            <?php endif; ?>


            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa fa-cogs menu-icon"></i>
                <span class="menu-title">Setting</span>
                <i class="menu-arrow"></i></a>
              <div class="submenu">
                <ul class="submenu-item">
                  <?php if (profile_admin("level")=="superadmin"): ?>
                    <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/setting_general")?>">General</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/administrator")?>">Administrator</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/setting_financial")?>">Financial</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/setting_rekening")?>">Rekening</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/admin")?>">Admin</a></li>
                  <?php endif; ?>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/pengeluaran_baju")?>">Data Pengeluaran Baju</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?=site_url("backend/reset_password")?>">Ganti Password</a></li>
                </ul>
              </div>
            </li>


            <li class="nav-item">
              <a href="<?=site_url("logout")?>" class="nav-link">
                <i class="ti-power-off menu-icon"></i>
                <span class="menu-title">Logout</span></a>
            </li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
