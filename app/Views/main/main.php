<?php
$request = \Config\Services::request();
$cek = $request->uri->getSegment(2);

if (!empty($request->uri->getSegment(3))) {
  $cek2 = $request->uri->getSegment(3);
} else {
  $cek2 = "";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HMPTI | <?= $title; ?></title>

  <!-- For favicon png -->
  <link rel="shortcut icon" type="image/icon" href="<?= base_url() ?>/gambar/logo/logo.png" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/summernote/summernote-bs4.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- jQuery -->
  <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Preloader
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?= base_url(); ?>/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= site_url('/admin/dashboard/index'); ?>" class="brand-link">
        <img src="<?= base_url() ?>/gambar/logo/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HMPTI Merchendaice</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image text-white h4">
            <i class="fa fa-user nav-icon ml-1"></i>
          </div>
          <div class="info">
            <?php if (session()->get('LoggedUserData')) { ?>
              <a href="#" class="d-block"><?= session()->get('LoggedUserData')['name']; ?></a>
            <?php } ?>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?= site_url('/admin/dashboard/index'); ?>" class="nav-link <?= $cek == 'dashboard' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <?php
            if ($cek == 'pembeli' || $cek == 'admin') {
              $class = 'menu-is-opening menu-open';
            } else {
              $class = '';
            }
            ?>
            <li class="nav-item <?= $class; ?>">
              <a href="#" class="nav-link <?= $cek == 'pembeli' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Users
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url('/admin/admin/index'); ?>" class="nav-link <?= $cek == 'admin' ? 'active' : ''; ?>">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <p>Admin</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= site_url('/admin/pembeli/index'); ?>" class="nav-link <?= $cek == 'pembeli' ? 'active' : ''; ?>">
                    <i class="fas fa-user-alt nav-icon"></i>
                    <p>Pembeli</p>
                  </a>
                </li>
              </ul>
            </li>

            <?php
            if ($cek == 'kategori' || $cek == 'satuan') {
              $class = 'menu-is-opening menu-open';
            } else {
              $class = '';
            }
            ?>
            <li class="nav-item <?= $class; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Master
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url('/admin/kategori/index'); ?>" class="nav-link <?= $cek == 'kategori' ? 'active' : ''; ?>">
                    <i class="fa fa-angle-double-right nav-icon"></i>
                    <p>Data Kategori</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= site_url('/admin/satuan/index'); ?>" class="nav-link <?= $cek == 'satuan' ? 'active' : ''; ?>">
                    <i class="fas fa-balance-scale-right nav-icon"></i>
                    <p>Data Satuan</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="<?= site_url('/admin/produk/index'); ?>" class="nav-link <?= $cek == 'produk' ? 'active' : ''; ?>">
                <i class="nav-icon fab fa-product-hunt"></i>
                <p>
                  Produk
                </p>
              </a>
            </li>

            <?php
            if ($cek == 'transaksionline' || $cek == 'transaksioffline') {
              $class = 'menu-is-opening menu-open';
            } else {
              $class = '';
            }
            ?>
            <li class="nav-item <?= $class ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-bill"></i>
                <p>
                  Transaksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url('/admin/transaksionline/index'); ?>" class="nav-link <?= $cek == 'transaksionline' ? 'active' : ''; ?>">
                    <i class="fas fa-money-check nav-icon"></i>
                    <p>Transaksi Online</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= site_url('/admin/transaksioffline/index'); ?>" class="nav-link <?= $cek == 'transaksioffline' ? 'active' : ''; ?>">
                    <i class="fas fa-cash-register nav-icon"></i>
                    <p>Transaksi Offline</p>
                  </a>
                </li>
              </ul>
            </li>

            <?php
            if ($cek == 'laporan') {
              $class = 'menu-is-opening menu-open';
            } else {
              $class = '';
            }
            ?>
            <li class="nav-item <?= $class; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                  Laporan
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url('/admin/laporan/cetak-transaksi-online'); ?>" class="nav-link <?= $cek2 === 'cetak-transaksi-online' ? 'active' : ''; ?>">
                    <i class="fas fa-file nav-icon"></i>
                    <p>Laporan Transaksi Online</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= site_url('/admin/laporan/cetak-transaksi-offline'); ?>" class="nav-link <?= $cek2 === 'cetak-transaksi-offline' ? 'active' : ''; ?>">
                    <i class="fas fa-file nav-icon"></i>
                    <p>Laporan Transaksi Offline</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="<?= site_url('/admin/setting/index'); ?>" class="nav-link <?= $cek == 'setting' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  Setting Web
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link keluar">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>

            <!-- <li class="nav-header">EXAMPLES</li> -->

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                <?= $title; ?>
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">
                  <?= $title; ?>
                </li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <?= $this->renderSection('isi'); ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; <?= date('Y'); ?> <a href="https://adminlte.io">HMPTI</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0-rc
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url(); ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= base_url(); ?>/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="<?= base_url(); ?>/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="<?= base_url(); ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?= base_url(); ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?= base_url(); ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?= base_url(); ?>/plugins/moment/moment.min.js"></script>
  <script src="<?= base_url(); ?>/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url(); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?= base_url(); ?>/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url(); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url(); ?>/dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?= base_url(); ?>/dist/js/pages/dashboard.js"></script>

  <!-- select2 -->
  <script src="<?= base_url(); ?>/plugins/select2/js/select2.full.min.js"></script>

  <!-- <script>
    $(document).ready(function() {
      $('select').select2()
    });
  </script> -->

  <script>
    $('.keluar').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Keluar?',
        text: "Apakah anda yakin ingin keluar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, keluar!',
        cancelButtonText: 'tidak',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = '<?= site_url('/keluar'); ?>';
        }
      });
    });

    $(document).ready(function() {
      // showing alert
      <?php $alert = session()->getFlashData("msg") ?>
      <?php if (!empty($alert)) : ?>
        <?php $alert = explode("#", $alert) ?>
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
        });
        setTimeout(function() {
          Toast.fire({
            icon: "<?php echo $alert[0] ?>",
            title: "<?php echo $alert[1] ?>"
          });
        }, 1000);
      <?php endif ?>
    });
  </script>
</body>

</html>