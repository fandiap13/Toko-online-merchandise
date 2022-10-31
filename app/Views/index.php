<?= $this->extend('main/pembeli'); ?>

<?= $this->section('menu'); ?>
<li><a href="#home">Home</a></li>
<li><a href="#best-seller">Best Seller</a></li>
<li><a href="#our-products">Our Products</a></li>
<li><a href="#about-us">About Us</a></li>
<li><a href="#contact">Contact</a></li>
<?= $this->endSection('menu'); ?>

<?= $this->section('carousel'); ?>

<?php

$db = \Config\Database::connect();
$setting = $db->table('tbl_setting')->limit(1)->orderBy('id', 'ASC')->get()->getRowArray();

?>

<!-- single home slider -->
<div class="hero-area hero-bg" style="background-image: url(<?= base_url(); ?>/gambar/setting/<?= $setting['gambarcarousel']; ?>);" id="home">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-7 offset-lg-1 offset-xl-0">
        <div class="hero-text">
          <div class="hero-text-tablecell">
            <h1><?= $setting['judulcarousel']; ?></h1>
            <!-- <h4 style="color: white;">10% Off This Week</h4> -->
            <p class="subtitle"><?= $setting['deskripsicarousel']; ?></p>
            <div class="hero-btns">
              <a href="#best-seller" class="boxed-btn">Pesan Sekarang</a>
              <a href="#contact" class="bordered-btn">Contact Us</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end home page slider -->
<?= $this->endSection('carousel'); ?>

<?= $this->section('isi'); ?>
<!-- product section -->
<?php if ($bestseller) { ?>
  <div class="product-section mt-150 mb-150" id="best-seller">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center">
          <div class="section-title">
            <h3><span class="orange-text">Best</span> Seller</h3>
          </div>
        </div>
      </div>

      <div class="row">
        <?php foreach ($bestseller as $row) : ?>
          <div class="col-lg-4 col-md-6 text-center">
            <div class="single-product-item">
              <div class="product-image">
                <a href="<?= site_url('/detailproduk/' . $row['produkid']); ?>"><img src="<?= base_url(); ?>/gambar/produk/<?= $row['gambarutama']; ?>" title="Gambar produk"></a>
              </div>
              <h3><?= $row['namaproduk']; ?></h3>
              <p class="product-price"><span>Per <?= $row['namasatuan']; ?></span> Rp <?= number_format($row['hargaproduk'], 0, ",", ".") ?> </p>

              <?php
              $db = \Config\Database::connect();
              $jmlRowRanting = $db->table('tbl_review')
                ->join('tbl_detail_transaksionline', 'tbl_review.detailtransid=tbl_detail_transaksionline.id')
                ->getWhere(['tbl_detail_transaksionline.produkid' => $row['produkid']])
                ->getNumRows();

              if ($jmlRowRanting > 0) {
                $totalRanting = $db->table('tbl_review')
                  // ->select('SUM(ranting) as jmlranting')
                  ->selectSum('ranting')
                  ->join('tbl_detail_transaksionline', 'tbl_review.detailtransid=tbl_detail_transaksionline.id')
                  ->getWhere(['tbl_detail_transaksionline.produkid' => $row['produkid']])
                  ->getRowArray()['ranting'];

                $rata2 = round(($totalRanting / $jmlRowRanting), 1);
              ?>
                <div class="product-price mb-2">
                  <span style="font-size: 14px; font-weight: bold;"><?= $rata2; ?></span>
                  <i class="fa fa-star <?= $rata2 >= 1 ? 'text-warning' : ''; ?>"></i>
                  <i class="fa fa-star <?= $rata2 >= 2 ? 'text-warning' : ''; ?>"></i>
                  <i class="fa fa-star <?= $rata2 >= 3 ? 'text-warning' : ''; ?>"></i>
                  <i class="fa fa-star <?= $rata2 >= 4 ? 'text-warning' : ''; ?>"></i>
                  <i class="fa fa-star <?= $rata2 == 5 ? 'text-warning' : ''; ?>"></i>
                </div>
              <?php } ?>

              <div>
                <a href="<?= site_url('/detailproduk/' . $row['produkid']); ?>" class="cart-btn"><i class="fas fa-eye"></i> Lihat detail</a>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      </div>
      <div class="col-lg-12 text-center">
        <a href="<?= site_url('/daftar-produk'); ?>" class="boxed-btn">Lihat Selengkapnya</a>
      </div>
    </div>
  </div>
<?php } ?>
<!-- end product section -->

<!-- product section -->
<div class="product-section mt-150 mb-150" id="our-products">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="section-title">
          <h3><span class="orange-text">Our</span> Products</h3>
        </div>
      </div>
    </div>

    <div class="row">
      <?php foreach ($dataproduk as $row) : ?>
        <div class="col-lg-4 col-md-6 text-center">
          <div class="single-product-item">
            <div class="product-image">
              <a href="<?= site_url('/detailproduk/' . $row['produkid']); ?>"><img src="<?= base_url(); ?>/gambar/produk/<?= $row['gambarutama']; ?>" title="Gambar produk"></a>
            </div>
            <h3><?= $row['namaproduk']; ?></h3>
            <p class="product-price"><span>Per <?= $row['namasatuan']; ?></span> Rp <?= number_format($row['hargaproduk'], 0, ",", ".") ?> </p>

            <?php
            $db = \Config\Database::connect();
            $jmlRowRanting = $db->table('tbl_review')
              ->join('tbl_detail_transaksionline', 'tbl_review.detailtransid=tbl_detail_transaksionline.id')
              ->getWhere(['tbl_detail_transaksionline.produkid' => $row['produkid']])
              ->getNumRows();

            if ($jmlRowRanting > 0) {
              $totalRanting = $db->table('tbl_review')
                // ->select('SUM(ranting) as jmlranting')
                ->selectSum('ranting')
                ->join('tbl_detail_transaksionline', 'tbl_review.detailtransid=tbl_detail_transaksionline.id')
                ->getWhere(['tbl_detail_transaksionline.produkid' => $row['produkid']])
                ->getRowArray()['ranting'];

              $rata2 = round(($totalRanting / $jmlRowRanting), 1);
            ?>
              <div class="product-price mb-2">
                <span style="font-size: 14px; font-weight: bold;"><?= $rata2; ?></span>
                <i class="fa fa-star <?= $rata2 >= 1 ? 'text-warning' : ''; ?>"></i>
                <i class="fa fa-star <?= $rata2 >= 2 ? 'text-warning' : ''; ?>"></i>
                <i class="fa fa-star <?= $rata2 >= 3 ? 'text-warning' : ''; ?>"></i>
                <i class="fa fa-star <?= $rata2 >= 4 ? 'text-warning' : ''; ?>"></i>
                <i class="fa fa-star <?= $rata2 == 5 ? 'text-warning' : ''; ?>"></i>
              </div>
            <?php } ?>

            <a href="<?= site_url('/detailproduk/' . $row['produkid']); ?>" class="cart-btn"><i class="fas fa-eye"></i> Lihat detail</a>
          </div>
        </div>
      <?php endforeach ?>
    </div>
    <div class="col-lg-12 text-center">
      <a href="<?= site_url('/daftar-produk'); ?>" class="boxed-btn">Lihat Selengkapnya</a>
    </div>
  </div>
</div>
<!-- end product section -->

<script>
  $('.main-menu ul li').click(function(e) {
    // $(obj).closest('a').nextAll(':has(.class):first').find('.class').addClass('cek');
    // var i = $(this).find("a")[0];
    // $(i).css({
    //   "border": "1px"
    // });
    $('.main-menu ul li').attr('class', '');
    $(this).addClass('current-list-item');
  });

  // $('.main-menu ul').click(function(e) {
  //   // $(obj).closest('a').nextAll(':has(.class):first').find('.class').addClass('cek');
  //   let i = $(this).find("li")[0];
  //   $(i).attr(
  //     "class", "current-list-item"
  //   );
  // });
</script>
<?= $this->endSection('isi'); ?>