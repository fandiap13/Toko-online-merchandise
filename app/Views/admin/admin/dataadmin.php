<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<table class="table table-striped table-bordered" id="dataadmin" style="width: 100%;">
  <thead class="text-center">
    <tr>
      <th style="width: 5%;">No</th>
      <th>E - mail</th>
      <th>Nama</th>
      <th style="width: 15%;">Aksi</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<script>
  function edit(adminid) {
    $.ajax({
      type: "post",
      url: "/admin/admin/edit",
      data: {
        adminid: adminid
      },
      dataType: "json",
      success: function(response) {
        // console.log(response.data);
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modaledit').modal('show');
        }

        if (response.error) {
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: response.error,
          });
          dataadmin();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function hapus(adminid, nama) {
    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus data admin ini dengan nama ${nama} ?`,
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
          url: "<?= site_url('admin/admin/hapus'); ?>",
          data: {
            adminid: adminid
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
              dataadmin();
            }
            if (response.error) {
              Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: response.error,
              });
              dataadmin();
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
    $("#dataadmin").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      processing: true,
      serverSide: true,
      ajax: '/admin/admin/listData',
      order: [],
      columns: [{
          data: "nomor",
        },
        {
          data: "emailadmin",
        },
        {
          data: "namaadmin"
        },
        {
          data: "aksi",
          orderable: false
        },
      ]
    });
  });
</script>