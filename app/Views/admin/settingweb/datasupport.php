<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th style="width: 5%;">#</th>
      <th style="width: 15%;">Logo</th>
      <th>Supported</th>
      <th>Link Website</th>
      <th style="width: 10%;">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $nomor = 1;
    foreach ($datasupport as $key => $value) :
    ?>
      <tr>
        <td><?= $nomor; ?></td>
        <td>
          <img src="<?= base_url('gambar/setting/' . $value['gambar']); ?>" style="width: 100%;">
        </td>
        <td><?= $value['supported']; ?></td>
        <td><?= $value['linkwebsite']; ?></td>
        <td>
          <button class="btn btn-sm btn-info" onclick="editSupport('<?= $value['supportid']; ?>')"><i class="fa fa-edit"></i> </button>
          <button class="btn btn-sm btn-danger" onclick="hapusSupport('<?= $value['supportid']; ?>')"><i class="fa fa-trash-alt"></i> </button>
        </td>
      </tr>
    <?php
      $nomor++;
    endforeach; ?>
  </tbody>
</table>

<script>
  function hapusSupport(supportid) {
    clearInvalidFeedback();
    clearForm();

    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus data ini ?`,
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
          url: "<?= site_url('admin/setting/hapusSupport'); ?>",
          data: {
            supportid: supportid
          },
          dataType: "json",
          success: function(response) {
            if (response.error) {
              Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: response.error,
              });
              dataSupport();
            }

            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
              dataSupport();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }

  function editSupport(supportid) {
    clearInvalidFeedback();
    clearForm();

    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/setting/editSupport'); ?>",
      data: {
        supportid: supportid
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modaleditsupport').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {
    $('#example1').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
    });
  });
</script>