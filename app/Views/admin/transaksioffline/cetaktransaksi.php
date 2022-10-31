<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Struk Transaksi</title>
</head>

<body onload="window.print()">
  <table border="0" style="text-align: center; width: 100%;">
    <tr>
      <td colspan="2">
        <h3 style="height: 2px;">HMPTI Merchendaice</h3>
        <h5>Fakultas Ilmu Komputer Universitas Duta Bangsa, Jl. Bhayangkara No.55, Tipes, Kec. Serengan, Kota Surakarta, Jawa Tengah 57154</h5>
        <hr style="border: none; border-top: 1px solid #000;">
      </td>
    </tr>
    <tr style="text-align: left;">
      <td>ID Transaksi : </td>
      <td><?= $id; ?></td>
    </tr>
    <tr style="text-align: left;">
      <td>Tanggal : </td>
      <td><?= date('d-m-Y', strtotime($tanggal)); ?></td>
    </tr>
    <tr style="text-align: left;">
      <td>Pelanggan : </td>
      <td><?= $namapembeli; ?></td>
    </tr>
    <tr style="text-align: left;">
      <td>Kasir : </td>
      <td><?= $kasir; ?></td>
    </tr>
    <tr>
      <td colspan="2">
        <hr style="border: none; border-top: 1px dashed #000;">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table style="width: 100%; text-align: left;" border="0">
          <?php
          $totalItem = 0;
          $jmlItem = 0;
          $totalHarga = 0;
          foreach ($detailbarang->getResultArray() as $row) :
            $totalItem += $row['jml'];
            $jmlItem++;
            $totalHarga += $row['subtotal'];
          ?>
            <tr>
              <td colspan="3"><?= $row['namaproduk']; ?></td>
            </tr>
            <tr>
              <td><?= number_format($row['jml'], 0, ",", ".") . ' ' . $row['namasatuan']; ?>
                <?php if ($row['ukuran'] !== NULL) { ?>
                  , ukuran <?= $row['ukuran']; ?>
                <?php } ?>
              </td>
              <td style="text-align: right;"><?= number_format($row['hargaproduk'], 0, ",", "."); ?></td>
              <td style="text-align: right;"><?= number_format($row['subtotal'], 0, ",", "."); ?></td>
            </tr>
          <?php
          endforeach;
          ?>
          <tr>
            <td colspan="3">
              <hr style="border: none; border-top: 1px dashed #000;">
            </td>
          </tr>
          <tr>
            <td colspan="3">
              Jml.Item : <?= number_format($jmlItem, 0, ",", ".") . '(' . number_format($totalItem, 0, ",", ".") . ')'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <hr style="border: none; border-top: 1px dashed #000;">
            </td>
          </tr>
          <tr style="text-align: right;">
            <td></td>
            <td>Total : </td>
            <td>Rp. <?= number_format($totalHarga, 0, ",", "."); ?></td>
          </tr>
          <tr style="text-align: right;">
            <td></td>
            <td>Jml.Uang : </td>
            <td>Rp. <?= number_format($jumlahuang, 0, ",", "."); ?></td>
          </tr>
          <tr style="text-align: right;">
            <td></td>
            <td>Sisa : </td>
            <td>Rp. <?= number_format($sisauang, 0, ",", "."); ?></td>
          </tr>
          <tr>
            <td colspan="3">
              <hr style="border: none; border-top: 1px dashed #000;">
            </td>
          </tr>
          <tr>
            <td colspan="3">
              Terima Kasih Atas Kunjungan Anda
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>