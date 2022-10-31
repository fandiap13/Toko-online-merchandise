<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<!-- <div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-center">

      hai
    </div>
  </div>
</div> -->

<div class="card">
  <div class="card-header">
    <h1 class="card-title">Grafik Transaksi Penjualan</h1>
  </div>
  <div class="card-body">
    <div class="viewtampilgrafik"></div>
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