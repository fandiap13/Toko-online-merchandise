<?= $this->extend('main/main'); ?>
<?= $this->section('isi'); ?>

<div class="card">
  <div class="card-header">
    <?= form_button('', '<i class="fas fa-arrow-left"></i> Kembali', [
      'class' => 'btn btn-warning',
      'onclick' => "location.href=('" . site_url('/admin/laporan/cetak-laporan-akhir') . "')"
    ]); ?>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Cari Laporan Akhir</h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <?= form_open(base_url('/admin/laporan/cetak-laporan-akhir-periode')); ?>
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
      <div class="col-md-8">
        <!-- BAR CHART -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Grafik Laporan Akhir</h3>
          </div>
          <div class="card-body">
            <!-- <div class="form-group">
              <label for="">Pilih Bulan</label>
              <div class="input-group mb-3">
                <input type="month" id="bulan" class="form-control" value="<?= date('Y-m'); ?>" required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-sm btn-primary" id="tombolTampil">Tampil</button>
                </div>
              </div>
            </div> -->
            <div class="viewtampilgrafik"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</div>


<script>
  function tampilgrafik() {
    $.ajax({
      url: "<?= site_url('/admin/laporan/grafiklaporanakhir'); ?>",
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
  });
</script>

<?= $this->endSection('isi'); ?>