<?= $this->extend('main/main'); ?>

<?= $this->section('isi'); ?>

<?php

// $a = "";
// $b = "0";
// $c = "";

// if ($a == "" || $b == "" || $c == "") {
//   echo 'mantap';
// } else {
//   echo 'pantek';
// }

?>

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
    <div class="row">
      <div class="col-lg-4">
        <div class="form-group">
          <label for="">ID Transaksi</label>
          <input type="number" name="transofflineid" id="transofflineid" class="form-control" value="" readonly>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label for="">Tanggal Transaksi</label>
          <input type="date" name="tgltransaksi" id="tgltransaksi" class="form-control" value="<?= date('Y-m-d'); ?>">
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label for="">Cari Pembeli</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nama Pembeli" name="pembeli" id="pembeli" readonly>
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="button" id="tombolcaripembeli" name="tombolcaripembeli" title="Cari Pembeli"> <i class="fa fa-search"></i> </button>
              <button class="btn btn-outline-success" type="button" id="tomboltambahpembeli" name="tomboltambahpembeli" title="Tambah Pembeli"> <i class="fa fa-plus-square"></i> </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- cari barang -->
    <div class="row">
      <div class="col-lg-3">
        <div class="form-group">
          <label for="">Nama Produk</label>
          <div class="input-group mb-3">
            <input type="hidden" name="produkid" id="produkid">
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
            </button> &nbsp;
            <button type="button" class="btn btn-info" title="Selesai Transaksi" id="tombolSelesaiTransaksi">
              Selesai Transaksi
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 tampilDataTemp">

      </div>
    </div>
  </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
  function kosong() {
    $("#produkid").val("");
    $("#namaproduk").val("");
    $("#ukuran").html("");
    $("#hargajual").val("");
    $("#jml").val("");

    $('#namaproduk').prop('readonly', true);
    $('#ukuran').prop('disabled', true);
    $('#hargajual').prop('readonly', true);
  }

  function transofflineid() {
    $.ajax({
      type: "post",
      url: "/admin/transaksioffline/transofflineid",
      data: {
        tgltransaksi: $('#tgltransaksi').val()
      },
      dataType: "json",
      success: function(response) {
        if (response.transofflineid) {
          $('#transofflineid').val(response.transofflineid);
          // tampil data temp
          tampilDataTemp();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function tampilDataTemp() {
    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/transaksioffline/tampilDataTemp'); ?>",
      data: {
        transofflineid: $('#transofflineid').val()
      },
      dataType: "json",
      beforeSend: function() {
        $('.tampilDataTemp').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      success: function(response) {
        // console.log(response.data);
        if (response.data) {
          $('.tampilDataTemp').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function simpanitem() {
    let produkid = $('#produkid').val();
    let namaproduk = $('#namaproduk').val();
    let hargajual = $('#hargajual').val();
    let jml = $('#jml').val();
    let ukuran = $('#ukuran').val();
    if (produkid.length == 0 || namaproduk.length == 0 || hargajual.length == 0 || jml.length == 0) {
      Swal.fire('Kesalahan', 'Nama produk, harga jual, qty tidak boleh kosong', 'error');
      kosong();
    } else {
      $.ajax({
        type: "post",
        url: "<?= site_url('/admin/transaksioffline/simpandatatemp'); ?>",
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
            tampilDataTemp();
            kosong();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    }
  }

  $('#ukuran').change(function(e) {
    e.preventDefault();
    // option yg dipilih
    // mengambil nilai dari atribut ukuranprodukid
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

  $('#tgltransaksi').change(function(e) {
    e.preventDefault();
    transofflineid();
  });

  $('#tombolcaripembeli').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "/admin/pembeli/modalcaripembeli",
      dataType: "json",
      success: function(response) {
        // console.log(response.data);
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modalcaripembeli').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  });

  $('#tomboltambahpembeli').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "/admin/pembeli/tambahpembeli",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modaltambahpembeli').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
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

  $('#tombolSimpanItem').click(function(e) {
    e.preventDefault();
    simpanitem();
  });

  $('#tombolSelesaiTransaksi').click(function(e) {
    e.preventDefault();
    let namapembeli = $('#pembeli').val();
    if (namapembeli) {
      $.ajax({
        type: "post",
        url: "<?= site_url('/admin/transaksioffline/modalpembayaran'); ?>",
        data: {
          transofflineid: $('#transofflineid').val(),
          tgltransaksi: $('#tgltransaksi').val(),
          namapembeli: namapembeli,
          totalbayar: $('#totalHarga').val(),
        },
        dataType: "json",
        success: function(response) {
          if (response.pesanerror) {
            Swal.fire('Error', response.pesanerror, 'error');
          }
          if (response.data) {
            $('.viewmodal').html(response.data).show();
            $('#modalpembayaran').modal('show');
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });
    } else {
      Swal.fire('Kesalahan', "Nama pembeli tidak boleh kosong", 'error');
    }
  });

  $(document).ready(function() {
    transofflineid();

  });
</script>

<?= $this->endSection('isi'); ?>