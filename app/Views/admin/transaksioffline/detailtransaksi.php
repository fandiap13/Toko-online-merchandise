<div class="modal fade" id="modalpembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Detail Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <h5 class="modal-title">Data Transaksi</h5>
            <table style="width: 100%;">
              <tr>
                <td style="width: 50%; font-weight: bold;">ID Transaksi</td>
                <td>:</td>
                <td style="width: 50%;">1002250001</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">Tanggal Transaksi</td>
                <td>:</td>
                <td style="width: 50%;">22-01-5022, 17:56</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">Total Pembayaran</td>
                <td>:</td>
                <td style="width: 50%;">Rp.<?= number_format(140000, 0, ",", "."); ?></td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">Status</td>
                <td>:</td>
                <td style="width: 50%;">
                  <nav class="badge badge-danger">Gagal</nav>
                </td>
              </tr>
            </table>
          </div>
          <div class="col-md-4">
            <h5 class="modal-title">Data Pembeli</h5>
            <table style="width: 100%;">
              <tr>
                <td style="width: 50%; font-weight: bold;">Nama</td>
                <td>:</td>
                <td style="width: 50%;">Joni Maulindar</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">Jenis Kelamin</td>
                <td>:</td>
                <td style="width: 50%;">Laki - laki</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">E-mail</td>
                <td>:</td>
                <td style="width: 50%;">jonimaulindar@gmail.com</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">No. Telp</td>
                <td>:</td>
                <td style="width: 50%;">
                  0895392518889
                </td>
              </tr>
            </table>
          </div>
          <div class="col-md-4">
            <h5 class="modal-title">Data Pengiriman</h5>
            <table style="width: 100%;">
              <tr>
                <td style="width: 25%; font-weight: bold;">Alamat Toko</td>
                <td>:</td>
                <td style="width: 75%;">Dusun Bandar RT 01/06, Desa Bandardawung, Kec. Tawangmangu, Kab. Karanganyar</td>
              </tr>
              <tr>
                <td style="width: 25%; font-weight: bold;">Ongkos Kirim</td>
                <td>:</td>
                <td style="width: 75%;">Rp.<?= number_format(20000, 0, ",", "."); ?></td>
              </tr>
              <tr>
                <td style="width: 25%; font-weight: bold;">Ekspedisi</td>
                <td>:</td>
                <td style="width: 75%;">jne OKE 2-3</td>
              </tr>
              <tr>
                <td style="width: 25%; font-weight: bold;">Alamat Pengiriman</td>
                <td>:</td>
                <td style="width: 75%;">
                  Bandar RT 01/06, Bandardawung, Tawangmangu, Karanganyar
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="row"><button class="btn btn-success"><i class="fa fa-download fa-sm"></i> Download PDF</button></div>

        <div class="row mt-2">
          <table class="table table-sm table-hover" width="100%" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th style="width: 10%;">No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th style="width: 10%;">Jumlah</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1. </td>
                <td>PDH HMPTI</td>
                <td>PDH</td>
                <td>1</td>
                <td class="text-right">Rp.<?= number_format(120000, 0, ",", "."); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

</script>