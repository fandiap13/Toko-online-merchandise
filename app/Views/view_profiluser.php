<?= $this->extend('main/pembeli'); ?>

<?= $this->section('carousel'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">

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
<!-- Theme style -->
<div class="contact-from-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?= form_open_multipart(site_url('/profiluser/simpanPerubahan/' . session('LoggedUserData')['userid']), ['class' => 'formsimpan']); ?>
        <?= csrf_field(); ?>

        <div class="mb-3">
          <label class="form-label">Foto Profil</label>
          <div class="row">
            <div class="col-4">
              <?php if (isset($pembeli['profilpembeli'])) { ?>
                <img src="<?= base_url('gambar/profil/' . $pembeli['profilpembeli']); ?>" title="Profil Img" class="img-circle img-thumbnail img-preview" style="width: 200px;">
              <?php } else { ?>
                <img src="<?= base_url(); ?>/gambar/profil/default.png" title="Profil Img" class="img-circle img-thumbnail img-preview" style="width: 200px;">
              <?php } ?>
            </div>
            <div class="col-8">
              <input type="file" name="profilpembeli" class="form-control <?= $validation->hasError('profilpembeli') ? 'is-invalid' : ''; ?>" onchange="previewImg()">
              <div class="invalid-feedback">
                <?= $validation->getError('profilpembeli'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input type="text" name="emailpembeli" class="form-control <?= $validation->hasError('emailpembeli') ? 'is-invalid' : ''; ?>" value="<?= old('emailpembeli') ? old('emailpembeli') : $pembeli['emailpembeli']; ?>">
          <div class="invalid-feedback">
            <?= $validation->getError('emailpembeli'); ?>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="namapembeli" class="form-control <?= $validation->hasError('namapembeli') ? 'is-invalid' : ''; ?>" value="<?= old('namapembeli') ? old('namapembeli') : $pembeli['namapembeli']; ?>">
          <div class="invalid-feedback">
            <?= $validation->getError('namapembeli'); ?>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">No. Telp</label>
          <input type="text" name="telppembeli" class="form-control <?= $validation->hasError('telppembeli') ? 'is-invalid' : ''; ?>" value="<?= old('telppembeli') ? old('telppembeli') : $pembeli['telppembeli']; ?>">
          <div class="invalid-feedback">
            <?= $validation->getError('telppembeli'); ?>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Provinsi</label>
          <select name="provinsipembeli" class="form-control <?= $validation->hasError('provinsipembeli') ? 'is-invalid' : ''; ?> provinsi"></select>
          <div class="invalid-feedback">
            <?= $validation->getError('provinsipembeli'); ?>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Kota / Kabupaten</label>
          <select name="distrikpembeli" class="form-control <?= $validation->hasError('distrikpembeli') ? 'is-invalid' : ''; ?>" disabled></select>
          <div class="invalid-feedback">
            <?= $validation->getError('distrikpembeli'); ?>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea name="alamatpembeli" id="alamat" rows="3" class="form-control <?= $validation->hasError('alamatpembeli') ? 'is-invalid' : ''; ?>"><?= old('alamatpembeli') ? old('alamatpembeli') : $pembeli['alamatpembeli']; ?></textarea>
          <div class="invalid-feedback">
            <?= $validation->getError('alamatpembeli'); ?>
          </div>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-lg btn-block btn-primary btnSimpan" disabled>Simpan perubahan</button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>

<script>
  function previewImg() {
    const foto = document.querySelector('input[name=profilpembeli]');
    const imgPreview = document.querySelector('.img-preview');

    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(foto.files[0]);
    fileFoto.onload = function(e) {
      imgPreview.src = e.target.result;
    }
  }

  function daftarProvinsi() {
    $.ajax({
      url: "<?= site_url('/rajaongkir/dataprovinsi'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('select[name=provinsipembeli]').html(response.data);
        }

        <?php if ($pembeli['distrikpembeli'] !== null) : ?>
          daftarDistrik();
        <?php endif; ?>

        $('.btnSimpan').removeAttr('disabled');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function daftarDistrik() {
    $.ajax({
      url: "<?= site_url('/rajaongkir/datadistrik'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('select[name=distrikpembeli]').html(response.data);
          $('select[name=distrikpembeli]').removeAttr('disabled');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {
    daftarProvinsi();

    $('select[name=provinsipembeli]').change(function(e) {
      e.preventDefault();
      let id_provinsi = $(this).find(':selected').attr('id_provinsi');
      $.ajax({
        type: "post",
        url: "<?= site_url('/rajaongkir/datadistrik'); ?>",
        data: {
          id_provinsi: id_provinsi
        },
        dataType: "json",
        success: function(response) {
          if (response.data) {
            $('select[name=distrikpembeli]').html(response.data);
            $('select[name=distrikpembeli]').removeAttr('disabled');
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });
  });
</script>
<?= $this->endSection('isi'); ?>