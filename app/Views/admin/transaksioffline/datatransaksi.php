<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<table class="table table-striped table-bordered example1" id="datatransaksi" style="width: 100%;">
  <thead class="text-center">
    <tr>
      <th style="width: 5%;">No</th>
      <th>ID Transaksi</th>
      <th>Nama Pembeli</th>
      <th>Tanggal Transaksi</th>
      <th>Total Harga (Rp)</th>
      <th>Kasir</th>
      <th style="width: 15%;">Aksi</th>
    </tr>
  </thead>
  <tbody class="text-center">

  </tbody>
</table>

<script>
  function cetak(id) {
    let windowCetak = window.open('/admin/transaksioffline/cetaktransaksi/' + id, "Cetak Transaksi", "width=300,height=500");
    windowCetak.focus();
    window.location.reload();
  }

  function edit(id) {
    window.location = "<?= site_url('/admin/transaksioffline/edit/'); ?>" + id;
  }

  function hapus(id) {
    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus transaksi dengan ID ${id} ?`,
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
          url: "<?= site_url('/admin/transaksioffline/hapusTransaksi'); ?>",
          data: {
            transofflineid: id
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire("Berhasil", response.sukses, "success");
              datatransoffline();
            }

            if (repsonse.pesanerror) {
              Swal.fire("Kesalahan", response.pesanerror, "error");
              datatransoffline();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
          }
        });
      }
    });
  }

  $(document).ready(function() {
    datatransaksi = $("#datatransaksi").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      processing: true,
      serverSide: true,
      ajax: {
        url: '/admin/transaksioffline/listData',
        data: function(e) {
          e.tglawal = $('#tglawal').val();
          e.tglakhir = $('#tglakhir').val();
        }
      },
      order: [],
      columns: [{
          data: "nomor",
          orderable: false
        },
        {
          data: "transofflineid",
        },
        {
          data: "namapembeli",
        },
        {
          data: "tgl",
        },
        {
          data: "total",
        },
        {
          data: "kasir",
        },
        {
          data: "aksi",
          orderable: false
        },
      ]
    });

    $('#tombolcari').click(function(e) {
      e.preventDefault();
      datatransaksi.ajax.reload();
    });
  });
</script>