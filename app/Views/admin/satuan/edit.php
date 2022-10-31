<div class="modal fade" id="modaledit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Satuan</h5>
      </div>
      <?= form_open(base_url() . '/admin/satuan/ubahdata/' . $data['satuanid'], ['class' => 'formubah']); ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Satuan</label>
          <input type="text" name="namasatuan" id="namasatuan" class="form-control" placeholder="Masukkan email" value="<?= $data['namasatuan']; ?>">
          <div class="invalid-feedback errornamasatuan"></div>
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
            datasatuan();
          }

          if (response.error) {
            if (response.error.namasatuan) {
              $('#namasatuan').addClass('is-invalid');
              $('.errornamasatuan').html(response.error.namasatuan);
            } else {
              $('#namasatuan').removeClass('is-invalid');
              $('.errornamasatuan').html('');
            }
          }

          if (response.sukses) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });
            $('#modaledit').modal('hide');
            datasatuan();
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