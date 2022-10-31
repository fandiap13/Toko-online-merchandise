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
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url(); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="<?= site_url('/registrasi'); ?>" class="h1"><?= $title; ?></a>
      </div>
      <div class="card-body">

        <?php if (session()->getFlashdata('pesan')) { ?>
          <div class="alert alert-success"><?= session()->getFlashdata('pesan'); ?></div>
        <?php } ?>

        <form action="<?= site_url('/login/save_register'); ?>" method="post">
          <?= csrf_field(); ?>
          <div class="input-group mb-3">
            <input type="text" class="form-control <?= $validation->hasError('namalengkap') ? 'is-invalid' : ''; ?>" placeholder="Nama Lengkap" name="namalengkap" value="<?= old('namalengkap'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <div class="invalid-feedback">
              <?= $validation->getError('namalengkap'); ?>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" placeholder="Email" name="email" value="<?= old('email'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <div class="invalid-feedback">
              <?= $validation->getError('email'); ?>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="invalid-feedback">
              <?= $validation->getError('password'); ?>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control <?= $validation->hasError('retype_password') ? 'is-invalid' : ''; ?>" placeholder="Retype password" name="retype_password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="invalid-feedback">
              <?= $validation->getError('retype_password'); ?>
            </div>
          </div>

          <div class="mb-3"><button type="submit" class="btn btn-primary btn-block">Register</button></div>

        </form>

        <div class="mt-2"><a href="<?= site_url('/login'); ?>" class="text-center">Sudah punya akun ?</a></div>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

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