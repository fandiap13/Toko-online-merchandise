<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<div class="row">
  <div class="col-md-4">
    <div class="card">
      <h5 class="card-header">
        Data Pengiriman
      </h5>
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
  <div class="col-md-8">
    <div class="card">
      <h5 class="card-header">Transaksi</h5>
      <div class="card-body">
        <ul>
          <li><b>ID Transaksi:</b> <?= $datatransaksi['transonlineid']; ?></li>
          <li><b>Tanggal Transaksi:</b> <?= date('d-m-Y H:i:s', strtotime($datatransaksi['tgltransaksi'])); ?></li>
          <li><b>Pembeli:</b> <?= $datatransaksi['namapembeli']; ?></li>
          <li><b>E-mail Pembeli:</b> <?= $datatransaksi['emailpembeli']; ?></li>
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
        </ul>
      </div>
    </div>

    <div class="card">
      <h5 class="card-header">Pembayaran</h5>
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
          <?php } elseif ($datatransaksi['payment_type'] == 'bank_transfer') { ?>
            <li><b>Nama Bank:</b> <?= $statuspayment->va_numbers[0]->bank; ?></li>
            <li><b>Total Pembayaran:</b> Rp <?= number_format($statuspayment->gross_amount, 0, ",", "."); ?></li>
          <?php } ?>
        </ul>
      </div>
    </div>

    <div class="card">
      <h5 class="card-header">
        Detail Transaksi
      </h5>
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
    <button class="btn btn-lg btn-success mb-3"><i class="fa fa-print"></i> Cetak Invoice</button>
  </div>
</div>

<?= $this->endSection('isi'); ?>