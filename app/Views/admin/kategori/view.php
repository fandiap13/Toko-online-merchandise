<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <button type="button" id="tambah" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Kategori</button>
    </h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <div class="card-body viewdata">

  </div>
</div>

<div class="viewmodal" style="display:none;"></div>

<script>
  function datakategori() {
    $.ajax({
      url: "/admin/kategori/datakategori",
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

  $('#tambah').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "/admin/kategori/tambah",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modaltambah').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  });

  $(document).ready(function() {
    datakategori();
  });
</script>

<?= $this->endSection('isi'); ?>