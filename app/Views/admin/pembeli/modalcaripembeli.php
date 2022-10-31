<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="modal fade" id="modalcaripembeli" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cari Pembeli</h5>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered" id="datapembeli" style="width: 100%;">
          <thead class="text-center">
            <tr>
              <th style="width: 5%;">No</th>
              <th>Nama</th>
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
  function pilih(namapembeli) {
    $('#pembeli').val(namapembeli);
    $('#modalcaripembeli').modal('hide');
  }

  $(document).ready(function() {
    $("#datapembeli").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      processing: true,
      serverSide: true,
      ajax: '/admin/pembeli/listData',
      order: [],
      columns: [{
          data: "nomor",
        },
        {
          data: "namapembeli"
        },
        {
          data: "aksi2"
        },
      ]
    });
  });
</script>