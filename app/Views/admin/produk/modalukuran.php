<div class="modal fade" id="modalukuran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Ukuran Produk</h5>
      </div>
      <div class="modal-body">
        <div class="error">

        </div>
        <?= form_open(base_url() . '/admin/produk/simpanukuran', ['class' => 'formsimpan']); ?>
        <?= csrf_field(); ?>
        <!-- ukuranprodukid -->
        <input type="hidden" name="ukuranprodukid" class="ukuranprodukid" value="">
        <!-- endukuranprodukid -->

        <!-- produkid -->
        <input type="hidden" name="produkid" value="<?= $produkid; ?>">
        <!-- endprodukid -->

        <div class="form-group">
          <label for="">Ukuran Produk</label>
          <input type="text" name="ukuran" id="ukuran" class="form-control" placeholder="Masukkan ukuran produk">
        </div>
        <div class="form-group">
          <label for="">Status Produk</label>
          <select name="status" id="status" class="form-control">
            <option value="">-- Pilih Status --</option>
            <option value="1">Tersedia</option>
            <option value="0">Habis</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Harga Produk (Rp)</label>
          <input type="text" class="form-control" id="hargaproduk" name="hargaproduk" placeholder="Harga Produk">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btnsimpan">Tambah</button>
        </div>
        <?= form_close(); ?>

        <div class="row dataukuran">

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('dist/js/autoNumeric.js'); ?>"></script>

<script>
  function dataukuran() {
    $.ajax({
      type: "post",
      url: "/admin/produk/dataukuranproduk",
      data: {
        produkid: $('input[name=produkid]').val()
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.dataukuran').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {

    $('#hargaproduk').autoNumeric('init', {
      mDec: 0,
      aSep: '.',
      aDec: ','
    });

    dataukuran();
  });

  $('.formsimpan').submit(function(e) {
    e.preventDefault();

    let form = $('.formsimpan')[0];
    let data = new FormData(form);
    data.append('hargaproduk', $('#hargaproduk').autoNumeric('get'));

    $.ajax({
      type: "post",
      url: $(this).attr('action'),
      data: data,
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
        $('.btnsimpan').html('Tambah');
      },
      success: function(response) {
        // console.log(response);
        if (response.pesanerror) {
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: response.pesanerror,
          });
          $('#modalukuran').modal('hide');
          dataproduk();
        }

        if (response.error) {
          $('.error').html(`
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-ban"></i> Error!</h5>
              ` + response.error + `
            </div>
            `);
        }

        if (response.sukses) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: response.sukses
          });
          dataukuran();
          $('.error').html("");

          $('#ukuran').val("");
          $('#ukuran').removeAttr('disabled');
          $('#status').val("");
          $('#hargaproduk').val("");

          // bagian ubah
          $('.formsimpan').attr('action', '<?= base_url() . '/admin/produk/simpanukuran'; ?>');
          $('.ukuranprodukid').val("");
          $('.btnsimpan').html("Tambah");
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
    return false;
  });
</script>