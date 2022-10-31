<div class="modal fade" id="modaltambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Kategori</h5>
      </div>
      <?= form_open(base_url() . '/admin/kategori/simpandata', ['class' => 'formsimpan']); ?>
      <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Kategori</label>
          <input type="text" name="namakategori" id="namakategori" class="form-control" placeholder="Masukkan nama">
          <div class="invalid-feedback errornamakategori"></div>
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
    $('.formsimpan').submit(function(e) {
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
          if (response.error) {
            if (response.error.namakategori) {
              $('#namakategori').addClass('is-invalid');
              $('.errornamakategori').html(response.error.namakategori);
            } else {
              $('#namakategori').removeClass('is-invalid');
              $('.errornamakategori').html('');
            }
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });
            $('#modaltambah').modal('hide');
            datakategori();
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