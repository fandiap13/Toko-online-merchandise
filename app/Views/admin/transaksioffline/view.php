<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-md-2">
        <label for="">Filter Data</label>
      </div>
      <div class="col-md-4">
        <input type="date" name="tglawal" class="form-control" id="tglawal">
      </div>
      <div class="col-md-4">
        <input type="date" name="tglakhir" class="form-control" id="tglakhir">
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-block btn-primary" id="tombolcari">
          Tampilkan
        </button>
      </div>
    </div>

  </div>
  <div class="card-body">
    <div class="viewdata"></div>
  </div>
</div>

<div class="form-group text-right">
  <?= form_button('', '<i class="fa fa-plus-circle"></i> Input Transaksi', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('/admin/transaksioffline/tambah') . "')"
  ]); ?>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
  function datatransoffline() {
    $.ajax({
      url: "<?= site_url('/admin/transaksioffline/datatransaksi'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewdata').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  $(document).ready(function() {
    datatransoffline();
  });
</script>

<?= $this->endSection('isi'); ?>