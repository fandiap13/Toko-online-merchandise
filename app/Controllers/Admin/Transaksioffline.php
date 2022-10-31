<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksiOffline;
use App\Models\ModelTempTransaksiOffline;
use App\Models\ModelTransaksiOffline;
use \Hermawan\DataTables\DataTable;

class Transaksioffline extends BaseController
{
  protected $ModelTransaksiOffline;
  protected $ModelDetailTransaksiOffline;
  protected $ModelTempTransaksiOffline;

  public function __construct()
  {
    $this->ModelTransaksiOffline = new ModelTransaksiOffline();
    $this->ModelDetailTransaksiOffline = new ModelDetailTransaksiOffline();
    $this->ModelTempTransaksiOffline = new ModelTempTransaksiOffline();
  }

  public function index()
  {
    $data = [
      'title' => 'Data Transaksi Offline'
    ];
    return view('admin/transaksioffline/view', $data);
  }

  public function datatransaksi()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view('admin/transaksioffline/datatransaksi')
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
      $builder = $db->table('tbl_transaksioffline')
        ->select('transofflineid, namapembeli, tgltransaksi, totalbayar, kasir')
        ->orderBy('tgltransaksi', 'DESC');

      return DataTable::of($builder)
        ->add('aksi', function ($row) {
          $transaksiid = sha1($row->transofflineid);
          return
            "
          <div class='text-center'>
          <button type='button' class='btn btn-sm btn-info' title='Edit Data' onclick='edit(\"$transaksiid\");'><i class='fa fa-edit'></i></button>

          <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' onclick='hapus(\"$row->transofflineid\");'><i class='fa fa-trash-alt'></i></button>

          <button type='button' class='btn btn-sm btn-primary' title='Cetak Transaksi' onclick='cetak(\"$row->transofflineid\");'><i class='fa fa-print'></i></button>
          ";
        })
        ->add('total', function ($row) {
          return "
            <div class='text-right'>" . number_format($row->totalbayar, 0, ',', '.') . "</div>
          ";
        })
        ->add('tgl', function ($row) {
          return "<div class='text-center'>" . date('d-m-Y', strtotime($row->tgltransaksi)) . "</div>";
        })
        ->addNumbering('nomor')
        ->filter(function ($builder, $request) {
          if ($request->tglawal)
            // $builder->where('tgltransaksi >=', $request->tglawal)
            //   ->where('tgltransaksi <=', $request->tglakhir);
            $builder->where("tgltransaksi BETWEEN '" . $request->tglawal . "' and '" . $request->tglakhir . "'");
        })
        ->toJson(true);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function cetaktransaksi($id)
  {
    $cekData = $this->ModelTransaksiOffline->find($id);
    if ($cekData != null) {
      $data = [
        'id' => $id,
        'tanggal' => $cekData['tgltransaksi'],
        'jumlahuang' => $cekData['dibayar'],
        'sisauang' => $cekData['kembalian'],
        'namapembeli' => $cekData['namapembeli'],
        'kasir' => $cekData['kasir'],
        'detailbarang' => $this->ModelDetailTransaksiOffline->tampilDetail($id)
      ];
      return view('admin/transaksioffline/cetaktransaksi', $data);
    } else {
      return redirect()->to(site_url('admin/transaksioffline/index'));
    }
  }

  public function simpandatatemp()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $hargajual = $this->request->getVar('hargajual');
      $jml = $this->request->getVar('jml');
      $ukuran = $this->request->getVar('ukuran');
      $transofflineid = $this->request->getVar('transofflineid');

      $subtotal = intval($jml * $hargajual);

      if ($ukuran == "") {
        $ukuran = NULL;
      }

      $simpan = $this->ModelTempTransaksiOffline->insert([
        'produkid' => $produkid,
        'hargajual' => $hargajual,
        'jml' => $jml,
        'ukuran' => $ukuran,
        'transofflineid' => $transofflineid,
        'subtotal' => $subtotal,
      ]);

      if ($simpan) {
        $json = [
          'sukses' => 'Item berhasil ditambahkan'
        ];
        echo json_encode($json);
      }
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function tampilDataTemp()
  {
    if ($this->request->isAJAX()) {
      $transofflineid = $this->request->getVar('transofflineid');
      $data = [
        'dataTemp' => $this->ModelTempTransaksiOffline->tampilTemp($transofflineid)->getResultArray()
      ];
      $json = [
        'data' => view('admin/transaksioffline/datatemp', $data)
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function hapustempitem()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getVar('id');
      $cekData = $this->ModelTempTransaksiOffline->find($id);
      if ($cekData) {
        $this->ModelTempTransaksiOffline->delete($id);
        $json = [
          'sukses' => "Item berhasil dihapus"
        ];
      } else {
        $json = [
          'pesanerror' => "Data tidak ditemukan"
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function tambah()
  {
    $data = [
      'title' => 'Tambah Transaksi Offline',
    ];
    return view('admin/transaksioffline/tambah', $data);
  }

  public function transofflineid()
  {
    if ($this->request->isAJAX()) {
      $tgltransaksi = $this->request->getVar('tgltransaksi');
      $json = [
        'transofflineid' => $this->ModelTransaksiOffline->transofflineid($tgltransaksi)
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function modalpembayaran()
  {
    if ($this->request->isAJAX()) {
      $transofflineid = $this->request->getVar('transofflineid');
      $totalbayar = $this->request->getVar('totalbayar');
      $namapembeli = $this->request->getVar('namapembeli');
      $tgltransaksi = $this->request->getVar('tgltransaksi');
      $cekData = $this->ModelTempTransaksiOffline->tampilTemp($transofflineid)->getNumRows();
      if ($cekData > 0) {
        $data = [
          'transofflineid' => $transofflineid,
          'totalbayar' => $totalbayar,
          'namapembeli' => $namapembeli,
          'tgltransaksi' => $tgltransaksi,
        ];
        $json = [
          'data' => view('admin/transaksioffline/modalpembayaran', $data)
        ];
      } else {
        $json = [
          'pesanerror' => 'Maaf item ini belum ada'
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanPembayaran()
  {
    if ($this->request->isAJAX()) {
      $transofflineid = $this->request->getVar('transofflineid');
      $namapembeli = $this->request->getVar('namapembeli');
      $tgltransaksi = $this->request->getVar('tgltransaksi');
      $totalbayar = str_replace(".", "", $this->request->getVar('totalbayar'));
      $kembalian = str_replace(".", "", $this->request->getVar('kembalian'));
      $dibayar = str_replace(".", "", $this->request->getVar('dibayar'));

      $validation = \Config\Services::validation();
      $valid = $this->validate([
        'dibayar' => [
          'label' => 'Input pembayaran',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong'
          ]
        ]
      ]);

      if ($valid) {
        $simpan = [
          'transofflineid' => $transofflineid,
          'namapembeli' => $namapembeli,
          'tgltransaksi' => $tgltransaksi,
          'totalbayar' => $totalbayar,
          'kembalian' => $kembalian,
          'dibayar' => $dibayar,
          'kasir' => session()->get('LoggedUserData')['name'],
        ];
        $this->ModelTransaksiOffline->insert($simpan);

        $dataTemp = $this->ModelTempTransaksiOffline->getWhere([
          'transofflineid' => $transofflineid
        ]);
        $fieldDetail = [];
        foreach ($dataTemp->getResultArray() as $row) {
          $fieldDetail[] = [
            'transofflineid' => $row['transofflineid'],
            'produkid' => $row['produkid'],
            'hargajual' => $row['hargajual'],
            'jml' => $row['jml'],
            'ukuran' => $row['ukuran'],
            'subtotal' => $row['subtotal'],
          ];
        }
        $this->ModelDetailTransaksiOffline->insertBatch($fieldDetail);

        $this->ModelTempTransaksiOffline->hapusdata($transofflineid);

        $json = [
          'sukses' => 'Transaksi ' . $transofflineid . ' berhasil disimpan',
          'cetaktransaksi' => site_url('/admin/transaksioffline/cetaktransaksi/' . $transofflineid)
        ];
      } else {
        $json = [
          'error' => [
            'dibayar' => $validation->getError('dibayar')
          ]
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf, tidak dapat diperoses');
    }
  }

  public function hapusTransaksi()
  {
    if ($this->request->isAJAX()) {
      $transofflineid = $this->request->getVar('transofflineid');
      $cekData = $this->ModelTransaksiOffline->find($transofflineid);
      if ($cekData) {
        $this->ModelDetailTransaksiOffline->hapusTransaksi($transofflineid);
        $this->ModelTransaksiOffline->delete($transofflineid);
        $json = [
          'sukses' => 'Transaksi dengan ID ' . $transofflineid . ' berhasil dihapus'
        ];
      } else {
        $json = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf, tidak dapat diperoses');
    }
  }

  public function edit($id)
  {
    $cekData = $this->ModelTransaksiOffline->cektransoffineid($id)->get();
    // var_dump($cekData);
    if ($cekData->getNumRows() > 0) {
      $dataTrans = $cekData->getRowArray();
      $data = [
        'title' => 'Edit Transaksi Offline',
        'transofflineid' => $dataTrans['transofflineid'],
        'namapembeli' => $dataTrans['namapembeli'],
        'tgltransaksi' => $dataTrans['tgltransaksi'],
      ];
      return view('admin/transaksioffline/edit', $data);
    } else {
      return redirect()->to(site_url('/admin/transaksioffline/index'));
    }
  }

  public function tampilDataDetail()
  {
    if ($this->request->isAJAX()) {
      $transofflineid = $this->request->getVar('transofflineid');
      $data = [
        'dataDetail' => $this->ModelDetailTransaksiOffline->tampilDetail($transofflineid)->getResultArray()
      ];
      $json = [
        'data' => view('admin/transaksioffline/datadetail', $data)
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function ambilDataBarang()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getVar('id');
      $cekData = $this->ModelDetailTransaksiOffline->ambilDataBarang($id)->getRowArray();
      if ($cekData) {
        $json = [
          'data' => [
            'namaproduk' => $cekData['namaproduk'],
            'ukuran' => $cekData['ukuran'],
            'hargajual' => $cekData['hargajual'],
            'jml' => $cekData['jml'],
            'subtotal' => $cekData['subtotal'],
          ]
        ];
      } else {
        $json = [
          'pesanerror' => 'Item tidak ditemukan'
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function simpandatadetail()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $hargajual = $this->request->getVar('hargajual');
      $jml = $this->request->getVar('jml');
      $ukuran = $this->request->getVar('ukuran');
      $transofflineid = $this->request->getVar('transofflineid');

      $subtotal = intval($jml * $hargajual);

      if ($ukuran == "") {
        $ukuran = NULL;
      }

      $simpan = $this->ModelDetailTransaksiOffline->insert([
        'produkid' => $produkid,
        'hargajual' => $hargajual,
        'jml' => $jml,
        'ukuran' => $ukuran,
        'transofflineid' => $transofflineid,
        'subtotal' => $subtotal,
      ]);

      if ($simpan) {
        $json = [
          'sukses' => 'Item berhasil ditambahkan'
        ];
        echo json_encode($json);
      }
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function ambilTotalBayar()
  {
    if ($this->request->isAJAX()) {
      $transofflineid = $this->request->getVar('transofflineid');
      $json = [
        'totalBayar' => 'Rp.' . number_format($this->ModelDetailTransaksiOffline->ambilTotalBayar($transofflineid), 0, ",", ".")
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function hapusdetailitem()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getVar('id');
      $cekData = $this->ModelDetailTransaksiOffline->find($id);
      if ($cekData) {
        $this->ModelDetailTransaksiOffline->delete($id);
        $json = [
          'sukses' => "Item berhasil dihapus"
        ];
      } else {
        $json = [
          'pesanerror' => "Data tidak ditemukan"
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function updatedatadetail()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getVar('id');
      $produkid = $this->request->getVar('produkid');
      $hargajual = $this->request->getVar('hargajual');
      $jml = $this->request->getVar('jml');
      $ukuran = $this->request->getVar('ukuran');
      $transofflineid = $this->request->getVar('transofflineid');

      $subtotal = intval($jml * $hargajual);

      if ($ukuran == "") {
        $ukuran = NULL;
      }

      $update = $this->ModelDetailTransaksiOffline->update($id, [
        'produkid' => $produkid,
        'hargajual' => $hargajual,
        'jml' => $jml,
        'ukuran' => $ukuran,
        'transofflineid' => $transofflineid,
        'subtotal' => $subtotal,
      ]);

      if ($update) {
        $json = [
          'sukses' => 'Item berhasil diubah'
        ];
        echo json_encode($json);
      }
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }
}
