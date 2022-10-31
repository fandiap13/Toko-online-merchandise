<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<style>
  table#datadetail tbody tr:hover {
    cursor: pointer;
    background-color: red;
    color: white;
  }
</style>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <?= form_button('', '<i class="fas fa-arrow-left"></i> Kembali', [
        'class' => 'btn btn-warning',
        'onclick' => "location.href=('" . site_url('/admin/transaksioffline/index') . "')"
      ]); ?>
    </h3>
  </div>
  <div class="card-body">
    <table class="table table-sm table-striped table-hover" style="width:100%;">
      <tr>
        <input type="hidden" id="transofflineid" value="<?= $transofflineid; ?>">
        <td style="width: 20%;">ID Transaksi</td>
        <td style="width: 2%;">:</td>
        <td style="width: 28%"><?= $transofflineid; ?></td>
        <td rowspan="3" style="width: 50%; font-weight: bold; color:red; font-size: 20pt; text-align: center; vertical-align: middle;" id="TotalBayar">

        </td>
      </tr>
      <tr>
        <td>Tanggal Transaksi</td>
        <td>:</td>
        <td><?= date('d-m-Y', strtotime($tgltransaksi)); ?></td>
      </tr>
      <tr>
        <td>Nama Pembeli</td>
        <td>:</td>
        <td><?= $namapembeli; ?></td>
      </tr>
    </table>

    <div class="row mt-4">
      <div class="col-lg-3">
        <div class="form-group">
          <label for="">Nama Produk</label>
          <div class="input-group mb-3">
            <input type="hidden" name="produkid" id="produkid">
            <input type="hidden" name="id" id="id">
            <input type="text" class="form-control" name="namaproduk" id="namaproduk" readonly>
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="button" id="tombolcariproduk" name="tombolcariproduk" title="Cari Barang"> <i class="fa fa-search"></i> </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="form-group">
          <label for="">Ukuran Produk</label>
          <select name="ukuran" id="ukuran" class="form-control" disabled>

          </select>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="form-group">
          <label for="">Harga Jual</label>
          <input type="number" name="hargajual" id="hargajual" class="form-control" readonly>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="form-group">
          <label for="">Qty</label>
          <input type="number" name="jml" id="jml" value="1" class="form-control">
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group">
          <label for="">#</label>
          <div class="input-group mb-3">
            <button type="button" class="btn btn-success" title="Simpan Item" id="tombolSimpanItem">
              <i class="fa fa-save"></i>
            </button>
            &nbsp;
            <button type="button" style="display: none;" class="btn btn-primary" title="Edit Item" id="tombolEditItem">
              <i class="fa fa-edit"></i>
            </button>
            &nbsp;
            <button type="button" style="display: none;" class="btn btn-default" title="Batalkan" id="tombolBatal">
              <i class="fa fa-sync-alt"></i>
            </button>
            &nbsp;
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 tampilDataDetail">

      </div>
    </div>

    <div class="viewmodal" style="display: none;"></div>
  </div>
</div>


<script>
  function simpanitem() {
    let produkid = $('#produkid').val();
    let namaproduk = $('#namaproduk').val();
    let hargajual = $('#hargajual').val();
    let jml = $('#jml').val();
    let ukuran = $('#ukuran').val();
    if (produkid.length == 0 || namaproduk.length == 0 || hargajual.length == 0 || jml == "0") {
      Swal.fire('Kesalahan', 'Nama produk, harga jual, qty tidak boleh kosong atau bernilai 0', 'error');
      kosong();
    } else {
      $.ajax({
        type: "post",
        url: "<?= site_url('/admin/transaksioffline/simpandatadetail'); ?>",
        data: {
          produkid: produkid,
          namaproduk: namaproduk,
          hargajual: hargajual,
          jml: jml,
          ukuran: ukuran,
          transofflineid: $('#transofflineid').val()
        },
        dataType: "json",
        success: function(response) {
          if (response.sukses) {
            Swal.fire('Berhasil', response.sukses, 'success');
            tampildatadetail();
            ambilTotalBayar();
            kosong();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    }
  }

  function ambilTotalBayar() {
    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/transaksioffline/ambilTotalBayar'); ?>",
      data: {
        transofflineid: $('#transofflineid').val()
      },
      dataType: "json",
      success: function(response) {
        if (response.totalBayar) {
          $('#TotalBayar').html(response.totalBayar);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function tampildatadetail() {
    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/transaksioffline/tampilDataDetail'); ?>",
      data: {
        transofflineid: $('#transofflineid').val()
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.tampilDataDetail').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function kosong() {
    $('#namaproduk').val('');
    $('#id').val('');
    $('#produkid').val('');

    $('#ukuran').prop('disabled', true);
    $('#ukuran').html('');

    $('#hargajual').val('');
    $('#jml').val(1);

  }

  $('#tombolBatal').click(function(e) {
    e.preventDefault();
    kosong();

    $('#tombolSimpanItem').fadeIn();
    $('#tombolEditItem').fadeOut();
    $('#tombolBatal').fadeOut();

    $('#tombolcariproduk').removeAttr('disabled');
  });

  $('#tombolSimpanItem').click(function(e) {
    e.preventDefault();
    simpanitem();
  });

  $('#tombolcariproduk').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "/admin/produk/modalcariproduk",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modalcariproduk').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  });

  $('#ukuran').change(function(e) {
    e.preventDefault();
    var ukuranprodukid = $("option:selected", this).attr('ukuranprodukid');
    // console.log(ukuranprodukid);
    if (ukuranprodukid) {
      $.ajax({
        type: "post",
        url: "<?= site_url('/admin/produk/hargajual'); ?>",
        data: {
          ukuranprodukid: ukuranprodukid,
          produkid: $('#produkid').val()
        },
        dataType: "json",
        success: function(response) {
          if (response.hargajual) {
            $("#hargajual").val(response.hargajual);
            $('#jml').focus();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    } else {
      $("#jml").val(1);
      $("#hargajual").val("");
    }
  });

  $('#tombolEditItem').click(function(e) {
    e.preventDefault();
    let produkid = $('#produkid').val();
    let namaproduk = $('#namaproduk').val();
    let hargajual = $('#hargajual').val();
    let jml = $('#jml').val();
    let ukuran = $('#ukuran').val();
    let id = $('#id').val();
    let transofflineid = $('#transofflineid').val();
    if (produkid.length !== 0 && id.length !== 0 && namaproduk.length !== 0 && hargajual.length !== 0 && jml !== "0") {
      $.ajax({
        type: "post",
        url: "<?= site_url('/admin/transaksioffline/updatedatadetail'); ?>",
        data: {
          transofflineid: transofflineid,
          produkid: produkid,
          namaproduk: namaproduk,
          hargajual: hargajual,
          jml: jml,
          ukuran: ukuran,
          id: id
        },
        dataType: "json",
        success: function(response) {
          if (response.sukses) {
            Swal.fire('Berhasil', response.sukses, 'success');
            tampildatadetail();
            ambilTotalBayar();
            kosong();

            $('#tombolSimpanItem').fadeIn();
            $('#tombolEditItem').fadeOut();
            $('#tombolBatal').fadeOut();
            $('#tombolcariproduk').removeAttr('disabled');
          }
        }
      });
    } else {
      Swal.fire('Kesalahan', 'Nama produk, harga jual, dan qty tidak boleh kosong atau bernilai 0', 'error');
    }
  });

  $(document).ready(function() {
    tampildatadetail();
    ambilTotalBayar();
  });
</script>


<?= $this->endSection('isi'); ?>