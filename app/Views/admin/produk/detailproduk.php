<div class="modal fade" id="modaldetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Detail Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table style="width: 100%;">
          <tr>
            <td style="width: 20%; font-weight: bold;">Nama Produk</td>
            <td>:</td>
            <td style="width: 75%;">PDH HMPTI</td>
          </tr>
          <tr>
            <td style="width: 20%; font-weight: bold;">Kategori Produk</td>
            <td>:</td>
            <td style="width: 75%;">PDH</td>
          </tr>
          <tr>
            <td style="width: 20%; font-weight: bold;">Harga</td>
            <td>:</td>
            <td style="width: 75%;">Rp.<?= number_format(120000, 0, ",", "."); ?></td>
          </tr>
          <tr>
            <td style="width: 20%; font-weight: bold;">Satuan</td>
            <td>:</td>
            <td style="width: 75%;">Pcs</td>
          </tr>
          <tr>
            <td style="width: 20%; font-weight: bold;">Berat</td>
            <td>:</td>
            <td style="width: 75%;">1000 Gram</td>
          </tr>
          <tr>
            <td style="width: 20%; font-weight: bold;">Status</td>
            <td>:</td>
            <td style="width: 75%;">
              <nav class="badge badge-danger">Habis</nav>
            </td>
          </tr>
          <tr>
            <td style="width: 20%; font-weight: bold;">Deskripsi</td>
            <td>:</td>
            <td style="width: 75%;">
              <p>Card titles are used by adding .card-title to a <h*> tag. In the same way, links are added and placed next to each other by adding .card-link to an <a> tag.

                    Subtitles are used by adding a .card-subtitle to a <h*> tag. If the .card-title and the .card-subtitle items are placed in a .card-body item, the card title and subtitle are aligned nicely.</p>
            </td>
          </tr>
        </table>

        <p style="font-weight: bold;">Gambar Produk</p>
        <div class="row">
          <div class="col-md-2">
            <div class="card">
              <img src="<?= base_url(); ?>/dist/img/user2-160x160.jpg" class="card-img-top" alt="Gambar Produk">
            </div>
          </div>
          <div class="col-md-2">
            <div class="card">
              <img src="<?= base_url(); ?>/dist/img/user2-160x160.jpg" class="card-img-top" alt="Gambar Produk">
            </div>
          </div>
          <div class="col-md-2">
            <div class="card">
              <img src="<?= base_url(); ?>/dist/img/user2-160x160.jpg" class="card-img-top" alt="Gambar Produk">
            </div>
          </div>
          <div class="col-md-2">
            <div class="card">
              <img src="<?= base_url(); ?>/dist/img/user2-160x160.jpg" class="card-img-top" alt="Gambar Produk">
            </div>
          </div>
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