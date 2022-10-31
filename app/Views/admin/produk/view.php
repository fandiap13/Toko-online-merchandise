<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Produk', [
        'class' => 'btn btn-primary',
        'onclick' => "location.href=('" . site_url('/admin/produk/tambah') . "')"
      ]); ?>
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
  function dataproduk() {
    $.ajax({
      url: "/admin/produk/dataproduk",
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

  function lihat() {
    $.ajax({
      url: "/admin/produk/detailproduk",
      dataType: "json",
      success: function(response) {
        console.log(response.data);
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modaldetail').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }


  $(document).ready(function() {
    dataproduk();
  });
</script>

<?= $this->endSection('isi'); ?>