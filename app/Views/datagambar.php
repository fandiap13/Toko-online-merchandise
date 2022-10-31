<?php
$db = \Config\Database::connect();
$dataGambar = $db->table('tbl_gambar_review')->getWhere(['reviewid' => $reviewid])->getResultArray();

if ($dataGambar) {
  foreach ($dataGambar as $key => $value) :
?>
    <div class="col-3 text-center">
      <img src="<?= base_url('/gambar/review/' . $value['gambar']); ?>" style="width: 100px;">
      <br>
      <button type="button" class="btn btn-sm btn-danger mt-2" onclick="hapusGambar('<?= $value['id']; ?>')"><i class="fa fa-trash-alt"></i> Hapus</button>
    </div>
<?php
  endforeach;
} ?>

<script>
  function hapusGambar(id) {
    Swal.fire({
      title: 'Hapus',
      text: `Apakah anda yakin ingin menghapus gambar ?`,
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
          url: "<?= site_url('/review/hapusGambar'); ?>",
          data: {
            id: id
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire('Berhasil', response.sukses, 'success');
              dataGambar();
            }

            if (response.error) {
              Swal.fire('Kesalahan', response.error, 'error');
              dataGambar();
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