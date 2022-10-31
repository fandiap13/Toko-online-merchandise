<link rel="stylesheet" href="<?= base_url() . '/plugins/chart.js/Chart.min.css' ?>">
<script src=" <?= base_url() . '/plugins/chart.js/Chart.bundle.min.js' ?>">
</script>
<script src="<?= base_url(); ?>/plugins/chart.js/Chart.min.js"></script>

<?php

$tanggal = "";
$total = "";

$presentasepenurunan = 0;
$presentasepeningkatan = 0;

$pemasukanbulanini = 0;
$pemasukanbulanlalu = $pemasukanlama;

foreach ($grafik as $row) :
  $tgl = $row->tgl;
  $tanggal .= "'$tgl'" . ",";

  $totalHarga = $row->totalbayar;
  $total .= "'$totalHarga'" . ",";

  $pemasukanbulanini += $row->totalbayar;
endforeach;

// menghitung presentase kenaikan dan penurunan
if ($pemasukanbulanlalu == 0 || $pemasukanbulanini == 0) {
  $presentasepenurunan = 0;
  $presentasepeningkatan = 0;
} else {
  $presentase = (($pemasukanbulanini - $pemasukanbulanlalu) / $pemasukanbulanlalu) * 100;
  if ($presentase > 0) {
    $presentasepeningkatan = $presentase;
    $presentasepenurunan = 0;
  } else {
    $presentasepenurunan = $presentase;
    $presentasepeningkatan = 0;
  }
}

// echo $tanggal;
// echo $total;

// echo "presentase penurunan : " . $presentasepenurunan . "%<br>";
// echo "presentase peningkatan : " . $presentasepeningkatan . "%<br>";
// echo "pemasukan lama : " . $pemasukanbulanlalu . "<br>";
// echo "pemasukan sekarang : " . $pemasukanbulanini . "<br>";

?>

<div class="d-flex">
  <p class="d-flex flex-column">
    <span class="text-bold text-lg">Rp.<?= number_format($pemasukanbulanini, 0, ",", "."); ?></span>
    <span>Total Penjualan Bulan Ini</span>
  </p>

  <?php if ($presentasepeningkatan !== 0) { ?>
    <p class="ml-auto d-flex flex-column text-right">
      <span class="text-success">
        <i class="fas fa-arrow-up"></i> <?= round($presentasepeningkatan, 2); ?>%
      </span>
      <span class="text-muted">Bulan lalu Rp.<?= number_format($pemasukanbulanlalu, 0, ",", "."); ?></span>
    </p>
  <?php } ?>

  <?php if ($presentasepenurunan !== 0) { ?>
    <p class="ml-auto d-flex flex-column text-right">
      <span class="text-danger">
        <i class="fas fa-arrow-down"></i> <?= round($presentasepenurunan, 2); ?>%
      </span>
      <span class="text-muted">Bulan lalu Rp.<?= number_format($pemasukanbulanlalu, 0, ",", "."); ?></span>
    </p>
  <?php } ?>
</div>

<canvas id="myChart" style="height: 50vh; width: 80vh;"></canvas>

<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar', // tipe grafik
    responsive: true,
    data: {
      labels: [<?= $tanggal; ?>], // label mengambil nilai dari tanggal
      datasets: [{ // mengasih label tulisan atau mengubah warna batang
        label: 'Total Harga',
        backgroundColor: 'rgb(14, 99, 132)', // terdapat dua warna pada batang
        borderColor: ['rgb(255,991,130)'],
        data: [<?= $total; ?>]
      }]
    },
    duration: 1000
  });
</script>