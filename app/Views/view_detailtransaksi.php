<?= $this->extend('main/pembeli'); ?>

<?= $this->section('carousel'); ?>
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
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
<!-- Main content -->
<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="checkout-accordion-wrap">
      <div class="accordion" id="accordionExample">

        <!-- data transaksi -->
        <div class="card single-accordion">
          <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#datatransaksi" aria-expanded="false" aria-controls="datatransaksi">
                Transaksi
              </button>
            </h5>
          </div>
          <div id="datatransaksi" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
              <div class="shipping-address-form">
                <ul>
                  <li><b>ID Transaksi:</b> <?= $datatransaksi['transonlineid']; ?></li>
                  <li><b>Tanggal Transaksi:</b> <?= date('d-m-Y H:i:s', strtotime($datatransaksi['tgltransaksi'])); ?></li>

                  <?php if ($datatransaksi['statuspembelian'] == 'diproses') { ?>
                    <li>
                      <b>Status Transaksi: </b>
                      <nav class="badge badge-warning">Diproses</nav>
                    </li>
                  <?php } elseif ($datatransaksi['statuspembelian'] == 'pending') { ?>
                    <li><b>Status Transaksi: </b>
                      <nav class="badge badge-secondary">Pending</nav>
                    </li>
                  <?php } elseif ($datatransaksi['statuspembelian'] == 'dikirim') { ?>
                    <li><b>Status Transaksi: </b>
                      <nav class="badge badge-info">Dikirim</nav>
                    </li>
                  <?php } elseif ($datatransaksi['statuspembelian'] == 'diterima') { ?>
                    <li><b>Status Transaksi: </b>
                      <nav class="badge badge-success">Diterima</nav>
                    </li>
                  <?php } else { ?>
                    <li><b>Status Transaksi: </b>
                      <nav class="badge badge-danger">Gagal</nav>
                    </li>
                  <?php } ?>

                  <li><a href="https://wa.me/<?= $nowa; ?>" class="btn btn-sm btn-success" target="_blank" title="Hubungi penjual"><i class="fab fa-whatsapp"></i> Hubungi penjual</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- data pembayaran -->
        <div class="card single-accordion">
          <div class="card-header" id="heading3">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#datapembayaran" aria-expanded="false" aria-controls="datapembayaran">
                Pembayaran
              </button>
            </h5>
          </div>
          <div id="datapembayaran" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
            <div class="billing-address-form">
              <div class="card-body">
                <ul>
                  <li><b>Order ID:</b> <?= $datatransaksi['order_id']; ?></li>
                  <?php if ($datatransaksi['statuspembayaran'] == 'pending') { ?>
                    <li>
                      <b>Status Pembayaran: </b>
                      <nav class="badge badge-secondary">Pending</nav>
                    </li>
                  <?php } elseif ($datatransaksi['statuspembayaran'] == 'settlement') { ?>
                    <li>
                      <b>Status Pembayaran </b>
                      <nav class="badge badge-success">Sukses</nav>
                    </li>
                  <?php } else { ?>
                    <li>
                      <b>Status Pembayaran: </b>
                      <nav class="badge badge-danger">Expire</nav>
                    </li>
                  <?php } ?>
                  <li><b>Tipe Pembayaran:</b> <?= $datatransaksi['payment_type']; ?></li>

                  <?php if ($datatransaksi['payment_type'] == 'cstore') { ?>
                    <li><b>Metode Pembayaran:</b> <?= $statuspayment->store; ?></li>
                    <li><b>Total Pembayaran:</b> Rp <?= number_format($statuspayment->gross_amount, 0, ",", "."); ?></li>
                    <?php if ($datatransaksi['statuspembayaran'] == 'pending') { ?>
                      <li>
                        <b>Klik untuk melihat pembayaran: </b><button class="btn btn-sm btn-primary" title="pembayaran" id="pembayaran" onclick="pembayaran('<?= $datatransaksi['snapToken']; ?>')"><i class="fa fa-money-bill"></i> Pembayaran</button>
                      </li>
                    <?php } ?>
                  <?php } elseif ($datatransaksi['payment_type'] == 'bank_transfer') { ?>
                    <li><b>Nama Bank:</b> <?= $statuspayment->va_numbers[0]->bank; ?></li>
                    <li><b>Total Pembayaran:</b> Rp <?= number_format($statuspayment->gross_amount, 0, ",", "."); ?></li>
                    <?php if ($datatransaksi['statuspembayaran'] == 'pending') { ?>
                      <li>
                        <b>Klik untuk melihat pembayaran: </b>
                        <button class="btn btn-sm btn-primary" title="pembayaran" id="pembayaran" onclick="pembayaran('<?= $datatransaksi['snapToken']; ?>')"><i class="fa fa-money-bill"></i> Pembayaran</button>
                      </li>
                    <?php } ?>
                  <?php } ?>
                </ul>

                <?php if ($datatransaksi['statuspembayaran'] == 'pending') { ?>
                  <ul class="list-group">
                    <li class="list-group-item text-center">Untuk lebih jelas bisa download file transaksi <a href="<?= $datatransaksi['pdf_url']; ?>" target="_blank">di sini</a></li>
                  </ul>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <!-- data pengiriman -->
        <div class="card single-accordion">
          <div class="card-header" id="heading2">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#datapengiriman" aria-expanded="false" aria-controls="datapengiriman">
                Pengiriman
              </button>
            </h5>
          </div>
          <div id="datapengiriman" class="collapse" aria-labelledby="heading2" data-parent="#accordionExample">
            <div class="billing-address-form">
              <div class="card-body">
                <?php if ($datatransaksi['noresi']) { ?>
                  <div class="form-group">
                    <label for="">No. Resi</label>
                    <input type="text" name="noresi" id="noresi" class="form-control" value="<?= $datatransaksi['noresi']; ?>" disabled>
                  </div>
                <?php } ?>
                <div class="form-group">
                  <label for="">No. Telp</label>
                  <input type="text" name="notelp" id="notelp" class="form-control" value="<?= $datatransaksi['notelp']; ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="">Alamat Pengiriman</label>
                  <textarea name="alamatpengiriman" id="alamatpengiriman" class="form-control" disabled><?= $datatransaksi['alamat']; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="">Provinsi</label>
                  <input type="text" name="provinsi" id="provinsi" class="form-control" value="<?= $datatransaksi['provinsi']; ?>" disabled>
                </div>
                <div class=" form-group">
                  <label for="">Distrik</label>
                  <input type="text" name="distrik" id="distrik" class="form-control" value="<?= $datatransaksi['distrik']; ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="">Ekspedisi</label>
                  <input type="text" name="ekspedisi" id="ekspedisi" class="form-control" value="<?= $datatransaksi['ekspedisi']; ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="">Paket</label>
                  <input type="text" name="paket" id="paket" class="form-control" value="<?= $datatransaksi['paket']; ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="">Ongkir (Rp)</label>
                  <input type="text" name="ongkir" id="ongkir" class="form-control" value="<?= number_format($datatransaksi['ongkir'], 0, ',', '.'); ?>" disabled>
                </div>
                <div class="form-group">
                  <label for="">Estimasi (Hari)</label>
                  <input type="text" name="estimasi" id="estimasi" class="form-control" value="<?= $datatransaksi['estimasi']; ?>" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- data detail -->
        <div class="card single-accordion">
          <div class="card-header" id="heading4">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#datadetail" aria-expanded="false" aria-controls="datadetail">
                Detail Transaksi
              </button>
            </h5>
          </div>
          <div id="datadetail" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
            <div class="billing-address-form">
              <div class="col-12 table-responsive datatransaksi">
                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>QTY</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($detailtransaksi as $row) : ?>
                        <tr>
                          <td><?= $no; ?>.</td>
                          <td><?= $row['namaproduk']; ?></td>
                          <td><?= (!$row['ukuran'] ? 'Tidak ada' : $row['ukuran']); ?></td>
                          <td><?= $row['jml']; ?> <?= $row['namasatuan']; ?></td>
                          <td class="text-right"><?= number_format($row['hargajual'], 0, ",", "."); ?></td>
                          <td class="text-right"><?= number_format($row['subtotal'], 0, ",", "."); ?></td>
                        </tr>
                      <?php
                        $no++;
                      endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="5">Total Belanja</th>
                        <td class="text-right">Rp <?= number_format($datatransaksi['totalpembelian'], 0, ",", "."); ?></td>
                      </tr>
                      <tr>
                        <th colspan="5">Ongkir (<?= number_format($datatransaksi['totalberat'], 0, ",", "."); ?> Gram)</th>
                        <td class="text-right">Rp <?= number_format($datatransaksi['ongkir'], 0, ",", "."); ?></td>
                      </tr>
                      <tr>
                        <th colspan="5">Total Transaksi</th>
                        <td class="text-right">Rp <?= number_format($datatransaksi['totalbayar'], 0, ",", "."); ?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <a href="<?= site_url('/cetak-transaksi/' . sha1($datatransaksi['transonlineid'])); ?>" target="_blank" class="btn btn-lg btn-success mb-3"><i class="fa fa-print"></i> Cetak Invoice</a>
  </div>
</div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-server-o4cVLaEqV9hq5Og_l3wDYZk5"></script>

<script>
  function pembayaran(snapToken) {
    snap.pay(snapToken, {
      // Optional
      onSuccess: function(result) {
        window.location.reload();
      },
      // Optional
      onPending: function(result) {
        window.location.reload();
      },
      // Optional
      onError: function(result) {
        window.location = "<?= site_url('/daftar-transaksi'); ?>";
      },
      onClose: function() {
        window.location.reload();
      }
    });
  }
</script>

<?= $this->endSection('isi'); ?>