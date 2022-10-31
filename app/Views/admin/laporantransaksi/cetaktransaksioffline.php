  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMPTI | Laporan Transaksi Offline</title>
  </head>

  <body onload="window.print()">
    <table style="width: 100%; border-collapse: collapse; text-align: center;" border="1">
      <tr>
        <td>
          <table style="width: 100%;">
            <tr style="text-align: center;">
              <td>
                <h1>HMPTI</h1>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table style="width: 100%;">
            <tr style="text-align: center;">
              <td>
                <h3>Laporan Transaksi Offline</h3>
              </td>
            </tr>
            <tr>
              <td>Periode : <?= date('d-m-Y', strtotime($tglawal)); ?> s/d <?= date('d-m-Y', strtotime($tglakhir)); ?></td>
            </tr>
            <tr>
              <td>
                <center>
                  <table border="1" style="border-collapse: collapse; border: 1px solid #000; text-align:center; width:80%;">
                    <thead>
                      <tr>
                        <th style="width: 3%;">No. </th>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th style="width: 15%;">Pembeli</th>
                        <th>Detail Produk</th>
                        <th>Dibayar</th>
                        <th>Kembalian</th>
                        <th>Total Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $totalseluruhharga = 0;
                      foreach ($datatransaksi->getResultArray() as $t) : ?>
                        <tr>
                          <td><?= $no; ?>.</td>
                          <td><?= $t['transofflineid']; ?></td>
                          <td><?= date('d-m-Y', strtotime($t['tgltransaksi'])); ?></td>
                          <td><?= $t['namapembeli']; ?></td>
                          <td style="text-align: left;">
                            <?php
                            $db = \Config\Database::connect();
                            $detail = $db->table('tbl_detail_transaksioffline')
                              ->join('tbl_produk', 'tbl_detail_transaksioffline.produkid=tbl_produk.produkid')
                              ->where('transofflineid', $t['transofflineid'])
                              ->get()->getResultArray();

                            foreach ($detail as $d) :
                            ?>
                              <?= $d['namaproduk']; ?>
                              <ul>
                                <li>Jml : <?= $d['jml']; ?></li>
                                <li>Harga Jual : <?= number_format($d['hargajual'], 0, ",", "."); ?></li>
                                <li>Sub Total : <?= number_format($d['subtotal'], 0, ",", "."); ?></li>
                              </ul>
                            <?php endforeach; ?>
                          </td>
                          <td style="text-align: right;">Rp.<?= number_format($t['dibayar'], 0, ",", "."); ?></td>
                          <td style="text-align: right;">Rp.<?= number_format($t['kembalian'], 0, ",", "."); ?></td>
                          <td style="text-align: right;">Rp.<?= number_format($t['totalbayar'], 0, ",", "."); ?></td>
                        </tr>
                      <?php
                        $totalseluruhharga += $t['totalbayar'];
                        $no++;
                      endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="7">Total Seluruh Harga</th>
                        <td>Rp.<?= number_format($totalseluruhharga, 0, ",", "."); ?></td>
                      </tr>
                    </tfoot>
                  </table>
                </center>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>

  </html>