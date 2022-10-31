<table class="table table-sm table-hover table-bordered" style="width: 100%;" id="datadetail">
  <thead>
    <tr>
      <th colspan="5"></th>
      <th colspan="2" class="text-right">
        <h1>
          <?php
          $total = 0;
          foreach ($dataDetail as $d) :
            $total += $d['subtotal'];
          endforeach; ?>
          <?= number_format($total, 0, ",", "."); ?>
        </h1>
        <input type="hidden" name="totalHarga" id="totalHarga" value="<?= $total; ?>">
      </th>
    </tr>
  </thead>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Ukuran</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>
      <th>Sub.Total</th>
      <th>#</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($dataDetail as $d) : ?>
      <tr>
        <td><?= $no; ?></td>
        <td>
          <?= $d['namaproduk']; ?>
          <input type="hidden" name="idproduk" value="<?= $d['produkid']; ?>">
          <input type="hidden" name="id" value="<?= $d['id']; ?>">
        </td>
        <td><?= $d['ukuran']; ?></td>
        <td><?= $d['hargajual']; ?></td>
        <td><?= $d['jml']; ?></td>
        <td><?= $d['subtotal']; ?></td>
        <td>
          <button class="btn btn-sm btn-danger btnhapus" onclick="hapusItem('<?= $d['id']; ?>')"><i class="fa fa-trash-alt"></i></button>
        </td>
      </tr>
    <?php
      $no++;
    endforeach; ?>
  </tbody>
</table>

<script>
  function hapusItem(id) {
    Swal.fire({
      title: 'Hapus',
      text: `Yakin menghapus Item ?`,
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
          url: "<?= site_url('/admin/transaksioffline/hapusdetailitem'); ?>",
          data: {
            id: id
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
              kosong();
              tampildatadetail();
              ambilTotalBayar();
              $('#tombolSimpanItem').fadeIn();
              $('#tombolEditItem').fadeOut();
              $('#tombolBatal').fadeOut();

              $('#tombolcariproduk').removeAttr('disabled');
            }

            if (response.pesanerror) {
              Swal.fire('Kesalahan', response.pesanerror, 'error');
              kosong();
              tampildatadetail();
              ambilTotalBayar();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
          }
        });
      } else {
        $('#tombolSimpanItem').fadeIn();
        $('#tombolEditItem').fadeOut();
        $('#tombolBatal').fadeOut();

        $('#tombolcariproduk').removeAttr('disabled');
      }
    });
  }

  $('#datadetail tbody').on('click', 'tr', function() {
    let row = $(this).closest('tr');
    let produkid = row.find('td input[name=idproduk]').val();
    let id = row.find('td input[name=id]').val();

    // alert(namaproduk + "," + produkid + "," + id);
    $('#produkid').val(produkid);
    $('#id').val(id);

    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/transaksioffline/ambilDataBarang'); ?>",
      data: {
        id: $('#id').val()
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.data) {
          $('#namaproduk').val(response.data.namaproduk);
          $('#hargajual').val(response.data.hargajual);
          $('#jml').val(response.data.jml);
          $('#subtotal').val(response.data.subtotal);

          if (response.data.ukuran !== null) {
            $.ajax({
              type: "post",
              url: "<?= site_url('/admin/produk/cariproduk'); ?>",
              data: {
                produkid: $('#produkid').val(),
                id: $('#id').val()
              },
              dataType: "json",
              success: function(response) {
                if (response.data) {
                  console.log(response.data);
                  $('#ukuran').html(response.data);
                  $('#ukuran').removeAttr('disabled');
                }
              }
            });
          } else {
            $('#ukuran').html("");
            $('#ukuran').prop('disabled', true);
          }

          $('#tombolBatal').fadeIn();
          $('#tombolEditItem').fadeIn();

          $('#tombolcariproduk').prop('disabled', true);

          $('#tombolSimpanItem').fadeOut();
          ambilDataBarang();
        }

        if (response.pesanerror) {
          Swal.fire('Kesalahan', response.pesanerror, 'error');
          datadetail();
          ambilTotalBayar();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  });
</script>