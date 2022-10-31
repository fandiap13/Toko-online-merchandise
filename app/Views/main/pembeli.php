<?php

$db = \Config\Database::connect();
$setting = $db->table('tbl_setting')
  ->limit(1)->orderBy('id', 'ASC')
  ->get()->getRowArray();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- title -->
  <title><?= $setting['namawebsite']; ?> | <?= $title; ?></title>

  <!-- favicon -->
  <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>/gambar/setting/<?= $setting['favicon']; ?>">
  <!-- google font -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  <!-- fontawesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/css/all.min.css">
  <!-- bootstrap -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/bootstrap/css/bootstrap.min.css">
  <!-- owl carousel -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/css/owl.carousel.css">
  <!-- magnific popup -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/css/magnific-popup.css">
  <!-- animate css -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/css/animate.css">
  <!-- mean menu css -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/css/meanmenu.min.css">
  <!-- main style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/css/main.css">
  <!-- responsive -->
  <link rel="stylesheet" href="<?= base_url(); ?>/fruit/assets/css/responsive.css">

  <!-- jquery -->
  <script src="<?= base_url(); ?>/fruit/assets/js/jquery-1.11.3.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- ionicon -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>

<body>

  <!--PreLoader-->
  <!-- <div class="loader">
    <div class="loader-inner">
      <div class="circle"></div>
    </div>
  </div> -->
  <!--PreLoader Ends-->

  <!-- header -->
  <!-- <div class="top-header-area" id="sticker" style="background-color: #051922;"> -->
  <div class="top-header-area" id="sticker">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 text-center">
          <div class="main-menu-wrap">
            <!-- logo -->
            <div class="site-logo">
              <a href="<?= site_url('/'); ?>">
                <img src="<?= base_url(); ?>/gambar/setting/<?= $setting['favicon']; ?>" style="width: 50px;">
              </a>
            </div>
            <!-- logo -->

            <!-- menu start -->
            <nav class="main-menu">
              <ul>
                <?= $this->renderSection('menu'); ?>
                <li>
                  <?php if (!empty(session()->get('LoggedUserData'))) { ?>
                    <?php if (session()->get('LoggedUserData')['level'] == 'Pembeli') { ?>
                      <div class="header-icons">
                        <a class="shopping-cart" href="<?= site_url('/keranjang'); ?>">
                          <i class="fas fa-shopping-cart"></i>
                          <?php
                          $pembeliid = session()->get('LoggedUserData')['userid'];
                          $db = \Config\Database::connect();
                          $jmlkeranjang = $db->table('tbl_keranjang')->where('pembeliid', $pembeliid)->countAllResults();
                          if ($jmlkeranjang > 0) {
                            echo '<span class="badge badge-danger">' . $jmlkeranjang . '</span>';
                          }
                          ?>
                        </a>
                        <a class="shopping-cart" href="<?= site_url('/daftar-transaksi'); ?>">
                          <i class="fas fa-money-bill"></i>
                          <?php
                          $pembeliid = session()->get('LoggedUserData')['userid'];
                          $db = \Config\Database::connect();
                          $jmltrans = $db->table('tbl_transaksionline')->where('pembeliid', $pembeliid)->countAllResults();
                          if ($jmltrans > 0) {
                            echo '<span class="badge badge-danger">' . $jmltrans . '</span>';
                          }
                          ?>
                        </a>
                        <a href="<?= base_url('/profiluser'); ?>"><?= session()->get('LoggedUserData')['name']; ?></a>
                        <a class="shopping-cart keluar" href="<?= site_url('/keluar'); ?>">
                          <button class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> LOGOUT</button>
                        </a>
                        <!-- <a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-money-bill"></i></i></a> -->
                      </div>
                    <?php } elseif (session()->get('LoggedUserData')['level'] == 'Admin') { ?>
                      <a href="<?= base_url('/admin/dashboard'); ?>"><?= session()->get('LoggedUserData')['name']; ?></a>
                    <?php } ?>
                  <?php } ?>

                  <?php if (empty(session()->get('LoggedUserData'))) { ?>
                    <a class="shopping-cart" href="<?= site_url('/login'); ?>">
                      <button class="btn btn-success"><i class="fas fa-sign-in-alt"></i> LOGIN</button>
                    </a>
                  <?php } ?>
                </li>
              </ul>
            </nav>
            <!-- <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-money-bill"></i></i></a> -->
            <div class="mobile-menu"></div>
            <!-- menu end -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end header -->

  <?= $this->renderSection('carousel'); ?>

  <?= $this->renderSection('isi'); ?>

  <!-- logo carousel -->
  <div class="logo-carousel-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="logo-carousel-inner">
            <?php

            $support = $db->table('tbl_support')->getWhere(['settingid' => $setting['id']])->getResultArray();

            foreach ($support as $key => $value) :
            ?>
              <div class="single-logo-item">
                <a href="<?= $value['linkwebsite']; ?>" target="_blank">
                  <img src="<?= base_url(); ?>/gambar/setting/<?= $value['gambar']; ?>" title="<?= $value['supported']; ?>">
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end logo carousel -->

  <!-- footer -->
  <div class="footer-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-6">
          <div class="footer-box about-widget" id="about-us">
            <h2 class="widget-title">About us</h2>
            <p><?= $setting['tentangkami']; ?></p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="footer-box get-in-touch" id="contact">
            <h2 class="widget-title">Contact Us</h2>
            <ul>
              <li>
                <ion-icon name="map-outline"></ion-icon> <?= $setting['alamattoko']; ?>
              </li>
              <?php

              $kontak = explode('#', $setting['kontak']);

              ?>
              <li>
                <ion-icon name="mail-outline"></ion-icon> <?= $kontak[0]; ?>
              </li>
              <li>
                <ion-icon name="logo-whatsapp"></ion-icon></i> <?= $kontak[1]; ?>
              </li>
              <li>
                <ion-icon name="logo-instagram"></ion-icon></i> <?= $kontak[2]; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end footer -->

  <!-- copyright -->
  <div class="copyright">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <p>Copyrights &copy; <?= date('Y'); ?> - <a href="<?= site_url('/'); ?>"><?= $setting['namawebsite']; ?></a>.</p>
        </div>
        <div class="col-lg-6 text-right col-md-12">
          <div class="social-icons">
            <ul>
              <li><a href="mailto:<?= $kontak[0]; ?>" target="_blank"><i class="fas fa-mail-bulk"></i></a></li>
              <li><a href="<?= $kontak[2]; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>

              <?php

              $nowa = substr($kontak[1], 1);
              $nowa = 62 . $nowa;

              ?>

              <li><a href="https://wa.me/<?= $nowa; ?>" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end copyright -->

  <!-- bootstrap -->
  <script src="<?= base_url(); ?>/fruit/assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- count down -->
  <script src="<?= base_url(); ?>/fruit/assets/js/jquery.countdown.js"></script>
  <!-- isotope -->
  <script src="<?= base_url(); ?>/fruit/assets/js/jquery.isotope-3.0.6.min.js"></script>
  <!-- waypoints -->
  <script src="<?= base_url(); ?>/fruit/assets/js/waypoints.js"></script>
  <!-- owl carousel -->
  <script src="<?= base_url(); ?>/fruit/assets/js/owl.carousel.min.js"></script>
  <!-- magnific popup -->
  <script src="<?= base_url(); ?>/fruit/assets/js/jquery.magnific-popup.min.js"></script>
  <!-- mean menu -->
  <script src="<?= base_url(); ?>/fruit/assets/js/jquery.meanmenu.min.js"></script>
  <!-- sticker js -->
  <script src="<?= base_url(); ?>/fruit/assets/js/sticker.js"></script>
  <!-- main js -->
  <script src="<?= base_url(); ?>/fruit/assets/js/main.js"></script>

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