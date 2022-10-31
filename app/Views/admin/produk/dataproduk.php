<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<table class="table table-striped table-bordered" id="dataproduk" style="width: 100%;">
  <thead class="text-center">
    <tr>
      <th style="width: 5%;">No</th>
      <th>Nama Produk</th>
      <th>Kategori</th>
      <th>Harga (Rp)</th>
      <th>Satuan</th>
      <th>Berat (Gram)</th>
      <th>Status</th>
      <th style="width: 20%;">Aksi</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<script>
  function edit(id) {
    window.location = ("/admin/produk/edit/" + id);
  }

  function upload(id) {
    $.ajax({
      type: "post",
      url: '/admin/produk/uploadgambar',
      data: {
        produkid: id
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modalupload').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function ukuran(id) {
    $.ajax({
      type: "post",
      url: '/admin/produk/ukuran',
      data: {
        produkid: id
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modalukuran').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function hapus(produkid, nama) {
    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus produk ${nama} ?`,
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
          url: "<?= site_url('admin/produk/hapus'); ?>",
          data: {
            produkid: produkid
          },
          dataType: "json",
          success: function(response) {
            if (response.error) {
              Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: response.error,
              });
              dataproduk();
            }

            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
              dataproduk();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        })
      }
    })
  }

  $(document).ready(function() {
    $("#dataproduk").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      processing: true,
      serverSide: true,
      ajax: '/admin/produk/listData',
      order: [],
      columns: [{
          data: "nomor",
          orderable: false,
        },
        {
          data: "namaproduk",
        },
        {
          data: "namakategori",
        },
        {
          data: "hargaproduk",
        },
        {
          data: "namasatuan",
        },
        {
          data: "beratproduk",
        },
        {
          data: "status",
          orderable: false,
        },
        {
          data: "aksi",
          orderable: false
        },
      ]
    });
  });
</script>