<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="<?= site_url('/login'); ?>" class="h1"><?= $title; ?></a>
      </div>
      <div class="card-body">
        <form action="<?= site_url('/login/ceklogin'); ?>" method="post">
          <?= csrf_field(); ?>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" value="<?= old('email'); ?>" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </form>

        <div class="social-auth-links text-center mt-2 mb-3">
          <a href="<?= $googleButton; ?>" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div>
        <!-- /.social-auth-links -->

        <p class="mb-1">
          <a href="<?= site_url('/lupa-password'); ?>">Lupa Password</a>
        </p>
        <p class="mb-0">
          <a href="<?= site_url('/registrasi'); ?>" class="text-center">Registrasi</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>/dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function() {
      // showing alert
      <?php $alert = session()->getFlashData("msg") ?>
      <?php if (!empty($alert)) : ?>
        <?php $alert = explode("#", $alert) ?>
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: "<?php echo $alert[0]; ?>",
          title: "<?php echo $alert[1]; ?>",
          showConfirmButton: false,
          timer: 5000
        });
      <?php endif ?>
    });
  </script>
</body>

</html>