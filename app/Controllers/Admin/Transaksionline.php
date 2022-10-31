<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksiOnline;
use App\Models\ModelTransaksiOnline;
use \Hermawan\DataTables\DataTable;

class Transaksionline extends BaseController
{
  protected $ModelTransaksiOnline;
  protected $ModelDetailTransaksiOnline;

  public function __construct()
  {
    $this->ModelTransaksiOnline = new ModelTransaksiOnline();
    $this->ModelDetailTransaksiOnline = new ModelDetailTransaksiOnline();
  }

  public function index()
  {
    $data = [
      'title' => 'Data Transaksi Online'
    ];
    return view('admin/transaksionline/view', $data);
  }

  public function datatransaksi()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view('admin/transaksionline/datatransaksi')
      ];
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diproses");
    }
  }

  public function listData()
  {
    if ($this->request->isAJAX()) {
      $db = \Config\Database::connect();
      $builder = $db->table('tbl_transaksionline')
        ->select('transonlineid, tgltransaksi, statuspembayaran, statuspembelian, totalbayar')
        ->where('statuspembayaran', 'settlement')
        ->orderBy('tgltransaksi', 'DESC');

      return DataTable::of($builder)
        ->add('aksi', function ($row) {
          // $transaksiid = sha1($row->transonlineid);
          return
            "
          <button type='button' class='btn btn-sm btn-secondary' title='Pengiriman' onclick='pembayaran(\"$row->transonlineid\");'><i class='fas fa-truck'></i></button>

          <button type='button' class='btn btn-sm btn-info' title='Lihat Transaksi' onclick='detailtransaksi(\"$row->transonlineid\");'><i class='fa fa-eye'></i></button>

          <button type='button' class='btn btn-sm btn-primary' title='Cetak Transaksi' onclick='cetak(\"$row->transonlineid\");'><i class='fa fa-print'></i></button>
          ";
        })
        ->add('total', function ($row) {
          return "
            <div class='text-right'>Rp " . number_format($row->totalbayar, 0, ',', '.') . "</div>
          ";
        })
        ->add('tgl', function ($row) {
          return "<div class='text-center'>" . date('d-m-Y', strtotime($row->tgltransaksi)) . "</div>";
        })
        ->add('statusbayar', function ($row) {
          if ($row->statuspembayaran == 'settlement') {
            return "<div class='text-center'><nav class='badge badge-success'>Sukses</nav></div>";
          }
        })
        ->add('statusbeli', function ($row) {
          if ($row->statuspembelian == 'diproses') {
            $status = ' <nav class="badge badge-warning">Diproses</nav>';
          } elseif ($row->statuspembelian == 'pending') {
            $status = '<nav class="badge badge-secondary">Pending</nav>';
          } elseif ($row->statuspembelian == 'dikirim') {
            $status = '<nav class="badge badge-info">Dikirim</nav>';
          } elseif ($row->statuspembelian == 'diterima') {
            $status = '<nav class="badge badge-success">Diterima</nav>';
          } else {
            $status = '<nav class="badge badge-danger">Gagal</nav>';
          }
          return "<div class='text-center'>" . $status . "</div>";
        })
        ->addNumbering('nomor')
        ->filter(function ($builder, $request) {
          if ($request->tglawal) {
            // $builder->where('tgltransaksi >=', $request->tglawal)
            //   ->where('tgltransaksi <=', $request->tglakhir);
            $builder->where("DATE_FORMAT(tgltransaksi, '%Y-%m-%d') BETWEEN '" . $request->tglawal . "' and '" . $request->tglakhir . "'");
          }
          if ($request->statuspembelian) {
            $builder->where('statuspembelian', $request->statuspembelian);
          }

          if ($request->tglawal && $request->tglakhir && $request->statuspembelian) {
            $builder->where("DATE_FORMAT(tgltransaksi, '%Y-%m-%d') BETWEEN '" . $request->tglawal . "' and '" . $request->tglakhir . "'")->where('statuspembelian', $request->statuspembelian);
          }
        })
        ->toJson(true);
    } else {
      exit("Maaf tidak dapat diproses");
    }
  }

  public function datapembayaran()
  {
    if ($this->request->isAJAX()) {
      $transonlineid = $this->request->getVar('transonlineid');

      // Set your Merchant Server Key
      \Midtrans\Config::$serverKey = 'SB-Mid-server-o4cVLaEqV9hq5Og_l3wDYZk5';
      // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
      \Midtrans\Config::$isProduction = false;
      // Set sanitization on (default)
      \Midtrans\Config::$isSanitized = true;
      // Set 3DS transaction for credit card to true
      \Midtrans\Config::$is3ds = true;

      $cariorderid = $this->ModelTransaksiOnline->find($transonlineid);
      $status = \Midtrans\Transaction::status($cariorderid['order_id']);

      $data = [
        'transaksi' => $this->ModelTransaksiOnline
          ->join('tbl_pembeli', 'tbl_transaksionline.pembeliid=tbl_pembeli.pembeliid')
          ->where('transonlineid', $transonlineid)
          ->get()->getRowArray(),
        'statuspayment' => $status,
      ];
      $json = [
        'data' => view('admin/transaksionline/datapembayaran', $data),
      ];
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diproses");
    }
  }

  public function ubahstatuspembelian()
  {
    if ($this->request->isAJAX()) {
      $transonlineid = $this->request->getVar('transonlineid');
      $noresi = $this->request->getVar('noresi');
      $statuspembelian = $this->request->getVar('statuspembelian');

      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'statuspembelian' => [
          'label' => 'Status',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ]
      ]);

      if ($valid) {
        $this->ModelTransaksiOnline->update($transonlineid, [
          'noresi' => $noresi,
          'statuspembelian' => $statuspembelian,
        ]);
        $json = [
          'sukses' => 'Transaksi ' . $transonlineid . ' berhasil diubah'
        ];
      } else {
        $json = [
          'error' => [
            'statuspembelian' => $validation->getError('statuspembelian'),
          ]
        ];
      }
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diproses");
    }
  }

  public function detail_transaksi($transonlineid)
  {
    $cekdata = $this->ModelTransaksiOnline->find($transonlineid);
    if ($cekdata) {
      // Set your Merchant Server Key
      \Midtrans\Config::$serverKey = 'SB-Mid-server-o4cVLaEqV9hq5Og_l3wDYZk5';
      // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
      \Midtrans\Config::$isProduction = false;
      // Set sanitization on (default)
      \Midtrans\Config::$isSanitized = true;
      // Set 3DS transaction for credit card to true
      \Midtrans\Config::$is3ds = true;

      $status = \Midtrans\Transaction::status($cekdata['order_id']);

      $data = [
        'title' => 'Detail Transaksi',
        'datatransaksi' => $this->ModelTransaksiOnline
          ->join('tbl_pembeli', 'tbl_transaksionline.pembeliid=tbl_pembeli.pembeliid')
          ->getWhere(['transonlineid' => $transonlineid])->getRowArray(),
        'detailtransaksi' => $this->ModelDetailTransaksiOnline
          ->join('tbl_produk', 'tbl_detail_transaksionline.produkid=tbl_produk.produkid')
          ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
          ->getWhere(['transonlineid' => $transonlineid])->getResultArray(),
        'statuspayment' => $status
      ];
      return view('admin/transaksionline/detailtransaksi', $data);
    } else {
      return redirect()->to(site_url('/admin/transaksionline/index'));
    }
  }

  public function cetaktransaksi($id)
  {
    $cekData = $this->ModelTransaksiOnline
      ->join('tbl_pembeli', 'tbl_transaksionline.pembeliid=tbl_pembeli.pembeliid')
      ->getWhere(['transonlineid' => $id])->getRowArray();
    if ($cekData != null) {
      // Set your Merchant Server Key
      \Midtrans\Config::$serverKey = 'SB-Mid-server-o4cVLaEqV9hq5Og_l3wDYZk5';
      // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
      \Midtrans\Config::$isProduction = false;
      // Set sanitization on (default)
      \Midtrans\Config::$isSanitized = true;
      // Set 3DS transaction for credit card to true
      \Midtrans\Config::$is3ds = true;

      $status = \Midtrans\Transaction::status($cekData['order_id']);

      $data = [
        'id' => $id,
        'tanggal' => $cekData['tgltransaksi'],
        'namapembeli' => $cekData['namapembeli'],
        'datatransaksi' => $cekData,
        'detailbarang' => $this->ModelDetailTransaksiOnline->detailItem($id)->get(),
        'statuspayment' => $status
      ];
      return view('admin/transaksionline/cetaktransaksi', $data);
    } else {
      return redirect()->to(site_url('admin/transaksionline/index'));
    }
  }
}
