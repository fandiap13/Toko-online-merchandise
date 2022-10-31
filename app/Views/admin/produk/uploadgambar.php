<div class="modal fade" id="modalupload" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Upload Gambar Produk</h5>
      </div>
      <?= form_open_multipart(base_url() . '/admin/produk/simpangambar', ['class' => 'formsimpan']); ?>
      <?= csrf_field(); ?>
      <input type="hidden" name="produkid" value="<?= $produkid; ?>">
      <div class="modal-body">
        <div class="form-group">
          <label for="">Gambar Produk</label>
          <div class="row">
            <div class="col-md-8">
              <input type="file" name="gambarproduk" class="form-control" id="gambarproduk" required>
              <div class="invalid-feedback errorgambarproduk"></div>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-primary btnsimpan">Tambah Gambar</button>
            </div>
          </div>
        </div>
        <?= form_close(); ?>

        <div class="row datagambar">

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function datagambar() {
    $.ajax({
      type: "post",
      url: "/admin/produk/datagambar",
      data: {
        produkid: $('input[name=produkid]').val()
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.datagambar').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {
    datagambar();

    $('.formsimpan').submit(function(e) {
      e.preventDefault();

      let form = $('.formsimpan')[0];
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
        beforeSend: function() {
          $('.btnsimpan').prop('disabled', true);
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').prop('disabled', false);
          $('.btnsimpan').html('Tambah Gambar');
        },
        success: function(response) {
          // console.log(response);
          if (response.error) {
            if (response.error.gambarproduk) {
              $('#gambarproduk').addClass('is-invalid');
              $('.errorgambarproduk').html(response.error.gambarproduk);
            } else {
              $('#gambarproduk').removeClass('is-invalid');
              $('.errorgambarproduk').html('');
            }
          }

          if (response.pesanerror) {
            Swal.fire({
              icon: 'error',
              title: 'Kesalahan',
              text: response.pesanerror,
            });
            $('#modalupload').modal('hide');
            dataproduk();
          }

          if (response.sukses) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });
            datagambar();
            $('#gambarproduk').val('');
            $('#gambarproduk').removeClass('is-invalid');
            $('.errorgambarproduk').html('');
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