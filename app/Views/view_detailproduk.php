<?= $this->extend('main/pembeli'); ?>

<?= $this->section('carousel'); ?>


<?php

$db = \Config\Database::connect();
$setting = $db->table('tbl_setting')->limit(1)->get()->getRowArray();
$kontak = explode('#', $setting['kontak']);

?>


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
<!-- single product -->
<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <div class="col-12">
          <img src="<?= base_url(); ?>/gambar/produk/<?= $produk['gambarutama']; ?>" class="product-image" alt="Product Image">
        </div>
        <div class="col-12 product-image-thumbs">
          <div class="product-image-thumb active"><img src="<?= base_url(); ?>/gambar/produk/<?= $produk['gambarutama']; ?>" alt="Product Image"></div>
          <?php
          $db = \Config\Database::connect();
          $query = $db->table('tbl_gambar_produk')->where('produkid', $produk['produkid'])->get()->getResultArray();
          foreach ($query as $gambar) :
          ?>
            <div class="product-image-thumb"><img src="<?= base_url(); ?>/gambar/produk/<?= $gambar['gambarproduk']; ?>" alt="Product Image"></div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-7">
        <div class="single-product-content">
          <h3><?= $produk['namaproduk']; ?></h3>
          <p class="single-product-pricing"><span>Per Kg</span></p>
          <p class="single-product-pricing" id="hargaProduk">Rp <?= number_format($produk['hargaproduk'], 0, ",", "."); ?></p>
          <p><?= $produk['deskripsiproduk']; ?></p>
          <div class="single-product-form">
            <?php
            $daftarukuran = $db->table('tbl_ukuran_produk')
              ->where('produkid', $produk['produkid'])
              ->where('status', 1)
              ->orderBy('ukuranprodukid', 'ASC')
              ->get()->getResultArray();
            if ($daftarukuran) :
            ?>
              <h4 class="mt-3">Pilih Ukuran</h4>
              <?php
              $checked = $db->table('tbl_ukuran_produk')
                ->where('produkid', $produk['produkid'])
                ->where('status', 1)
                ->limit(1)->orderBy('ukuranprodukid', 'ASC')
                ->get()->getRowArray();
              // echo $checked['ukuranprodukid'];
              foreach ($daftarukuran as $ukuran) :
              ?>
                <label class="btn btn-default text-center">
                  <input type="radio" name="ukuran" id="ukuran" value="<?= $ukuran['ukuranprodukid']; ?>" autocomplete="off" <?= $checked['ukuranprodukid'] == $ukuran['ukuranprodukid'] ? 'checked' : ''; ?>>
                  <span class="text-xl"><?= $ukuran['ukuran']; ?></span>
                </label>
            <?php
              endforeach;
            endif;
            ?>
            <br>
            <?php if (!empty(session()->get('LoggedUserData'))) { ?>
              <?php if (session()->get('LoggedUserData')['level'] == 'Pembeli') { ?>
                <a class="cart-btn" href="#" onclick="tambahkeranjang('<?= $produk['produkid']; ?>');" <?= $produk['statusproduk'] == 1 ? '' : 'disabled'; ?>>
                  <i class="fas fa-cart-plus fa-lg mr-2"></i>
                  <?= $produk['statusproduk'] == 1 ? 'Tambah Ke Keranjang' : 'Produk Habis'; ?>
                </a>
              <?php } else { ?>
                <a href="<?= site_url('/admin/dashboard'); ?>" class="cart-btn" <?= $produk['statusproduk'] == 1 ? '' : 'disabled'; ?>>
                  <i class="fas fa-cart-plus fa-lg mr-2"></i>
                  <?= $produk['statusproduk'] == 1 ? 'Tambah Ke Keranjang' : 'Produk Habis'; ?>
                </a>
              <?php } ?>
            <?php } else { ?>
              <a href="<?= site_url('/login'); ?>" class="cart-btn" <?= $produk['statusproduk'] == 1 ? '' : 'disabled'; ?>>
                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                <?= $produk['statusproduk'] == 1 ? 'Tambah Ke Keranjang' : 'Produk Habis'; ?>
              </a>
            <?php } ?>
            <p><strong>Kategori: </strong><?= $produk['namakategori']; ?></p>
          </div>
          <h4>Hubungi penjual:</h4>
          <ul class="product-share">
            <li><a href="<?= $kontak[2]; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
            <li>

              <?php

              $nowa = substr($kontak[1], 1);
              $nowa = 62 . $nowa;

              ?>

              <a href="https://wa.me/<?= $nowa; ?>?text=Apakah produk *<?= $produk['namaproduk']; ?>* tersedia ?" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </li>
            <li><a href="mailto:<?= $kontak[0]; ?>" target="_blank"><i class="fas fa-envelope"></i></a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- DIRECT CHAT -->
    <div class="card direct-chat direct-chat-primary mt-2">
      <div class="card-header">

        <?php

        $jmlRowRanting = $db->table('tbl_review')
          ->join('tbl_detail_transaksionline', 'tbl_review.detailtransid=tbl_detail_transaksionline.id')
          ->getWhere(['tbl_detail_transaksionline.produkid' => $produk['produkid']])
          ->getNumRows();

        ?>

        <h3 class="card-title">Review Produk <span class="badge badge-success"><?= $jmlRowRanting; ?> ulasan</span></h3>

        <?php

        if ($jmlRowRanting > 0) {
          $totalRanting = $db->table('tbl_review')
            // ->select('SUM(ranting) as jmlranting')
            ->selectSum('ranting')
            ->join('tbl_detail_transaksionline', 'tbl_review.detailtransid=tbl_detail_transaksionline.id')
            ->getWhere(['tbl_detail_transaksionline.produkid' => $produk['produkid']])
            ->getRowArray()['ranting'];

          $rata2 = round(($totalRanting / $jmlRowRanting), 1);
        ?>

          <div class="card-tools">
            <span style="font-size: 14px; font-weight: bold;"><?= $rata2; ?></span>
            <i class="fa fa-star <?= $rata2 >= 1 ? 'text-warning' : ''; ?>"></i>
            <i class="fa fa-star <?= $rata2 >= 2 ? 'text-warning' : ''; ?>"></i>
            <i class="fa fa-star <?= $rata2 >= 3 ? 'text-warning' : ''; ?>"></i>
            <i class="fa fa-star <?= $rata2 >= 4 ? 'text-warning' : ''; ?>"></i>
            <i class="fa fa-star <?= $rata2 == 5 ? 'text-warning' : ''; ?>"></i>
          </div>
        <?php } ?>

      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="direct-chat-messages">
          <div class="card-footer card-comments">

            <?php

            $dataReview = $db->table('tbl_review')
              ->join('tbl_detail_transaksionline', 'tbl_review.detailtransid=tbl_detail_transaksionline.id')
              ->join('tbl_pembeli', 'tbl_detail_transaksionline.pembeliid=tbl_pembeli.pembeliid')
              ->where('tbl_detail_transaksionline.produkid', $produk['produkid'])
              ->orderBy('tbl_review.tanggal', 'DESC')
              ->get()->getResultArray();

            if ($dataReview) {
              foreach ($dataReview as $key => $value) :
            ?>
                <div class="card-comment">
                  <?php if ($value['profilpembeli'] !== null && $value['profilpembeli'] !== '') : ?>
                    <img class="img-circle img-sm" src="<?= base_url(); ?>/gambar/profil/<?= $value['profilpembeli']; ?>" alt="User Image">
                  <?php else : ?>
                    <img class="img-circle img-sm" src="<?= base_url(); ?>/gambar/profil/default.png" alt="User Image">
                  <?php endif; ?>
                  <div class="comment-text">
                    <span class="username">
                      <?= $value['namapembeli']; ?>
                      <span class="text-muted float-right"><?= date('H:i d-m-Y', strtotime($value['tanggal'])); ?></span>
                    </span><!-- /.username -->

                    <span class="username">
                      <i class="fa fa-star <?= $value['ranting'] >= 1 ? 'text-warning' : ''; ?>"></i>
                      <i class="fa fa-star <?= $value['ranting'] >= 2 ? 'text-warning' : ''; ?>"></i>
                      <i class="fa fa-star <?= $value['ranting'] >= 3 ? 'text-warning' : ''; ?>"></i>
                      <i class="fa fa-star <?= $value['ranting'] >= 4 ? 'text-warning' : ''; ?>"></i>
                      <i class="fa fa-star <?= $value['ranting'] == 5 ? 'text-warning' : ''; ?>"></i>
                    </span>

                    <div class="row col-5">
                      <?php
                      $dataGambar = $db->table('tbl_gambar_review')->getWhere(['reviewid' => $value['reviewid']])->getResultArray();
                      if ($dataGambar) {
                        foreach ($dataGambar as $gambar) :
                      ?>
                          <div class="col-3"><img style="width: 100%; height: 100%;" src="<?= base_url('/gambar/review/' . $gambar['gambar']); ?>" alt="Gambar review"></div>
                      <?php
                        endforeach;
                      } ?>
                    </div>

                    <p><?= $value['review']; ?></p>
                  </div>
                </div>
              <?php
              endforeach;
            } else {
              ?>
              <div class="card-comment">
                <h5>Kosong</h5>
              </div>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
    <!--/.direct-chat-messages-->

  </div>
</div>
<!-- end single product -->

<!-- product section -->
<?php

$terkait = $db->table('tbl_produk')->select('namaproduk, produkid, gambarutama, namasatuan, hargaproduk')
  ->join('tbl_kategori', 'tbl_produk.kategoriid=tbl_kategori.kategoriid')
  ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
  ->where('produkid !=', $produk['produkid'])
  ->where('tbl_produk.kategoriid', $produk['kategoriid'])
  ->get()->getResultArray();

if ($terkait) { ?>
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
        <?php foreach ($terkait as $row) : ?>
          <div class="col-lg-4 col-md-6 text-center">
            <div class="single-product-item">
              <div class="product-image">
                <a href="<?= site_url('/detailproduk/' . $row['produkid']); ?>"><img src="<?= base_url(); ?>/gambar/produk/<?= $row['gambarutama']; ?>" title="Gambar produk"></a>
              </div>
              <h3><?= $row['namaproduk']; ?></h3>
              <p class="product-price"><span>Per <?= $row['namasatuan']; ?></span> Rp <?= number_format($row['hargaproduk'], 0, ",", ".") ?> </p>

              <?php

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
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php } ?>
<!-- end product section -->

<script>
  // tambah ke keranjang
  function tambahkeranjang(produkid) {
    // apakah ukuran sudah di isi
    let ukuran = $('#ukuran:checked').val();
    $.ajax({
      type: "post",
      url: "<?= site_url('/transaksi/tambahkeranjang'); ?>",
      data: {
        produkid: produkid,
        ukuranid: ukuran
      },
      dataType: "json",
      success: function(response) {
        if (response.sukses) {
          Swal.fire('Sukses', response.sukses, 'success').then(function() {
            location.reload();
          });
        }

        if (response.pesanerror) {
          Swal.fire('Kesalahan', response.pesanerror, 'error').then(function() {
            location.reload();
          });
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function hargaukuranproduk() {
    if ($("input[name=ukuran]").is(':checked')) {
      let ukuranprodukid = $("input[name=ukuran]:checked").val();
      $.ajax({
        type: "post",
        url: "<?= site_url('/home/hargaukuranproduk'); ?>",
        data: {
          ukuranprodukid: ukuranprodukid
        },
        dataType: "json",
        success: function(response) {
          if (response.hargaproduk) {
            $('#hargaProduk').html(response.hargaproduk);
          }
          if (response.error) {
            Swal.fire('Kesalahan', response.error, 'error').then(function() {
              window.location.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    }
  }

  $(document).ready(function() {
    // aksi gambar
    $('.product-image-thumb').on('click', function() {
      var $image_element = $(this).find('img')
      $('.product-image').prop('src', $image_element.attr('src'))
      $('.product-image-thumb.active').removeClass('active')
      $(this).addClass('active')
    });

    // mengambil hargaproduk
    hargaukuranproduk();

    // mengambil harga produk berdasarkan ukuran
    $('input[name=ukuran]').click(function(e) {
      let ukuranprodukid = $(this).val();
      $.ajax({
        type: "post",
        url: "<?= site_url('/home/hargaukuranproduk'); ?>",
        data: {
          ukuranprodukid: ukuranprodukid
        },
        dataType: "json",
        success: function(response) {
          if (response.hargaproduk) {
            $('#hargaProduk').html(response.hargaproduk);
          }
          if (response.error) {
            Swal.fire('Kesalahan', response.error, 'error').then(function() {
              window.location.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    });
  })
</script>

<?= $this->endSection('isi'); ?>