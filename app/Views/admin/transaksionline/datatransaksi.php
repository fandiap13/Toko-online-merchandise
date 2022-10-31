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
      <th>Tanggal Transaksi</th>
      <th>Status Pembayaran</th>
      <th>Status Pembelian</th>
      <th>Total Bayar</th>
      <th style="width: 20%;">Aksi</th>
    </tr>
  </thead>
  <tbody class="text-center">

  </tbody>
</table>

<script>
  function cetak(id) {
    let windowCetak = window.open('/admin/transaksionline/cetaktransaksi/' + id, "Cetak Transaksi", "width=300,height=500");
    windowCetak.focus();
    window.location.reload();
  }

  function detailtransaksi(id) {
    window.location = "<?= site_url('/admin/transaksionline/detail-transaksi/'); ?>" + id;
  }


  function pembayaran(id) {
    $.ajax({
      type: 'post',
      url: "<?= site_url('/admin/transaksionline/datapembayaran'); ?>",
      data: {
        transonlineid: id
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modalpembayaran').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
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
        url: '/admin/transaksionline/listData',
        data: function(e) {
          e.tglawal = $('#tglawal').val();
          e.tglakhir = $('#tglakhir').val();
          e.statuspembelian = $('#statuspembelian').val();
        }
      },
      order: [],
      columns: [{
          data: "nomor",
          orderable: false
        },
        {
          data: "transonlineid",
        },
        {
          data: "tgl",
        },
        {
          data: "statusbayar",
          orderable: false
        },
        {
          data: "statusbeli",
          orderable: false
        },
        {
          data: "total",
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