<div class="modal fade" id="modaleditsupport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
      </div>
      <div class="modal-body">
        <?= form_open_multipart(base_url() . '/admin/setting/ubahSupport', ['class' => 'formUbah']); ?>
        <input type="hidden" name="supportid" value="<?= $support['supportid']; ?>">
        <input type="hidden" name="settingid" value="<?= $support['settingid']; ?>">
        <div class="form-group">
          <label for="">Supported</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-copyright"></i>
              </span>
            </div>
            <input class="form-control" type="text" name="supported" value="<?= $support['supported']; ?>" id="supported">
            <div class="invalid-feedback errorsupportededit"></div>
          </div>
        </div>
        <div class="form-group">
          <label for="">Logo</label>
          <div class="row">
            <div class="col-md-3">
              <img src="<?= base_url(); ?>/gambar/setting/<?= $support['gambar']; ?>" class="img-thumbnail img-preview" id="gambarSupported">
            </div>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-image"></i>
                  </span>
                </div>
                <input type="hidden" name="gambarLama" value="<?= $support['gambar']; ?>">
                <input class="form-control previewImg gambar" type="file" name="gambar" id="gambar">
                <div class="invalid-feedback errorgambaredit"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="">Link website</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-globe"></i>
              </span>
            </div>
            <input class="form-control" type="text" name="linkwebsite" value="<?= $support['linkwebsite']; ?>" id="linkwebsite">
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-primary btnSupportedEdit">Simpan perubahan</button>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function hideModal() {
    $('body').removeClass('modal-open');
    $('body').css('padding-right', '');
    $(".modal-backdrop").remove();
    $('#modaleditsupport').hide();
  }

  function clearInvalidFeedbackModal() {
    $('#supported').removeClass('is-invalid');
    $('#gambar').removeClass('is-invalid');
  }

  $('.formUbah').submit(function(e) {
    e.preventDefault();

    clearInvalidFeedbackModal();

    let form = $('.formUbah')[0];
    let data = new FormData(form);

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
        $('.btnSupportedEdit').prop('disabled', 'disabled');
        $('.btnSupportedEdit').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      complete: function(e) {
        $('.btnSupportedEdit').removeAttr('disabled');
        $('.btnSupportedEdit').html('Simpan perubahan');
      },
      success: function(response) {
        // console.log(response);
        if (response.sukses) {
          Swal.fire('Berhasil', response.sukses, 'success');
          $('#modaleditsupport').modal('hide');
          dataSupport();
        }

        if (response.kosong) {
          Swal.fire('Kesalahan', response.kosong, 'error');
          $('#modaleditsupport').modal('hide');
          dataSupport();
        }

        if (response.errors) {
          if (response.errors.supported) {
            $('.errorsupportededit').html(response.errors.supported);
            $('#supported').addClass('is-invalid');
          }
          if (response.errors.gambar) {
            $('.errorgambaredit').html(response.errors.gambar);
            $('#gambar').addClass('is-invalid');
          }
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
    return false;
  });

  $(document).ready(function() {
    $('.previewImg').change(function(e) {
      e.preventDefault();
      const foto = this;
      const imgPreview = this.parentElement.parentElement.parentElement.querySelector('.col-md-3 .img-preview');

      const fileFoto = new FileReader();
      fileFoto.readAsDataURL(foto.files[0]);
      fileFoto.onload = function(e) {
        imgPreview.src = e.target.result;
      }
    });
  });
</script>