<div class="modal fade" id="modaledit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Admin</h5>
      </div>
      <?= form_open(base_url() . '/admin/admin/ubahdata/' . $data['adminid'], ['class' => 'formubah']); ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="">E-mail</label>
          <input type="text" name="emailadmin" id="emailadmin" class="form-control" placeholder="Masukkan email" value="<?= $data['emailadmin']; ?>">
          <div class="invalid-feedback erroremailadmin"></div>
        </div>
        <div class="form-group">
          <label for="">Nama</label>
          <input type="text" name="namaadmin" id="namaadmin" class="form-control" placeholder="Masukkan nama" value="<?= $data['namaadmin']; ?>">
          <div class="invalid-feedback errornamaadmin"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-primary btnsimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.formubah').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpan').prop('disabled', true);
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').prop('disabled', false);
          $('.btnsimpan').html('Simpan');
        },
        success: function(response) {
          if (response.pesanerror) {
            // console.log(response.pesanerror);
            Swal.fire({
              icon: 'error',
              title: 'Kesalahan',
              text: response.pesanerror,
            });
            $('#modaledit').modal('hide');
            dataadmin();
          }

          if (response.error) {
            if (response.error.emailadmin) {
              $('#emailadmin').addClass('is-invalid');
              $('.erroremailadmin').html(response.error.emailadmin);
            } else {
              $('#emailadmin').removeClass('is-invalid');
              $('.erroremailadmin').html('');
            }
            if (response.error.namaadmin) {
              $('#namaadmin').addClass('is-invalid');
              $('.errornamaadmin').html(response.error.namaadmin);
            } else {
              $('#namaadmin').removeClass('is-invalid');
              $('.errornamaadmin').html('');
            }
          }

          if (response.sukses) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });
            $('#modaledit').modal('hide');
            dataadmin();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    });
  });
</script>