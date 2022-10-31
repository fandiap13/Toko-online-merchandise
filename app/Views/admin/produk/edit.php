<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <?= form_button('', '<i class="fas fa-arrow-left"></i> Kembali', [
        'class' => 'btn btn-warning',
        'onclick' => "location.href=('" . site_url('/admin/produk/index') . "')"
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
  <div class="card-body">
    <form class="formsimpan" action="<?= site_url('/admin/produk/ubahdata'); ?>" method="post">
      <?= csrf_field(); ?>
      <input type="hidden" name="produkid" value="<?= $dataProduk['produkid']; ?>">
      <div class="form-group">
        <label for="">Nama Produk</label>
        <input type="text" name="namaproduk" id="namaproduk" class="form-control" placeholder="Masukkan nama produk" value="<?= $dataProduk['namaproduk']; ?>">
        <div class="invalid-feedback errornamaproduk"></div>
      </div>

      <div class="form-group">
        <label for="">Foto</label>
        <div class="row">
          <div class="col-md-3">
            <img src="<?= base_url(); ?>/gambar/produk/<?= $dataProduk['gambarutama']; ?>" class="img-thumbnail img-preview">
          </div>
          <div class="col-md-9">
            <input class="form-control" type="file" id="gambarutama" name="gambarutama" onchange="previewImg()">
            <div class="invalid-feedback errorgambarutama">

            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="">Kategori</label>
        <select class="form-control" name="kategoriid" id="kategoriid">
          <option value="">-- Pilih --</option>
          <?php foreach ($dataKategori as $k) : ?>
            <option value="<?= $k['kategoriid']; ?>" <?= $dataProduk['kategoriid'] == $k['kategoriid'] ? 'selected' : ''; ?>><?= $k['namakategori']; ?></option>
          <?php endforeach; ?>
        </select>
        <div class="invalid-feedback errorkategoriid"></div>
      </div>

      <div class="form-group">
        <label for="">Satuan</label>
        <select class="form-control" name="satuanid" id="satuanid">
          <option value="">-- Pilih --</option>
          <?php foreach ($dataSatuan as $k) : ?>
            <option value="<?= $k['satuanid']; ?>" <?= $dataProduk['satuanid'] == $k['satuanid'] ? 'selected' : ''; ?>><?= $k['namasatuan']; ?></option>
          <?php endforeach; ?>
        </select>
        <div class="invalid-feedback errorsatuanid"></div>
      </div>

      <div class="form-group">
        <label for="">Deskripsi</label>
        <textarea name="deskripsiproduk" class="summernote" id="deskripsiproduk"><?= $dataProduk['deskripsiproduk']; ?></textarea>
        <div class="invalid-feedback errordeskripsiproduk"></div>
        <!-- <div class="click"><button>tekan</button></div> -->
      </div>

      <div class="form-group">
        <label for="">Harga Produk</label>
        <input type="text" name="hargaproduk" id="hargaproduk" class="form-control" placeholder="Masukkan harga produk" value="<?= $dataProduk['hargaproduk']; ?>">
        <div class="invalid-feedback errorhargaproduk"></div>
      </div>

      <div class="form-group">
        <label for="">Berat Produk</label>
        <input type="text" name="beratproduk" id="beratproduk" class="form-control" placeholder="Masukkan harga produk" value="<?= $dataProduk['beratproduk']; ?>">
        <div class="invalid-feedback errorberatproduk"></div>
      </div>

      <div class="form-group">
        <label for="">Status Produk</label>
        <select class="form-control" name="statusproduk" id="statusproduk">
          <option value="">-- Pilih --</option>
          <option value=1 <?= $dataProduk['statusproduk'] == 1 ? 'selected' : ''; ?>>Tersedia</option>
          <option value=0 <?= $dataProduk['statusproduk'] == 0 ? 'selected' : ''; ?>>Habis</option>
        </select>
        <div class="invalid-feedback errorstatusproduk"></div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-success btnsimpan">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script src="<?= base_url('dist/js/autoNumeric.js'); ?>"></script>

<script>
  $(document).ready(function() {
    $('#hargaproduk').autoNumeric('init', {
      mDec: 0,
      aSep: '.',
      aDec: ','
    });
    $('#beratproduk').autoNumeric('init', {
      mDec: 0,
      aSep: '.',
      aDec: ','
    });

    // Summernote
    $('.summernote').summernote({
      height: '200px',
    })

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  });

  $('.formsimpan').submit(function(e) {
    e.preventDefault();

    let form = $('.formsimpan')[0];
    let data = new FormData(form);
    data.append('hargaproduk', $('#hargaproduk').autoNumeric('get'));
    data.append('beratproduk', $('#beratproduk').autoNumeric('get'));

    $.ajax({
      type: "post",
      url: $(this).attr('action'),
      data: data,
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
      beforeSend: function(e) {
        $('.btnsimpan').prop('disabled', 'disabled');
        $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      complete: function(e) {
        $('.btnsimpan').removeAttr('disabled');
        $('.btnsimpan').html('Simpan');
      },
      success: function(response) {
        // console.log(response);
        if (response.error) {
          if (response.error.namaproduk) {
            $('#namaproduk').addClass('is-invalid');
            $('.errornamaproduk').html(response.error.namaproduk);
          } else {
            $('#namaproduk').removeClass('is-invalid');
            $('.errornamaproduk').html('');
          }

          if (response.error.kategoriid) {
            $('#kategoriid').addClass('is-invalid');
            $('.errorkategoriid').html(response.error.kategoriid);
          } else {
            $('#kategoriid').removeClass('is-invalid');
            $('.errorkategoriid').html('');
          }

          if (response.error.satuanid) {
            $('#satuanid').addClass('is-invalid');
            $('.errorsatuanid').html(response.error.satuanid);
          } else {
            $('#satuanid').removeClass('is-invalid');
            $('.errorsatuanid').html('');
          }

          if (response.error.deskripsiproduk) {
            $('#deskripsiproduk').addClass('is-invalid');
            $('.errordeskripsiproduk').html(response.error.deskripsiproduk);
          } else {
            $('#deskripsiproduk').removeClass('is-invalid');
            $('.errordeskripsiproduk').html('');
          }

          if (response.error.hargaproduk) {
            $('#hargaproduk').addClass('is-invalid');
            $('.errorhargaproduk').html(response.error.hargaproduk);
          } else {
            $('#hargaproduk').removeClass('is-invalid');
            $('.errorhargaproduk').html('');
          }

          if (response.error.beratproduk) {
            $('#beratproduk').addClass('is-invalid');
            $('.errorberatproduk').html(response.error.beratproduk);
          } else {
            $('#beratproduk').removeClass('is-invalid');
            $('.errorberatproduk').html('');
          }

          if (response.error.statusproduk) {
            $('#statusproduk').addClass('is-invalid');
            $('.errorstatusproduk').html(response.error.statusproduk);
          } else {
            $('#statusproduk').removeClass('is-invalid');
            $('.errorstatusproduk').html('');
          }

          if (response.error.gambarutama) {
            $('#gambarutama').addClass('is-invalid');
            $('.errorgambarutama').html(response.error.gambarutama);
          } else {
            $('#gambarutama').removeClass('is-invalid');
            $('.errorgambarutama').html('');
          }
        }

        if (response.pesanerror) {
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: response.pesanerror,
          }).then(function() {
            window.location = "<?= site_url('/admin/produk/index'); ?>";
          })
        }

        if (response.sukses) {
          Swal.fire({
            icon: 'success',
            title: 'berhasil',
            text: response.sukses
          });
          $('#namaproduk').removeClass('is-invalid');
          $('.errornamaproduk').html('');
          $('#gambarutama').removeClass('is-invalid');
          $('#gambarutama').val('');
          $('.errorgambarutama').html('');
          $('#kategoriid').removeClass('is-invalid');
          $('.errorkategoriid').html('');
          $('#satuanid').removeClass('is-invalid');
          $('.errorsatuanid').html('');
          $('#deskripsiproduk').removeClass('is-invalid');
          $('.errordeskripsiproduk').html('');
          $('#hargaproduk').removeClass('is-invalid');
          $('.errorhargaproduk').html('');
          $('#beratproduk').removeClass('is-invalid');
          $('.errorberatproduk').html('');
          $('#statusproduk').removeClass('is-invalid');
          $('.errorstatusproduk').html('');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
    return false;
  });

  function previewImg() {
    const foto = document.querySelector('#gambarutama');
    const imgPreview = document.querySelector('.img-preview');

    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(foto.files[0]);
    fileFoto.onload = function(e) {
      imgPreview.src = e.target.result;
    }
  }

  // $('.click').click(function(e) {
  //   e.preventDefault();
  //   // $('input[type=text]').val('');
  //   $('#deskripsiproduk').summernote('reset');
  // });
</script>

<?= $this->endSection('isi'); ?>