<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="modal fade" id="modalcariproduk" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cari Produk</h5>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered" id="dataproduk" style="width: 100%;">
          <thead class="text-center">
            <tr>
              <th style="width: 5%;">No</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function pilih(produkid, namaproduk) {
    $.ajax({
      type: "post",
      url: "/admin/produk/cariproduk",
      data: {
        produkid: produkid,
        namaproduk: namaproduk
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.data) {
          $('#ukuran').removeAttr('disabled');
          $('#ukuran').html(response.data);
          // $("#ukuran").prop('autofocus', true);

          $('#hargajual').val("");
          // $("#hargajual").removeAttr('autofocus');

          $('#namaproduk').val(namaproduk);
          $('#produkid').val(produkid);

          $('#jml').focus();
          $('#modalcariproduk').modal('hide');
        }

        if (response.hargajual) {
          $('#ukuran').prop('disabled', true);
          $('#ukuran').html("");
          // $("#ukuran").removeAttr('autofocus');

          $('#namaproduk').val(namaproduk);
          $('#produkid').val(produkid);

          $('#hargajual').val(response.hargajual);
          $('#jml').focus();
          // $("#hargajual").prop('autofocus', true);

          $('#modalcariproduk').modal('hide');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
    // $('#namaproduk').val(namaproduk);
    // $('#produkid').val(produkid);
    // $('#modalcariproduk').modal('hide');
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
        },
        {
          data: "namaproduk"
        },
        {
          data: "status"
        },
        {
          data: "aksi2"
        },
      ]
    });
  });
</script>