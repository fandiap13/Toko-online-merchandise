<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Produk</th>
      <th>Status</th>
      <th>Ukuran</th>
      <th>QTY</th>
      <th>Harga</th>
      <th>Subtotal</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total = 0;
    $totalberat = 0;
    $no = 1;
    foreach ($datakeranjang as $keranjang) : ?>
      <tr>
        <td><?= $no; ?>.</td>
        <td><?= $keranjang['namaproduk']; ?></td>
        <td>
          <?php
          if ($keranjang['statusproduk'] == 0) {
            echo '<nav class="badge badge-danger">Habis</nav>';
          } else {
            $db = \Config\Database::connect();
            $ukuran = $db->table('tbl_ukuran_produk')
              ->where('ukuranprodukid', $keranjang['ukuranprodukid'])
              ->get()->getRowArray();
            if ($ukuran) {
              if ($ukuran['status'] == 0) {
                echo '<nav class="badge badge-danger">Habis</nav>';
              } else {
                echo '<nav class="badge badge-success">Tersedia</nav>';
              }
            } else {
              echo '<nav class="badge badge-success">Tersedia</nav>';
            }
          }
          ?>
        </td>
        <td>
          <?php if ($keranjang['ukuranprodukid'] !== null) {
            $db = \Config\Database::connect();
            $ukuran = $db->table('tbl_ukuran_produk')->where('ukuranprodukid', $keranjang['ukuranprodukid'])->get()->getRowArray();
            echo $ukuran['ukuran'];
          } else {
            echo "Tidak ada";
          } ?>
        </td>
        <td>
          <input type="number" name="jml" keranjangid="<?= $keranjang['id']; ?>" value="<?= $keranjang['jml']; ?>" class="text-center" style="width: 100px;" min="1">
        </td>
        <td class="text-right">
          <?php if ($keranjang['ukuranprodukid'] == null) {
            $hargaproduk = $keranjang['hargaproduk'];
          } else {
            $db = \Config\Database::connect();
            $ukuran = $db->table('tbl_ukuran_produk')->where('ukuranprodukid', $keranjang['ukuranprodukid'])
              ->where('produkid', $keranjang['produkid'])
              ->get()->getRowArray();
            $hargaproduk = $ukuran['hargaproduk'];
          } ?>
          <?= number_format($hargaproduk, 0, ",", "."); ?></td>
        <td class="text-right">
          <?= number_format(($hargaproduk * $keranjang['jml']), 0, ",", "."); ?>
        </td>
        <td>
          <button type="button" class="btn btn-sm btn-danger" onclick="hapuslist('<?= $keranjang['id']; ?>');"><i class="fa fa-trash-alt"></i></button>
        </td>
      </tr>
    <?php
      $total += ($hargaproduk * $keranjang['jml']);
      $totalberat += ($keranjang['beratproduk'] * $keranjang['jml']);
      $no++;
    endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <input type="hidden" name="totalbelanja" id="totalbelanja" value="<?= $total; ?>"> <!-- penting untuk penjumlahan checkout -->
      <th colspan="6" class="text-center">Total Belanja</th>
      <td class="text-right">Rp.<?= number_format($total, 0, ",", "."); ?></td>
      <td></td>
    </tr>
  </tfoot>
</table>

<script>
  function hapuslist(id) {
    Swal.fire({
      title: 'Hapus',
      text: `Apakah anda yakin ?`,
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
          url: "<?= site_url('/transaksi/hapuslist'); ?>",
          data: {
            id: id
          },
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              Swal.fire('Sukses', response.sukses, 'success').then(function() {
                window.location.reload();
              });
              // datakeranjang();
              // kosong();
              // totalcheckout();
            }

            if (response.pesanerror) {
              Swal.fire('Kesalahan', response.error, 'error').then(function() {
                window.location.reload();
              });
              // datakeranjang();
              // kosong();
              // totalcheckout();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
          }
        });
      }
    });
  }

  // ubah jml keranjang
  $('input[name=jml]').keyup(function(e) {
    let jml = $(this).val();
    let id = $(this).attr('keranjangid');

    if (jml != 0 && jml.length > 0) {
      $.ajax({
        type: "post",
        url: "<?= site_url('/transaksi/ubahjmlkeranjang'); ?>",
        data: {
          id: id,
          jml: jml
        },
        dataType: "json",
        success: function(response) {
          console.log(response);
          if (response.sukses) {
            datakeranjang();
            kosong();
            totalcheckout();
          }

          if (response.pesanerror) {
            Swal.fire('Kesalahan', response.error, 'error');
            datakeranjang();
            kosong();
            totalcheckout();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    }
  });

  // ubah jml keranjang
  $("input[name=jml]").bind('change keyup', function() {
    let jml = $(this).val();
    let id = $(this).attr('keranjangid');

    if (jml != 0 && jml.length > 0) {
      $.ajax({
        type: "post",
        url: "<?= site_url('/transaksi/ubahjmlkeranjang'); ?>",
        data: {
          id: id,
          jml: jml
        },
        dataType: "json",
        success: function(response) {
          console.log(response);
          if (response.sukses) {
            datakeranjang();
            kosong();
            totalcheckout();
          }

          if (response.pesanerror) {
            Swal.fire('Kesalahan', response.error, 'error');
            datakeranjang();
            kosong();
            totalcheckout();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    }
  });

  function totalberat() {
    $('#totalberat').val(<?= $totalberat; ?>);
  }

  $(document).ready(function() {
    totalberat();
    totalcheckout();
  });
</script>