<?php foreach ($datagambar as $g) : ?>
  <div class="col-md-3">
    <div class="card">
      <input type="hidden" name="gambarprodukid" id="gambarprodukid" value="<?= $g['gambarprodukid']; ?>">
      <img src="<?= base_url(); ?>/gambar/produk/<?= $g['gambarproduk']; ?>" class="card-img-top" alt="Gambar Produk">
    </div>
    <div class="text-center">
      <button class="btn btn-sm btn-danger btnhapusgambar"><i class="fa fa-trash-alt"></i> Hapus</button>
    </div>
  </div>
<?php endforeach; ?>


<script>
  $('.btnhapusgambar').click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus gambar ini ?`,
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
          url: "/admin/produk/hapusgambar",
          data: {
            gambarprodukid: $('#gambarprodukid').val()
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
              datagambar();
            }

            if (response.pesanerror) {
              Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: response.pesanerror,
              });
              datagambar();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  });
</script>