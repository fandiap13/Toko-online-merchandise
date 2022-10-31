<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>
<!-- ChartJS -->
<script src="<?= base_url(); ?>/plugins/chart.js/Chart.min.js"></script>

<div class="card">
  <div class="card-header">
    <?= form_button('', '<i class="fas fa-sync-alt"></i> Refresh', [
      'class' => 'btn btn-warning',
      'onclick' => "location.href=('" . site_url('/admin/laporan/cetak-transaksi-online') . "')"
    ]); ?>
  </div>
  <div class="card-body">
    <!-- STACKED BAR CHART -->
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Cari Laporan Transaksi</h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <?= form_open(base_url('/admin/laporan/cetak-laporan-transaksi-online-periode')); ?>
            <div class="form-group">
              <label for="">Tanggal Awal</label>
              <input type="date" name="tglawal" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="">Tanggal Akhir</label>
              <input type="date" name="tglakhir" class="form-control" required>
            </div>
            <div class="form-group">
              <button type="submit" name="cetak" class="btn btn-block btn-primary">Cetak</button>
            </div>
            <?= form_close(); ?>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <!-- /.card -->
      <div class="col-lg-8">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Grafik Laporan Transaksi Online</h3>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="">Pilih Bulan</label>
              <div class="input-group mb-3">
                <input type="month" id="bulan" class="form-control" value="<?= date('Y-m'); ?>" required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-sm btn-primary" id="tombolTampil">Tampil</button>
                </div>
              </div>
            </div>
            <div class="viewtampilgrafik"></div>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.card -->
  </div>
</div>

<script>
  function tampilgrafik() {
    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/laporan/tampilgrafiktransaksionline'); ?>",
      data: {
        bulan: $('#bulan').val()
      },
      dataType: "json",
      beforeSend: function() {
        $('.viewtampilgrafik').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      success: function(response) {
        if (response.data) {
          $('.viewtampilgrafik').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }
  $(document).ready(function() {
    tampilgrafik();

    $('#tombolTampil').click(function(e) {
      e.preventDefault();
      tampilgrafik();
    });
  });
</script>
<?= $this->endSection('isi'); ?>