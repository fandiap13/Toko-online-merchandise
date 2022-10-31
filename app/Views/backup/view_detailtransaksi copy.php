<?= $this->extend('main/pembeli'); ?>

<?= $this->section('isi'); ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><?= $title; ?></h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <?php if ($datatransaksi['statuspembayaran'] == 0) : ?>
        <div class="alert alert-danger alert-dismissible">
          <h5><i class="icon fas fa-check"></i> Pembayaran</h5>
          Silahkan melakukan pembayaran sebesar <b>Rp <?= number_format($datatransaksi['totalbayar'], 0, ",", "."); ?></b>
        </div>
      <?php endif; ?>
    </div><!-- /.container-fluid -->
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <h5 class="card-header">
              Data Pengiriman
            </h5>
            <div class="card-body">
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
                <?php
                if ($datatransaksi['statuspembelian'] == 0) {
                  $status = '<nav class="badge badge-info">Diperoses</nav>';
                }
                ?>
                <li><b>Status Transaksi:</b> <?= $status; ?></li>
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
                        <td><?= $row['ukuran']; ?></td>
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
          <button class="btn btn-lg btn-success"><i class="fa fa-print"></i> Cetak Invoice</button>
          <?php if ($datatransaksi['statuspembayaran'] == 0) : ?>
            <button class="btn btn-lg btn-primary" title="pembayaran" id="pembayaran" onclick="pembayaran('<?= $datatransaksi['transonlineid']; ?>')"><i class="fa fa-money-bill"></i> Pembayaran</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-server-o4cVLaEqV9hq5Og_l3wDYZk5"></script>
<script type="text/javascript">
  function pembayaran(transonlineid) {
    $.ajax({
      type: "post",
      url: "<?= site_url('/transaksi/pembayaranMidtrans'); ?>",
      data: {
        transonlineid: transonlineid
      },
      dataType: "json",
      success: function(response) {
        console.log(response);
        if (response.error) {
          Swal.fire('Kesalahan', response.error, 'error');
        }

        if (response.snapToken) {
          snap.pay(response.snapToken, {
            // Optional
            onSuccess: function(result) {
              // let dataResult = JSON.stringify(result, null, 2);
              // let dataObjek = json.parse(dataResult);

              // $.ajax({
              //   type: "post",
              //   url: "/transaksi/finishPembayaran",
              //   data: {
              //     transonlineid: response.transonlineid,
              //     order_id: dataObjek.order_id,
              //     payment_type: dataObjek.payment_type,
              //     waktupembayaran: dataObjek.transaction_time,
              //     statuspembayaran: dataObjek.transaction_status,
              //     va_number: dataObjek.va_numbers[0].va_number,
              //     bank: dataObjek.va_numbers[0].bank,
              //   },
              //   dataType: "json",
              //   success: function(response) {
              //     if (response.sukses) {
              //       Swal.fire('Sukses', response.sukses, 'success').then(function() {
              //         window.location.reload();
              //       });
              //     }
              //   }
              // });
              /* You may add your own js here, this is just example */
              console.log(JSON.stringify(result, null, 2))
            },
            // Optional
            onPending: function(result) {
              let dataResult = JSON.stringify(result, null, 2);
              let dataObjek = json.parse(dataResult);

              // $.ajax({
              //   type: "post",
              //   url: "/transaksi/finishPembayaran",
              //   data: {
              //     transonlineid: response.transonlineid,
              //     order_id: dataObjek.order_id,
              //     payment_type: dataObjek.payment_type,
              //     waktupembayaran: dataObjek.transaction_time,
              //     statuspembayaran: dataObjek.transaction_status,
              //     va_number: dataObjek.va_numbers[0].va_number,
              //     bank: dataObjek.va_numbers[0].bank,
              //   },
              //   dataType: "json",
              //   success: function(response) {
              //     console.log('respon adalah :' + response);
              //     if (response.sukses) {
              //       alert(response.sukses);
              //       window.location.reload();
              //     }
              //   }
              // });
              /* You may add your own js here, this is just example */
              console.log(JSON.stringify(result, null, 2));
            },
            // Optional
            onError: function(result) {
              let dataResult = JSON.stringify(result, null, 2);
              let dataObjek = json.parse(dataResult);

              $.ajax({
                type: "post",
                url: "/transaksi/finishPembayaran",
                data: {
                  transonlineid: response.transonlineid,
                  order_id: dataObjek.order_id,
                  payment_type: dataObjek.payment_type,
                  waktupembayaran: dataObjek.transaction_time,
                  statuspembayaran: dataObjek.transaction_status,
                  va_number: dataObjek.va_numbers[0].va_number,
                  bank: dataObjek.va_numbers[0].bank,
                },
                dataType: "json",
                success: function(response) {
                  if (response.sukses) {
                    Swal.fire('Sukses', response.sukses, 'success').then(function() {
                      window.location.reload();
                    });
                  }
                }
              });
              /* You may add your own js here, this is just example */
              console.log(JSON.stringify(result, null, 2))
            }
          });
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }
</script>

<?= $this->endSection('isi'); ?>