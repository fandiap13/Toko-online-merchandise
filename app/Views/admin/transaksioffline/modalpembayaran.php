<div class="modal fade" id="modalpembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Pembayaran Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(site_url('/admin/transaksioffline/simpanPembayaran'), ['class' => 'frmpembayaran']); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="">ID Transaksi</label>
          <input type="text" name="transofflineid" id="transid" value="<?= $transofflineid; ?>" class="form-control" readonly>
          <input type="hidden" name="tgltransaksi" value="<?= $tgltransaksi; ?>">
          <input type="hidden" name="namapembeli" value="<?= $namapembeli; ?>">
        </div>
        <div class="form-group">
          <label for="">Total Harga</label>
          <input type="text" name="totalbayar" id="totalbayar" value="<?= $totalbayar; ?>" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="">Dibayar</label>
          <input type="text" name="dibayar" id="dibayar" class="form-control" autocomplete="false">
          <div class="invalid-feedback errordibayar">

          </div>
        </div>
        <div class="form-group">
          <label for="">Kembalian</label>
          <input type="text" name="kembalian" id="kembalian" class="form-control" readonly>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success btnsimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<script src="<?= base_url('dist/js/autoNumeric.js'); ?>"></script>
<script>
  $(document).ready(function() {
    $('#totalbayar').autoNumeric('init', {
      mDec: 0,
      aSep: '.',
      aDec: ','
    });
    $('#dibayar').autoNumeric('init', {
      mDec: 0,
      aSep: '.',
      aDec: ','
    });
    $('#kembalian').autoNumeric('init', {
      mDec: 0,
      aSep: '.',
      aDec: ','
    });

    // input jumlah uang
    $('#dibayar').keyup(function(e) {
      let totalbayar = $('#totalbayar').autoNumeric('get');
      let dibayar = $('#dibayar').autoNumeric('get');
      let kembalian;

      if (parseInt(dibayar) < parseInt(totalbayar)) {
        kembalian = 0;
      } else {
        kembalian = parseInt(dibayar) - parseInt(totalbayar);
      }
      $('#kembalian').autoNumeric('set', kembalian);
    });

    $('.frmpembayaran').submit(function(e) {
      e.preventDefault();
      let totalbayar = $('#totalbayar').val();
      let dibayar = $('#dibayar').val();
      if (totalbayar > dibayar) {
        Swal.fire('Kesalahan', 'Input pembayaran kurang', 'error');
      } else {
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
              let data = response.error;
              if (data.dibayar) {
                $('#dibayar').addClass('is-invalid');
                $('.errordibayar').html(data.dibayar);
              }
            }

            if (response.sukses) {
              Swal.fire({
                title: 'Cetak transaksi',
                text: response.sukses,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Cetak !',
                cancelButtonText: 'Batal'
              }).then((result) => {
                if (result.isConfirmed) {
                  let windowCetak = window.open(response.cetaktransaksi, "Cetak transaksi", "width=300,height=500");
                  windowCetak.focus();
                  window.location.reload();
                } else {
                  window.location.reload();
                }
              });
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
          }
        });
      }
      return false;
    });
  });
</script>