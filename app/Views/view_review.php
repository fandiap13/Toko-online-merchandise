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

<div class="contact-from-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 5%;">No</th>
              <th>Gambar Produk</th>
              <th style="width: 50%;">Produk</th>
              <th>Aksi</th>
            </tr>
          <tbody>
            <?php
            $nomor = 1;
            foreach ($detail as $key => $value) :
            ?>
              <tr>
                <td><?= $nomor; ?></td>
                <td>
                  <a href="<?= site_url('/detailproduk/' . $value['produkid']); ?>">
                    <img src="<?= base_url('gambar/produk/' . $value['gambarutama']); ?>" title="Gambar Produk" style="width: 150px;">
                  </a>
                </td>
                <td><?= $value['namaproduk']; ?></td>
                <td>
                  <button type="button" class="btn btn-sm btn-info" onclick="modalReview('<?= $value['id']; ?>')"><i class="fa fa-comment"></i> Review</button>
                </td>
              </tr>
            <?php
              $nomor++;
            endforeach; ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- end contact form -->

<div class="viewmodal" style="display: none;"></div>

<script>
  function modalReview(id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('/review/modalReview'); ?>",
      data: {
        detailtransid: id,
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modalreview').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }
</script>

<?= $this->endSection('isi'); ?>