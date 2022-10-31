<table class="table table-sm table-hover table-bordered" style="width: 100%;">
  <thead>
    <tr>
      <th colspan="5"></th>
      <th colspan="2" class="text-right">
        <h1>
          <?php
          $total = 0;
          foreach ($dataTemp as $d) :
            $total += $d['subtotal'];
          endforeach; ?>
          <?= number_format($total, 0, ",", "."); ?>
        </h1>
        <input type="hidden" name="totalHarga" id="totalHarga" value="<?= $total; ?>">
      </th>
    </tr>
  </thead>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Ukuran</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>
      <th>Sub.Total</th>
      <th>#</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($dataTemp as $d) : ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $d['namaproduk']; ?></td>
        <td><?= $d['ukuran']; ?></td>
        <td><?= $d['hargajual']; ?></td>
        <td><?= $d['jml']; ?></td>
        <td><?= $d['subtotal']; ?></td>
        <td>
          <button class="btn btn-sm btn-danger btnhapus" onclick="hapus('<?= $d['id']; ?>')"><i class="fa fa-trash-alt"></i></button>
        </td>
      </tr>
    <?php
      $no++;
    endforeach; ?>
  </tbody>
</table>

<script>
  function hapus(id) {
    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus Item ?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'tidak',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= site_url('/admin/transaksioffline/hapustempitem'); ?>",
          data: {
            id: id
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
              tampilDataTemp();
            }

            if (response.pesanerror) {
              Swal.fire('Kesalahan', response.pesanerror, 'error');
              tampilDataTemp();
            }
          }
        });
      }
    });
  }
</script>