<div class="modal fade" id="modalpembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Data Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(site_url('/admin/transaksionline/ubahstatuspembelian'), ['class' => 'formsimpan']); ?>
      <input type="hidden" name="transonlineid" value="<?= $transaksi['transonlineid']; ?>">
      <div class="modal-body">
        <ul>
          <li><b>ID Transaksi:</b> <?= $transaksi['transonlineid']; ?></li>
          <li><b>Order ID:</b> <?= $transaksi['order_id']; ?></li>
          <li><b>Nama Pembeli:</b> <?= $transaksi['namapembeli']; ?></li>
          <li><b>Tanggal Transaksi:</b> <?= date('d-m-Y H:i:s', strtotime($transaksi['tgltransaksi'])); ?></li>
          <?php if ($transaksi['statuspembayaran'] == 'pending') { ?>
            <li><b>Status Pembayaran:</b>
              <nav class="badge badge-secondary">Pending</nav>
            </li>
          <?php } elseif ($transaksi['statuspembayaran'] == 'settlement') { ?>
            <li><b>Status Pembayaran:</b>
              <nav class="badge badge-success">Sukses</nav>
            </li>
          <?php } else { ?>
            <li><b>Status Pembayaran:</b>
              <nav class="badge badge-danger">Expire</nav>
            </li>
          <?php } ?>
          <li><b>Tipe Pembayaran:</b> <?= $transaksi['payment_type']; ?></li>
          <?php if ($transaksi['payment_type'] == 'cstore') { ?>
            <li><b>Metode Pembayaran:</b> <?= $statuspayment->store; ?></li>
            <li><b>Total Pembayaran:</b> Rp <?= number_format($statuspayment->gross_amount, 0, ",", "."); ?></li>
          <?php } elseif ($transaksi['payment_type'] == 'bank_transfer') { ?>
            <li><b>Nama Bank:</b> <?= $statuspayment->va_numbers[0]->bank; ?></li>
            <li><b>Total Pembayaran:</b> Rp <?= number_format($statuspayment->gross_amount, 0, ",", "."); ?></li>
          <?php } ?>
        </ul>

        <div class="form-group mt-2">
          <label for="">No. Resi Pengiriman</label>
          <input type="text" name="noresi" id="noresi" class="form-control" placeholder="Masukkan no resi pengiriman" value="<?= $transaksi['noresi']; ?>">
        </div>
        <div class="form-group">
          <label for="">Status Pembelian</label>
          <select name="statuspembelian" id="status" class="form-control">
            <option value="">-- Pilih status pembelian --</option>
            <option value="pending" <?= $transaksi['statuspembelian'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="diproses" <?= $transaksi['statuspembelian'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
            <option value="dikirim" <?= $transaksi['statuspembelian'] == 'dikirim' ? 'selected' : ''; ?>>Dikirim</option>
            <option value="diterima" <?= $transaksi['statuspembelian'] == 'diterima' ? 'selected' : ''; ?>>Diterima</option>
            <option value="gagal" <?= $transaksi['statuspembelian'] == 'gagal' ? 'selected' : ''; ?>>Gagal</option>
          </select>
          <div class="invalid-feedback errorstatus">

          </div>
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
        // console.log(response);
        if (response.sukses) {
          Swal.fire('Sukses', response.sukses, 'success');
          $('#modalpembayaran').modal('hide');
          datatransaksionline();
        }

        if (response.error) {
          if (response.error.statuspembelian) {
            $('#status').addClass('is-invalid');
            $('.errorstatus').html(response.error.statuspembelian);
          } else {
            $('#status').removeClass('is-invalid');
            $('.errorstatus').html('');
          }
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  });
</script>