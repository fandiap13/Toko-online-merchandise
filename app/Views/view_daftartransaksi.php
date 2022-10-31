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
    <div class="card">
      <div class="card-body">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Estimasi (Hari)</th>
                <th>Status Pembayaran</th>
                <th>Status Pembelian</th>
                <th>Jumlah</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1 + (($nohalaman - 1) * 5);
              foreach ($datatransaksi as $row) :
              ?>
                <tr>
                  <td><?= $no++; ?>.</td>
                  <td><?= $row['transonlineid']; ?></td>
                  <td><?= date('d-m-Y', strtotime($row['tgltransaksi'])); ?></td>
                  <td><?= $row['estimasi']; ?></td>
                  <td>
                    <?php if ($row['statuspembayaran'] == 'pending') { ?>
                      <nav class="badge badge-secondary">Pending</nav>
                    <?php } elseif ($row['statuspembayaran'] == 'settlement') { ?>
                      <nav class="badge badge-success">Sukses</nav>
                    <?php } else { ?>
                      <nav class="badge badge-danger">Expire</nav>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($row['statuspembelian'] == 'diproses') { ?>
                      <nav class="badge badge-warning">Diproses</nav>
                    <?php } elseif ($row['statuspembelian'] == 'pending') { ?>
                      <nav class="badge badge-secondary">Pending</nav>
                    <?php } elseif ($row['statuspembelian'] == 'dikirim') { ?>
                      <nav class="badge badge-info">Dikirim</nav>
                    <?php } elseif ($row['statuspembelian'] == 'diterima') { ?>
                      <nav class="badge badge-success">Diterima</nav>
                    <?php } else { ?>
                      <nav class="badge badge-danger">Gagal</nav>
                    <?php } ?>
                  </td>
                  <td>
                    <?php
                    $db = \Config\Database::connect();
                    $jmldetail = $db->table('tbl_detail_transaksionline')
                      ->where('transonlineid', $row['transonlineid'])
                      ->countAllResults();
                    ?>
                    <button type="button" class="btn btn-outline-info" onclick="lihattransaksi('<?= sha1($row['transonlineid']); ?>')"><?= $jmldetail; ?></button>
                  </td>
                  <td>Rp <?= number_format($row['totalbayar'], 0, ",", "."); ?></td>
                  <td>
                    <button class="btn btn-sm btn-primary" title="Lihat Transaksi" onclick="lihattransaksi('<?= sha1($row['transonlineid']); ?>');"><i class="fa fa-eye"></i></button>

                    <a href="<?= site_url('/cetak-transaksi/' . sha1($row['transonlineid'])); ?>" target="_blank" class="btn btn-sm btn-secondary" title="Cetak Transaksi"><i class="fas fa-print"></i></a>

                    <a href="https://wa.me/<?= $nowa; ?>" class="btn btn-sm btn-success" target="_blank" title="Hubungi penjual"><i class="fab fa-whatsapp"></i> </a>

                    <?php if ($row['statuspembayaran'] == 'pending') { ?>
                      <button class="btn btn-sm btn-info" title="Pembayaran" onclick="pembayaran('<?= $row['snapToken']; ?>');"><i class="fas fa-money-bill"></i></button>
                    <?php } ?>

                    <!-- 'cancel', 'failure', 'expire' -->
                    <?php if ($row['statuspembayaran'] == "expire" || $row['statuspembayaran'] == "failure" || $row['statuspembayaran'] == "cancel") { ?>
                      <button class="btn btn-sm btn-danger" title="Hapus Transaksi" onclick="hapusTransaksi('<?= $row['transonlineid']; ?>')"><i class="fa fa-trash-alt"></i></button>
                    <?php } ?>

                    <?php
                    $db = \Config\Database::connect();
                    $dataReview = $db->table('tbl_transaksionline')
                      ->getWhere([
                        'transonlineid' => $row['transonlineid'],
                        'statuspembelian' => 'diterima',
                        'statuspembayaran' => 'settlement',
                      ])->getRowArray();
                    if ($dataReview) :
                    ?>
                      <button class="btn btn-sm btn-info" onclick="window.location='<?= site_url('/review/' . $row['transonlineid']); ?>'"><i class="fas fa-comment"></i> Review</button>
                    <?php endif; ?>

                  </td>
                </tr>
              <?php
              endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php if ($pager->getPageCount('daftar-transaksi') > 1) : ?>
          <div class="float-center mt-2">
            <?= $pager->links('daftar-transaksi', 'paging_daftar-transaksi'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= getenv('API_KEY_MIDTRANS'); ?>"></script>

<script>
  function pembayaran(snapToken) {
    snap.pay(snapToken, {
      // Optional
      onSuccess: function(result) {
        /* You may add your own js here, this is just example */
        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        window.location.reload();
      },
      // Optional
      onPending: function(result) {
        /* You may add your own js here, this is just example */
        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        window.location.reload();
      },
      // Optional
      onError: function(result) {
        /* You may add your own js here, this is just example */
        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        // window.location.reload();
        window.location = "<?= site_url('/daftar-transaksi'); ?>";
      },
      onClose: function() {
        window.location.reload();
      }
    });
  }
</script>

<script>
  function lihattransaksi(transonlineid) {
    window.location = "<?= site_url('/detail-transaksi/'); ?>" + transonlineid;
  }

  function hapusTransaksi(transonlineid) {
    Swal.fire({
      title: 'Hapus Transaksi',
      text: `Apakah anda yakin ingin menghapus transaksi dengan ID ${transonlineid}`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'tidak',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= site_url('/transaksi/hapusTransaksi'); ?>",
          data: {
            transonlineid: transonlineid
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire('berhasil', response.sukses, 'success').then(function() {
                window.location.reload();
              });
            }
            if (response.gagal) {
              Swal.fire('kesalahan', response.gagal, 'danger').then(function() {
                window.location.reload();
              });
            }
          }
        });
      }
    })
  }
</script>

<?= $this->endSection('isi'); ?>