<?= $this->extend('main/pembeli'); ?>

<?= $this->section('carousel'); ?>
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <h1><?= $title; ?></h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->
<?= $this->endSection('carousel'); ?>

<?= $this->section('isi'); ?>

<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <h5 class="card-header">
            Pilih Pengiriman
          </h5>
          <div class="card-body">
            <div class="fofrm-group">
              <label for="">No. Telp</label>
              <input type="text" name="notelp" id="notelp" class="form-control" value="<?= $pembeli['telppembeli']; ?>" autofocus>
            </div>
            <div class="form-group">
              <label for="">Alamat Pengiriman</label>
              <textarea name="alamatpengiriman" id="alamatpengiriman" class="form-control" required><?= $pembeli['alamatpembeli']; ?></textarea>
            </div>
            <div class="form-group">
              <label for="">Provinsi</label>
              <select name="provinsi" id="provinsi" class="form-control" disabled></select>
            </div>
            <div class="form-group">
              <label for="">Distrik</label>
              <select name="distrik" id="distrik" class="form-control" disabled></select>
            </div>
            <div class="form-group">
              <label for="">Ekspedisi</label>
              <select name="ekspedisi" id="ekspedisi" class="form-control" disabled></select>
            </div>
            <div class="form-group">
              <label for="">Paket</label>
              <select name="paket" id="paket" class="form-control" disabled></select>
            </div>
            <div class="form-group">
              <?= form_open('', ['class' => 'formcheckout']); ?>
              <input type="hidden" name="totalbayar" id="totalbayar">
              <input type="hidden" name="pembeliid" id="pembeliid" value="<?= session()->get('LoggedUserData')['userid']; ?>">
              <button type="submit" name="checkout" class="btn btn-block btn-success"><i class="fa fa-check-circle"></i> Checkout (<b id="totalcheckout"></b>)</button>
              <?= form_close(); ?>
            </div>
          </div>
        </div>

        <br>

      </div>
      <div class="col-md-8">
        <div class="card">
          <h5 class="card-header">Data Keranjang</h5>
          <div class="card-body">
            <div class="col-12 table-responsive datakeranjang">

            </div>
          </div>
        </div>

        <br>

        <div class="card">
          <h5 class="card-header">Detail Pengiriman</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Total Berat(Gram)</label>
                  <input type="text" name="totalberat" id="totalberat" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Provinsi</label>
                  <input type="text" name="provinsiterpilih" id="provinsiterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Distrik</label>
                  <input type="text" name="distrikterpilih" id="distrikterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Tipe(Kota/Kabupaten)</label>
                  <input type="text" name="tipeterpilih" id="tipeterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Kode POS</label>
                  <input type="text" name="kodeposterpilih" id="kodeposterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Ekspedisi</label>
                  <input type="text" name="ekspedisiterpilih" id="ekspedisiterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Paket</label>
                  <input type="text" name="paketterpilih" id="paketterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Ongkir (Rp)</label>
                  <input type="text" name="ongkir" id="ongkir" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Estimasi (Hari)</label>
                  <input type="text" name="estimasi" id="estimasi" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= getenv('API_KEY_MIDTRANS'); ?>"></script>
<script>
  function disable_f5(e) {
    if ((e.which || e.keyCode) == 116) {
      e.preventDefault();
    }
  }

  function kosong() {
    // $('#distrik').html('');
    $('#paket').html(''); // mengosongi select paket

    // // mengosongkan data ekspedisi dan provinsi
    let selectEkspedisi = document.querySelector('#ekspedisi'); //hopefully you'll use a better selector query
    selectEkspedisi.selectedIndex = 0; // or -1, 0 sets it to first option, -1 selects no options

    // let select2 = document.querySelector('#provinsi'); //hopefully you'll use a better selector query
    // select2.selectedIndex = 0; // or -1, 0 sets it to first option, -1 selects no options

    $('#paket').attr('disabled', true);

    $('#provinsiterpilih').val('');
    $('#distrikterpilih').val('');
    $('#tipeterpilih').val('');
    $('#kodeposterpilih').val('');
    $('#ekspedisiterpilih').val('');
    $('#paketterpilih').val('');
    $('#ongkir').val('');
    $('#estimasi').val('');
  }

  function datakeranjang() {
    $.ajax({
      url: "<?= site_url('/transaksi/datakeranjang'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.datakeranjang').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function totalcheckout() {
    let totalbelanja = $('#totalbelanja').val();
    let ongkir = $('#ongkir').val();

    if (ongkir.length > 0 && totalbelanja.length > 0) {
      let totalbayar = (parseInt(totalbelanja) + parseInt(ongkir));
      let totalcheckout = (parseInt(totalbelanja) + parseInt(ongkir));
      totalcheckout = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      }).format(totalcheckout)
      $('#totalcheckout').html(totalcheckout);
      $('#totalbayar').val(totalbayar);
    } else {
      $('#totalcheckout').html("Rp 0");
      $('#totalbayar').val(0);
    }
  }

  function dataprovinsi() {
    $.ajax({
      url: "<?= site_url('/rajaongkir/dataprovinsi'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('#provinsi').html(response.data);
          $('#provinsi').removeAttr('disabled');

          <?php if ($pembeli['distrikpembeli'] !== null) : ?>
            datadistrik();
          <?php endif; ?>

          dataekspedisi();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function datadistrik() {
    $.ajax({
      url: "<?= site_url('/rajaongkir/datadistrik'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('#distrik').html(response.data);
          $('#distrik').removeAttr('disabled');
          $('#ekspedisi').removeAttr('disabled');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function dataekspedisi() {
    $.ajax({
      url: "<?= site_url('/rajaongkir/dataekspedisi'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('#ekspedisi').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  $(document).ready(function() {
    // $(document).bind("keydown", disable_f5);
    datakeranjang();

    dataprovinsi();

    totalcheckout();

    // pilih provinsi
    $('#provinsi').change(function(e) {
      e.preventDefault();

      let id_provinsi_terpilih = $('option:selected', this).attr('id_provinsi');
      if (id_provinsi_terpilih.length > 0) {
        $.ajax({
          type: "post",
          url: "<?= site_url('/rajaongkir/datadistrik'); ?>",
          data: {
            id_provinsi: id_provinsi_terpilih
          },
          dataType: "json",
          success: function(response) {
            if (response.data) {
              $('#distrik').html(response.data);
              $('#distrik').removeAttr('disabled');
              $('#ekspedisi').removeAttr('disabled');
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
          }
        });
      }
    });

    // pilih ekspedisi
    $('#ekspedisi').change(function(e) {
      e.preventDefault();

      // disable pilih paket ketika diubah ekspedisinya
      $('#paket').html('');
      $('#paket').attr('disabled', true);

      let ekspedisi_terpilih = $('option:selected', this).val();
      let distrik_terpilih = $('option:selected', '#distrik').attr('id_distrik');
      let berat = $('#totalberat').val();
      if (ekspedisi_terpilih.length > 0 && distrik_terpilih.length > 0) {
        $.ajax({
          type: "post",
          url: "<?= site_url('/rajaongkir/datapaket'); ?>",
          data: {
            ekspedisi: ekspedisi_terpilih,
            distrik: distrik_terpilih,
            berat: berat
          },
          dataType: "json",
          success: function(response) {
            if (response.data) {
              $('#paket').html(response.data);
              $('#paket').removeAttr('disabled');

              let provinsi = $('option:selected', '#distrik').attr('nama_provinsi');
              let distrik = $('option:selected', '#distrik').attr('nama_distrik');
              let tipe_distrik = $('option:selected', '#distrik').attr('tipe_distrik');
              let kodepos = $('option:selected', '#distrik').attr('kodepos');
              let ekspedisi = $('option:selected', '#ekspedisi').val();

              $('#provinsiterpilih').val(provinsi);
              $('#distrikterpilih').val(distrik);
              $('#tipeterpilih').val(tipe_distrik);
              $('#kodeposterpilih').val(kodepos);
              $('#ekspedisiterpilih').val(ekspedisi);
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
          }
        });
      }
    });

    $('#paket').change(function(e) {
      e.preventDefault();
      let paket = $('option:selected', this).attr('paket');
      let ongkir = $('option:selected', this).attr('ongkir');
      let etd = $('option:selected', this).attr('etd');

      $('#paketterpilih').val(paket);
      $('#ongkir').val(ongkir);
      $('#estimasi').val(etd);

      totalcheckout();
    });

    $('.formcheckout').submit(function(e) {
      e.preventDefault();
      let pembeliid = $('#pembeliid').val();
      let notelp = $('#notelp').val();
      let alamatpengiriman = $('#alamatpengiriman').val();
      let provinsi = $('#provinsi').val();
      let distrik = $('#distrik').val();
      let ekspedisi = $('#ekspedisi').val();
      let paket = $('#paket').val();
      let totalberat = $('#totalberat').val();

      let provinsiterpilih = $('#provinsiterpilih').val();
      let distrikterpilih = $('#distrikterpilih').val();
      let tipeterpilih = $('#tipeterpilih').val();
      let kodeposterpilih = $('#kodeposterpilih').val();
      let ekspedisiterpilih = $('#ekspedisiterpilih').val();
      let paketterpilih = $('#paketterpilih').val();
      let ongkir = $('#ongkir').val();
      let estimasi = $('#estimasi').val();
      let totalpembelian = $('#totalbelanja').val();
      let totalbayar = $('#totalbayar').val();

      if (
        notelp.length == 0 ||
        alamatpengiriman.length == 0 ||
        provinsi.length == 0 ||
        distrik.length == 0 ||
        ekspedisi.length == 0 ||
        paket.length == 0 ||
        totalberat.length == 0 ||
        provinsiterpilih.length == 0 ||
        distrikterpilih.length == 0 ||
        tipeterpilih.length == 0 ||
        kodeposterpilih.length == 0 ||
        ekspedisiterpilih.length == 0 ||
        paketterpilih.length == 0 ||
        ongkir.length == 0 ||
        estimasi.length == 0 ||
        totalpembelian.length == 0 ||
        totalbayar.length == 0
      ) {
        Swal.fire('Kesalahan', "Semua input harus terisi!", 'error');
      } else {
        if (Number.isInteger(parseInt(notelp)) && parseInt(notelp.length) <= 13 && parseInt(notelp.length) >= 12) {
          $.ajax({
            type: "post",
            url: "<?= site_url('/transaksi/pembayaranMidtrans'); ?>",
            data: {
              pembeliid: pembeliid,
              distrik: distrikterpilih,
              kodepos: kodeposterpilih,
              alamat: alamatpengiriman,
              notelp: notelp,
              ongkir: ongkir,
            },
            dataType: "json",
            success: function(response) {
              // console.log(response);
              if (response.pesanerror) {
                Swal.fire('Kesalahan', response.pesanerror, 'error').then(function() {
                  window.location.reload();
                });
              }

              if (response.snapToken) {
                snap.pay(response.snapToken, {
                  // Optional
                  onSuccess: function(result) {
                    let dataResult = JSON.stringify(result, null, 2); // mengubah objek javascript menjadi string json
                    let dataObjek = JSON.parse(dataResult); // mengubah data json kedalam bentuk objekJavascript

                    // console.log(dataObjek);

                    $.ajax({
                      type: "post",
                      url: "<?= site_url('/transaksi/checkout'); ?>",
                      data: {
                        pembeliid: pembeliid,
                        alamat: alamatpengiriman,
                        notelp: notelp,
                        totalberat: totalberat,
                        provinsi: provinsiterpilih,
                        distrik: distrikterpilih,
                        tipe: tipeterpilih,
                        kodepos: kodeposterpilih,
                        ekspedisi: ekspedisiterpilih,
                        paket: paketterpilih,
                        ongkir: ongkir,
                        estimasi: estimasi,
                        totalpembelian: totalpembelian,
                        totalbayar: totalbayar,

                        pdf_url: dataObjek.pdf_url,
                        snapToken: response.snapToken,
                        order_id: dataObjek.order_id,
                        payment_type: dataObjek.payment_type,
                        waktupembayaran: dataObjek.transaction_time,
                        statuspembayaran: dataObjek.transaction_status,
                      },
                      dataType: "json",
                      success: function(response) {
                        console.log(response);
                        if (response.sukses) {
                          Swal.fire("Sukses", response.sukses, 'success').then(function() {
                            window.location = "<?= site_url('/'); ?>"
                          });
                        }

                        if (response.pesanerror) {
                          Swal.fire("Kesalahan", response.pesanerror, 'error').then(function() {
                            location.reload();
                          });
                        }

                        if (response.keranjangkosong) {
                          Swal.fire("Kesalahan", response.keranjangkosong, 'error').then(function() {
                            window.location = "<?= site_url('/'); ?>"
                          });
                        }
                      }
                    });
                    // console.log(JSON.stringify(result, null, 2))
                  },
                  // Optional
                  onPending: function(result) {
                    let dataResult = JSON.stringify(result, null, 2);
                    let dataObjek = JSON.parse(dataResult);

                    $.ajax({
                      type: "post",
                      url: "<?= site_url('/transaksi/checkout'); ?>",
                      data: {
                        pembeliid: pembeliid,
                        alamat: alamatpengiriman,
                        notelp: notelp,
                        totalberat: totalberat,
                        provinsi: provinsiterpilih,
                        distrik: distrikterpilih,
                        tipe: tipeterpilih,
                        kodepos: kodeposterpilih,
                        ekspedisi: ekspedisiterpilih,
                        paket: paketterpilih,
                        ongkir: ongkir,
                        estimasi: estimasi,
                        totalpembelian: totalpembelian,
                        totalbayar: totalbayar,

                        pdf_url: dataObjek.pdf_url,
                        snapToken: response.snapToken,
                        order_id: dataObjek.order_id,
                        payment_type: dataObjek.payment_type,
                        waktupembayaran: dataObjek.transaction_time,
                        statuspembayaran: dataObjek.transaction_status,
                      },
                      dataType: "json",
                      success: function(response) {
                        console.log(response);
                        if (response.sukses) {
                          Swal.fire("Sukses", response.sukses, 'success').then(function() {
                            window.location = "<?= site_url('/'); ?>"
                          });
                        }

                        if (response.pesanerror) {
                          Swal.fire("Kesalahan", response.pesanerror, 'error').then(function() {
                            location.reload();
                          });
                        }

                        if (response.keranjangkosong) {
                          Swal.fire("Kesalahan", response.keranjangkosong, 'error').then(function() {
                            window.location = "<?= site_url('/'); ?>"
                          });
                        }
                      }
                    });
                    // console.log(JSON.stringify(result, null, 2))
                  },
                  // Optional
                  onError: function(result) {
                    let dataResult = JSON.stringify(result, null, 2);
                    let dataObjek = JSON.parse(dataResult);

                    $.ajax({
                      type: "post",
                      url: "<?= site_url('/transaksi/checkout'); ?>",
                      data: {
                        pembeliid: pembeliid,
                        alamat: alamatpengiriman,
                        notelp: notelp,
                        totalberat: totalberat,
                        provinsi: provinsiterpilih,
                        distrik: distrikterpilih,
                        tipe: tipeterpilih,
                        kodepos: kodeposterpilih,
                        ekspedisi: ekspedisiterpilih,
                        paket: paketterpilih,
                        ongkir: ongkir,
                        estimasi: estimasi,
                        totalpembelian: totalpembelian,
                        totalbayar: totalbayar,

                        pdf_url: dataObjek.pdf_url,
                        snapToken: response.snapToken,
                        order_id: dataObjek.order_id,
                        payment_type: dataObjek.payment_type,
                        waktupembayaran: dataObjek.transaction_time,
                        statuspembayaran: dataObjek.transaction_status,
                      },
                      dataType: "json",
                      success: function(response) {
                        // console.log(response);
                        if (response.sukses) {
                          Swal.fire("Sukses", response.sukses, 'success').then(function() {
                            window.location = "<?= site_url('/'); ?>"
                          });
                        }

                        if (response.pesanerror) {
                          Swal.fire("Kesalahan", response.pesanerror, 'error').then(function() {
                            location.reload();
                          });
                        }

                        if (response.keranjangkosong) {
                          Swal.fire("Kesalahan", response.keranjangkosong, 'error').then(function() {
                            window.location = "<?= site_url('/'); ?>"
                          });
                        }
                      }
                    });
                    // console.log(JSON.stringify(result, null, 2))
                  }
                });
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + '\n' + thrownError);
            }
          });
        } else {
          Swal.fire('Kesalahan', 'No. Telp harus angka dan terdiri dari 12 - 13 karakter', 'error');
        }
      }
    });
  });
</script>

<?= $this->endSection('isi'); ?>