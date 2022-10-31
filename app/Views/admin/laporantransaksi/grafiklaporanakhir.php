<link rel="stylesheet" href="<?= base_url() . '/plugins/chart.js/Chart.min.css' ?>">
<script src=" <?= base_url() . '/plugins/chart.js/Chart.bundle.min.js' ?>">
</script>
<script src="<?= base_url(); ?>/plugins/chart.js/Chart.min.js"></script>

<?php

// grafik online
$data = "";
$total1 = 0;
$jml1 = 1;
$bulan1 = "";
foreach ($grafikOnline as $key => $value) {
  $totalbayar = $value['totalbayar'];
  $data .= "'" . $totalbayar . "'" . ",";
  $total1 += $totalbayar;
  $bulan1 .= "'" . date('F', strtotime($value['tgl'])) . "'" . ",";
  $jml1++;
}

// grafik offline
$data2 = "";
$total2 = 0;
$jml2 = 1;
$bulan2 = "";
foreach ($grafikOffline as $key => $value) {
  $totalbayar = $value['totalbayar'];
  $data2 .= "'" . $totalbayar . "'" . ",";
  $total2 += $totalbayar;
  $bulan2 .= "'" . date('F', strtotime($value['tgl'])) . "'" . ",";
  $jml2++;
}

// total pemasukan
$total = $total1 + $total2;

// bulan
// $bulan = date('m');
// $label = "";
// for ($i = 01; $i <= $bulan; $i++) {
//   $monthNum = sprintf("%02s", $i);
//   $label .= "'" . date('F', mktime(0, 0, 0, $monthNum)) . "'" . ",";
// }

// $label = "";
if ($jml1 < $jml2) {
  $label = $bulan2;
} else {
  $label = $bulan1;
}

?>

<div class="chart">
  <div class="d-flex">
    <p class="d-flex flex-column">
      <span class="text-bold text-lg">Rp.<?= number_format($total, 0, ",", "."); ?></span>
      <span>Total Penjualan Tahun <?= date('Y'); ?></span>
    </p>
  </div>
  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>
<div class="total"></div>

<script>
  $(function() {
    var areaChartData = {
      labels: [<?= $label; ?>],
      datasets: [{
          label: 'Transaksi Online',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [<?= $data; ?>]
        },
        {
          label: 'Transaksi Offline',
          backgroundColor: 'rgba(210, 214, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [<?= $data2; ?>]
        },
      ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

  });
</script>