<?= $this->extend('main/pembeli'); ?>

<?= $this->section('carousel'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">

<!-- breadcrumb-section -->
<div class="breadcrumb-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <h1><?= $title; ?></h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->
<?= $this->endSection('carousel'); ?>

<?= $this->section('isi'); ?>

<!-- product section -->
<?php
if ($daftarproduk) { ?>
  <div class="product-section mt-150 mb-150" id="terkait">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center">
          <div class="section-title">
            <h3><span class="orange-text">Produk</span> Terkait</h3>
          </div>
        </div>
      </div>

      <div class="row">
        <?php
        foreach ($daftarproduk as $row) : ?>
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

      <?php if ($pager->getPageCount('produk') > 1) { ?>
        <div class="float-center mt-2">
          <?= $pager->links('produk', 'paging_produk'); ?>
        </div>
      <?php } ?>

    </div>
  </div>
<?php } ?>
<!-- end product section -->


<?= $this->endSection('isi'); ?>