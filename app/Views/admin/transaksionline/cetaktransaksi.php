<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Struk Transaksi</title>
</head>

<!-- <body> -->

<body onload="window.print()">
  <table border="0" style="text-align: center; width: 100%;">
    <tr>
      <td colspan="2">
        <h3 style="height: 2px;">HMPTI Merchendaice</h3>
        <h5>Fakultas Ilmu Komputer Universitas Duta Bangsa, Jl. Bhayangkara No.55, Tipes, Kec. Serengan, Kota Surakarta, Jawa Tengah 57154</h5>
        <hr style="border: none; border-top: 1px solid #000;">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table style="width: 100%;">
          <tr>
            <td>
              <table>
                <caption>
                  <h4 style="text-align: left;">Transaksi</h4>
                </caption>
                <tr style="text-align: left;">
                  <td>ID Transaksi : </td>
                  <td><?= $id; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Tanggal Transaksi : </td>
                  <td><?= date('d-m-Y H:i:s', strtotime($tanggal)); ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Pembeli : </td>
                  <td><?= $namapembeli; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>E-mail pembeli : </td>
                  <td><?= $datatransaksi['emailpembeli']; ?></td>
                </tr>
                <?php if ($datatransaksi['statuspembelian'] == 'diproses') { ?>
                  <tr style="text-align: left;">
                    <td>Status Transaksi : </td>
                    <td>Diproses</td>
                  </tr>
                <?php } elseif ($datatransaksi['statuspembelian'] == 'pending') { ?>
                  <tr style="text-align: left;">
                    <td>Status Transaksi : </td>
                    <td>pending</td>
                  </tr>
                <?php } elseif ($datatransaksi['statuspembelian'] == 'dikirim') { ?>
                  <tr style="text-align: left;">
                    <td>Status Transaksi : </td>
                    <td>Dikirim</td>
                  </tr>
                <?php } elseif ($datatransaksi['statuspembelian'] == 'diterima') { ?>
                  <tr style="text-align: left;">
                    <td>Status Transaksi : </td>
                    <td>Diterima</td>
                  </tr>
                <?php } else { ?>
                  <tr style="text-align: left;">
                    <td>Status Transaksi : </td>
                    <td>Gagal</td>
                  </tr>
                <?php } ?>
              </table>
            </td>
            <td>
              <table>
                <caption>
                  <h4 style="text-align: left;">Pengiriman</h4>
                </caption>
                <tr style="text-align: left;">
                  <td>No. Telp : </td>
                  <td><?= $datatransaksi['notelp']; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Alamat Pengiriman : </td>
                  <td><?= $datatransaksi['alamat']; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Distrik : </td>
                  <td><?= $datatransaksi['distrik']; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Ekspedisi : </td>
                  <td><?= $datatransaksi['ekspedisi']; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Paket : </td>
                  <td><?= $datatransaksi['paket']; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Estimasi (Hari) : </td>
                  <td><?= $datatransaksi['estimasi']; ?></td>
                </tr>
                <tr style="text-align: left;">
                  <td>Ongkir (Rp) : </td>
                  <td><?= number_format($datatransaksi['ongkir'], 0, ',', '.'); ?></td>
                </tr>
              </table>
            </td>
            <td>
              <table>
                <caption>
                  <h4 style="text-align: left;">Pembayaran</h4>
                </caption>
                <tr style="text-align: left;">
                  <td>Order ID : </td>
                  <td><?= $datatransaksi['order_id']; ?></td>
                </tr>
                <?php if ($datatransaksi['statuspembayaran'] == 'pending') { ?>
                  <tr style="text-align: left;">
                    <td>Status Pembayaran : </td>
                    <td>Pending</td>
                  </tr>
                <?php } elseif ($datatransaksi['statuspembayaran'] == 'settlement') { ?>
                  <tr style="text-align: left;">
                    <td>Status Pembayaran : </td>
                    <td>Sukses</td>
                  </tr>
                <?php } else { ?>
                  <tr style="text-align: left;">
                    <td>Status Pembayaran : </td>
                    <td>Expire</td>
                  </tr>
                <?php } ?>
                <tr style="text-align: left;">
                  <td>Tipe Pembayaran : </td>
                  <td><?= $datatransaksi['payment_type']; ?></td>
                </tr>
                <?php if ($datatransaksi['payment_type'] == 'cstore') { ?>
                  <tr style="text-align: left;">
                    <td>Metode Pembayaran: </td>
                    <td><?= $statuspayment->store; ?></td>
                  </tr>
                  <tr style="text-align: left;">
                    <td>Total Pembayaran: </td>
                    <td>Rp <?= number_format($statuspayment->gross_amount, 0, ",", "."); ?></td>
                  </tr>
                <?php } elseif ($datatransaksi['payment_type'] == 'bank_transfer') { ?>
                  <tr style="text-align: left;">
                    <td>Nama Bank: </td>
                    <td><?= $statuspayment->va_numbers[0]->bank; ?>
                    </td>
                  </tr>
                  <tr style="text-align: left;">
                    <td>Total Pembayaran: </td>
                    <td> Rp <?= number_format($statuspayment->gross_amount, 0, ",", "."); ?></td>
                  </tr>
                <?php } ?>
              </table>
            </td>
          </tr>
        </table>
      </td>
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
            <td>Total Pembelian : </td>
            <td>Rp. <?= number_format($totalHarga, 0, ",", "."); ?></td>
          </tr>
          <tr style="text-align: right;">
            <td></td>
            <td>Ongkir (<?= number_format($datatransaksi['totalberat'], 0, ',', '.'); ?> Gram) : </td>
            <td>Rp. <?= number_format($datatransaksi['ongkir'], 0, ",", "."); ?></td>
          </tr>
          <tr style="text-align: right;">
            <td></td>
            <td>Total Bayar : </td>
            <td>Rp. <?= number_format($datatransaksi['totalbayar'], 0, ",", "."); ?></td>
          </tr>
          <tr>
            <td colspan="3">
              <hr style="border: none; border-top: 1px dashed #000;">
            </td>
          </tr>
          <tr>
            <td colspan="3" style="text-align: center;">
              Terima Kasih Atas Kunjungan Anda
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>