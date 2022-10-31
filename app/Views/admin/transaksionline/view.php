<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="card">
  <div class="card-header">
    <label for="">Filter Data</label>
    <div class="row">
      <div class="col-md-3">
        <input type="date" name="tglawal" class="form-control" id="tglawal">
      </div>
      <div class="col-md-3">
        <input type="date" name="tglakhir" class="form-control" id="tglakhir">
      </div>
      <div class="col-md-4">
        <select name="statuspembelian" id="statuspembelian" class="form-control">
          <option value="">-- Pilih status pembelian --</option>
          <option value="diproses">Diproses</option>
          <option value="pending">Pending</option>
          <option value="dikirim">Dikirim</option>
          <option value="diterima">Diterima</option>
          <option value="gagal">Gagal</option>
        </select>
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

<div class="viewmodal" style="display: none;"></div>

<script>
  function datatransaksionline() {
    $.ajax({
      url: "<?= site_url('/admin/transaksionline/datatransaksi'); ?>",
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
    datatransaksionline();
  });
</script>

<?= $this->endSection('isi'); ?>