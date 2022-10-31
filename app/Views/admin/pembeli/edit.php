<div class="modal fade" id="modaledit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Pembeli</h5>
      </div>
      <?= form_open(base_url() . '/admin/pembeli/ubahdata/' . $data['pembeliid'], ['class' => 'formubah']); ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="">E-mail</label>
          <input type="text" name="emailpembeli" id="emailpembeli" class="form-control" placeholder="Masukkan email" value="<?= $data['emailpembeli']; ?>">
          <div class="invalid-feedback erroremailpembeli"></div>
        </div>
        <div class="form-group">
          <label for="">Nama</label>
          <input type="text" name="namapembeli" id="namapembeli" class="form-control" placeholder="Masukkan nama" value="<?= $data['namapembeli']; ?>">
          <div class="invalid-feedback errornamapembeli"></div>
        </div>
        <div class="form-group">
          <label for="">No. Telp</label>
          <input type="number" name="telppembeli" id="telppembeli" class="form-control" placeholder="Masukkan no. telp" value="<?= $data['telppembeli']; ?>">
          <div class="invalid-feedback errortelppembeli"></div>
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
            datapembeli();
          }

          if (response.error) {
            if (response.error.emailpembeli) {
              $('#emailpembeli').addClass('is-invalid');
              $('.erroremailpembeli').html(response.error.emailpembeli);
            } else {
              $('#emailpembeli').removeClass('is-invalid');
              $('.erroremailpembeli').html('');
            }

            if (response.error.namapembeli) {
              $('#namapembeli').addClass('is-invalid');
              $('.errornamapembeli').html(response.error.namapembeli);
            } else {
              $('#namapembeli').removeClass('is-invalid');
              $('.errornamapembeli').html('');
            }

            if (response.error.telppembeli) {
              $('#telppembeli').addClass('is-invalid');
              $('.errortelppembeli').html(response.error.telppembeli);
            } else {
              $('#telppembeli').removeClass('is-invalid');
              $('.errortelppembeli').html('');
            }
          }

          if (response.sukses) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });
            $('#modaledit').modal('hide');
            datapembeli();
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