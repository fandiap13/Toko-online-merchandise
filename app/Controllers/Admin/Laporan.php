<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelTransaksiOffline;
use App\Models\ModelTransaksiOnline;

class Laporan extends BaseController
{
  protected $ModelTransaksiOffline;
  protected $ModelTransaksiOnline;

  public function __construct()
  {
    $this->ModelTransaksiOffline = new ModelTransaksiOffline();
    $this->ModelTransaksiOnline = new ModelTransaksiOnline();
  }

  public function cetak_transaksi_offline()
  {
    $data = [
      'title' => 'Laporan Transaksi Offline'
    ];
    return view('admin/laporantransaksi/viewlaptransoffline', $data);
  }

  public function cetak_laporan_transaksi_offline_periode()
  {
    $tglawal = $this->request->getVar('tglawal');
    $tglakhir = $this->request->getVar('tglakhir');
    if ($tglawal == "" || $tglakhir == "") {
      return redirect()->to(site_url('/admin/laporan/cetak-transaksi-offline'));
    } else {
      $data = [
        'tglawal' => $tglawal,
        'tglakhir' => $tglakhir,
        'datatransaksi' => $this->ModelTransaksiOffline
          ->where('tgltransaksi >=', $tglawal)
          ->where('tgltransaksi <=', $tglakhir)
          ->get()
      ];
      return view('admin/laporantransaksi/cetaktransaksioffline', $data);
    }
  }

  public function tampilgrafiktransaksioffline()
  {
    $bulan = $this->request->getVar('bulan');
    $bulanlama = date('Y-m', strtotime($bulan . ' - 1 months'));
    $pemasukanlama = 0;

    $db = \Config\Database::connect();
    $query = $db->query("SELECT tgltransaksi AS tgl, totalbayar FROM tbl_transaksioffline WHERE DATE_FORMAT(tgltransaksi, '%Y-%m') = '$bulan' ORDER BY tgltransaksi ASC")->getResult();

    $querylama = $db->query("SELECT tgltransaksi AS tgl, totalbayar FROM tbl_transaksioffline WHERE DATE_FORMAT(tgltransaksi, '%Y-%m') = '$bulanlama' ORDER BY tgltransaksi ASC")->getResult();
    foreach ($querylama as $q) {
      $pemasukanlama += $q->totalbayar;
    }

    $json = [
      'data' => view('admin/laporantransaksi/grafiktransaksioffline', $data = [
        'grafik' => $query,
        'pemasukanlama' => $pemasukanlama
      ])
    ];
    echo json_encode($json);
  }

  public function cetak_transaksi_online()
  {
    $data = [
      'title' => 'Laporan Transaksi Online'
    ];
    return view('admin/laporantransaksi/viewlaptransonline', $data);
  }

  public function cetak_laporan_transaksi_online_periode()
  {
    $tglawal = $this->request->getVar('tglawal');
    $tglakhir = $this->request->getVar('tglakhir');
    if ($tglawal == "" || $tglakhir == "") {
      return redirect()->to(site_url('/admin/laporan/cetak-transaksi-online'));
    } else {
      $data = [
        'tglawal' => $tglawal,
        'tglakhir' => $tglakhir,
        'datatransaksi' => $this->ModelTransaksiOnline
          ->join('tbl_pembeli', 'tbl_transaksionline.pembeliid=tbl_pembeli.pembeliid')
          ->where('tgltransaksi >=', $tglawal)
          ->where('tgltransaksi <=', $tglakhir)
          ->where('statuspembelian', 'diterima')
          ->get()
      ];
      return view('admin/laporantransaksi/cetaktransaksionline', $data);
    }
  }

  public function tampilgrafiktransaksionline()
  {
    $bulan = $this->request->getVar('bulan');
    $bulanlama = date('Y-m', strtotime($bulan . ' - 1 months'));
    $pemasukanlama = 0;

    $db = \Config\Database::connect();
    $query = $db->query("SELECT tgltransaksi AS tgl, totalbayar FROM tbl_transaksionline WHERE statuspembelian = 'diterima' AND DATE_FORMAT(tgltransaksi, '%Y-%m') = '$bulan' ORDER BY tgltransaksi ASC")->getResult();

    $querylama = $db->query("SELECT tgltransaksi AS tgl, totalbayar FROM tbl_transaksionline WHERE statuspembelian = 'diterima' AND DATE_FORMAT(tgltransaksi, '%Y-%m') = '$bulanlama' ORDER BY tgltransaksi ASC")->getResult();
    foreach ($querylama as $q) {
      $pemasukanlama += $q->totalbayar;
    }

    $json = [
      'data' => view('admin/laporantransaksi/grafiktransaksionline', $data = [
        'grafik' => $query,
        'pemasukanlama' => $pemasukanlama
      ])
    ];
    echo json_encode($json);
  }

  public function cetak_laporan_akhir()
  {
    $data = [
      'title' => 'Laporan Akhir'
    ];
    return view('admin/laporantransaksi/laporanakhir', $data);
  }

  public function grafiklaporanakhir()
  {
    if ($this->request->isAJAX()) {
      $tahun = date('Y');
      $db = \Config\Database::connect();

      $query2 = $db->query("SELECT tgltransaksi AS tgl, sum(totalbayar) as totalbayar FROM tbl_transaksioffline WHERE DATE_FORMAT(tgltransaksi, '%Y') = '$tahun' GROUP BY DATE_FORMAT(tgltransaksi, '%Y-%m') ORDER BY tgltransaksi ASC")->getResultArray();

      $query1 = $db->query("SELECT tgltransaksi AS tgl, sum(totalbayar) as totalbayar FROM tbl_transaksionline WHERE statuspembelian = 'diterima' AND DATE_FORMAT(tgltransaksi, '%Y') = '$tahun' GROUP BY DATE_FORMAT(tgltransaksi, '%Y-%m') ORDER BY tgltransaksi ASC")->getResultArray();

      $data = [
        'grafikOnline' => $query1,
        'grafikOffline' => $query2
      ];
      $json = [
        'data' => view('admin/laporantransaksi/grafiklaporanakhir', $data)
      ];
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diproses");
    }
  }
}
