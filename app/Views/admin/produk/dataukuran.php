<table class="table table-sm table-hover table-bordered" style="width: 100%;">
  <thead>
    <tr>
      <th class="text-center">No</th>
      <th class="text-center">Ukuran Produk</th>
      <th class="text-center">Harga Produk (Rp)</th>
      <th class="text-center">Status</th>
      <th class="text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($dataukuran as $g) : ?>
      <tr>
        <td class="text-center"><?= $no; ?></td>
        <td class="text-center"><?= $g['ukuran']; ?></td>
        <td class="text-right"><?= number_format($g['hargaproduk'], 0, ",", "."); ?></td>
        <td class="text-center">
          <?= $g['status'] == 1 ? '<nav class="badge badge-success">Tersedia</nav>' : '<nav class="badge badge-danger">Habis</nav>'; ?>
        </td>
        <td class="text-center">
          <button class="btn btn-sm btn-info btnedit" onclick="editukuran('<?= $g['ukuranprodukid']; ?>')"><i class="fa fa-edit"></i> </button>
          <button class="btn btn-sm btn-danger btnhapusukuran" onclick="hapusukuran('<?= $g['ukuranprodukid']; ?>')"><i class="fa fa-trash-alt"></i> </button>
        </td>
      </tr>
    <?php
      $no++;
    endforeach; ?>
  </tbody>
</table>

<script>
  function editukuran(ukuranprodukid) {
    $.ajax({
      type: "post",
      url: "/admin/produk/editukuran",
      data: {
        ukuranprodukid: ukuranprodukid,
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          // console.log(response.data);
          $('#ukuran').val(response.data.ukuran);
          $('#ukuran').attr('disabled', true);
          $('#status').val(response.data.status);
          $('#hargaproduk').val(response.data.hargaproduk);
          $('.ukuranprodukid').val(ukuranprodukid);

          // mengubah link simpan menjadi ubah
          $('.formsimpan').attr('action', '<?= base_url() . '/admin/produk/ubahukuran'; ?>');
          $('.btnsimpan').html("Simpan Perubahan");
        }
      }
    });
  }

  function hapusukuran(ukuranprodukid) {
    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus ukuran ini ?`,
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
          url: "/admin/produk/hapusukuran",
          data: {
            ukuranprodukid: ukuranprodukid
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
            }
            $('#ukuran').val("");
            $('#ukuran').removeAttr('disabled');
            $('#status').val("");
            $('#hargaproduk').val("");
            $('.ukuranprodukid').val("");
            dataukuran();

            if (response.pesanerror) {
              Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: response.pesanerror,
              });
              $('#ukuran').val("");
              $('#ukuran').remove('disabled');
              $('#status').val("");
              $('#hargaproduk').val("");
              $('.ukuranprodukid').val("");
              dataukuran();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }
</script>