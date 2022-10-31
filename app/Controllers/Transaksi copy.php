<?php

namespace App\Controllers;

use App\Models\ModelDetailTransaksiOnline;
use App\Models\ModelKategori;
use App\Models\ModelProduk;
use App\Models\ModelKeranjang;
use App\Models\ModelPembeli;
use App\Models\ModelTransaksiOnline;
use App\Models\ModelUkuranProduk;

class Transaksi extends BaseController
{
  protected $ModelProduk;
  protected $ModelKategori;
  protected $ModelKeranjang;
  protected $ModelDetailTransaksiOnline;
  protected $ModelTransaksiOnline;
  protected $ModelUkuranProduk;
  protected $ModelPembeli;

  public function __construct()
  {
    $this->ModelProduk = new ModelProduk();
    $this->ModelKategori = new ModelKategori();
    $this->ModelKeranjang = new ModelKeranjang();
    $this->ModelDetailTransaksiOnline = new ModelDetailTransaksiOnline();
    $this->ModelUkuranProduk = new ModelUkuranProduk();
    $this->ModelTransaksiOnline = new ModelTransaksiOnline();
    $this->ModelPembeli = new ModelPembeli();
  }

  public function jmlkeranjang()
  {
    if ($this->request->isAJAX()) {
      $pembeliid = session()->get("LoggedUserData")['userid'];
      $jmlkeranjang = $this->ModelKeranjang->where('pembeliid', $pembeliid)->get()->getNumRows();
      $json = [
        'jmlkeranjang' => $jmlkeranjang
      ];
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function tambahkeranjang()
  {
    if ($this->request->isAJAX()) {
      $pembeliid = session()->get("LoggedUserData")['userid'];
      $produkid = $this->request->getVar('produkid');
      $ukuranid = $this->request->getVar('ukuranid');

      // jika ukuran kosong maka ukuranid produk tidak ada maka ukuranid diubah menjadi null
      if ($ukuranid == "") {
        $ukuranid = NULL;
      }

      // mengecek produkid apakah sudah benar
      $cekdata = $this->ModelProduk->find($produkid);
      if ($cekdata) {
        $keranjang = $this->ModelKeranjang->where('produkid', $produkid)->where('pembeliid', $pembeliid);
        $cekkeranjang = $keranjang->countAllResults();

        // jika produkid pada keranjang == kosong
        if ($cekkeranjang == 0) {
          $produk = $this->ModelProduk->where("produkid", $produkid)->where('statusproduk', 1);
          $cekKetersediaan = $produk->countAllResults();
          // cek ketersediaan produk
          if ($cekKetersediaan > 0) {
            $simpan = [
              'produkid' => $produkid,
              'jml' => 1,
              'ukuranprodukid' => $ukuranid,
              'pembeliid' => $pembeliid
            ];
            $this->ModelKeranjang->insert($simpan);
            $json = [
              'sukses' => 'Produk berhasil ditambahkan'
            ];
          } else {
            $json = [
              'pesanerror' => 'Produk tidak tersedia/habis'
            ];
          }
        }
        // jika keranjang tidak kosong
        else {

          // cek ketersediaan produk berdasarkan ukuran produkid
          if ($ukuranid !== null) {
            $cekStatus = $this->ModelUkuranProduk
              ->where('produkid', $produkid)
              ->where('ukuranprodukid', $ukuranid)
              ->where('status', 1)->countAllResults();
            // cek ketersediaan produk berdasarkan status produk
          } else {
            $cekStatus = $this->ModelProduk
              ->where('produkid', $produkid)
              ->where('statusproduk', 1)->countAllResults();
          }

          if ($cekStatus > 0) {
            $datakeranjang = $this->ModelKeranjang
              ->where('produkid', $produkid)
              ->where('pembeliid', $pembeliid)
              ->where('ukuranprodukid', $ukuranid)
              ->get()->getRowArray();
            // jika ukuran ada yg sama
            if ($datakeranjang) {
              $id = $datakeranjang['id'];
              $ubah = [
                'jml' => $datakeranjang['jml'] + 1,
              ];
              $this->ModelKeranjang->update($id, $ubah);
              $json = [
                'sukses' => 'Produk berhasil ditambahkan'
              ];

              // jika ukuran tidak sama
            } else {
              $simpan = [
                'produkid' => $produkid,
                'jml' => 1,
                'ukuranprodukid' => $ukuranid,
                'pembeliid' => $pembeliid
              ];
              $this->ModelKeranjang->insert($simpan);
              $json = [
                'sukses' => 'Produk berhasil ditambahkan'
              ];
            }
          } else {
            $json = [
              'pesanerror' => 'Produk tidak tersedia/habis'
            ];
          }
        }
      }
      // jika produk tidak ada
      else {
        $json = [
          'pesanerror' => 'Produk tidak ditemukan'
        ];
      }

      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function keranjang()
  {
    $pembeliid = session()->get("LoggedUserData")['userid'];
    $keranjang = $this->ModelKeranjang
      ->join('tbl_produk', 'tbl_keranjang.produkid=tbl_produk.produkid')
      // ->where('statusproduk', 1)
      ->where('pembeliid', $pembeliid)->get();
    $cekdata = $keranjang;
    if ($cekdata->getNumRows() > 0) {
      $data = [
        'title' => 'Keranjang Ku',
        'pembeli' => $this->ModelPembeli->find(session('LoggedUserData')['userid'])
      ];
      return view('view_keranjang', $data);
    } else {
      session()->setFlashData("msg", 'error#Keranjang kosong..');
      return redirect()->to(site_url('/'));
    }
  }

  public function datakeranjang()
  {
    if ($this->request->isAJAX()) {
      $pembeliid = session()->get("LoggedUserData")['userid'];
      $keranjang = $this->ModelKeranjang->join('tbl_produk', 'tbl_keranjang.produkid=tbl_produk.produkid')
        // ->where('statusproduk', 1)
        ->where('pembeliid', $pembeliid)->get()->getResultArray();
      $data = [
        'datakeranjang' => $keranjang,
      ];
      $json = [
        'data' => view('datakeranjang', $data)
      ];
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function hapuslist()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getVar('id');
      $pembeliid = session()->get("LoggedUserData")['userid'];
      $cekdata = $this->ModelKeranjang->where('id', $id)->where('pembeliid', $pembeliid)->get()->getRowArray();
      if ($cekdata) {
        $this->ModelKeranjang->delete($id);
        $json = [
          'sukses' => 'Data berhasil dihapus'
        ];
      } else {
        $json = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function ubahjmlkeranjang()
  {
    if ($this->request->isAJAX()) {
      $pembeliid = session()->get("LoggedUserData")['userid'];
      $id = $this->request->getVar('id');
      $jml = $this->request->getVar('jml');
      $cekdata = $this->ModelKeranjang->where('id', $id)->where('pembeliid', $pembeliid)->get()->getRowArray();
      if ($cekdata) {
        $ubah = [
          'jml' => $jml,
        ];
        $this->ModelKeranjang->update($id, $ubah);
        $json = [
          'sukses' => 'Data berhasil diubah'
        ];
      } else {
        $json = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function pembayaranMidtrans()
  {
    if ($this->request->isAJAX()) {
      $pembeliid = $this->request->getVar('pembeliid');
      $distrik = $this->request->getVar('distrik');
      $kodepos = $this->request->getVar('kodepos');
      $alamat = $this->request->getVar('alamat');
      $notelp = $this->request->getVar('notelp');
      $ongkir = $this->request->getVar('ongkir');

      $datakeranjang = $this->ModelKeranjang
        ->join('tbl_produk', 'tbl_produk.produkid=tbl_keranjang.produkid')
        ->where('pembeliid', $pembeliid)->get();
      $cekdata = $datakeranjang;
      if ($cekdata->getNumRows() > 0) {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = getenv('API_KEY_MIDTRANS');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $fieldDetail = [];
        $totalbayar = 0;
        $jmldatakeranjang = $cekdata->getNumRows();
        $no = 1;
        foreach ($datakeranjang->getResultArray() as $row) {
          if ($row['statusproduk'] == 1) {
            if ($row['ukuranprodukid'] == null) {
              $dataproduk = $this->ModelProduk->find($row['produkid']);
              $hargajual = $dataproduk['hargaproduk'];
              $fieldDetail[] = [
                'id' => $no,
                'quantity' => $row['jml'],
                'price' => $hargajual,
                'name' => $row['namaproduk'],
              ];
            } else {
              $dataukuran = $this->ModelUkuranProduk
                ->where('ukuranprodukid', $row['ukuranprodukid'])
                ->where('status', 1)
                ->get()->getRowArray();
              if ($dataukuran) {
                $hargajual = $dataukuran['hargaproduk'];
                $fieldDetail[] = [
                  'id' => $no,
                  'quantity' => $row['jml'],
                  'price' => $hargajual,
                  'name' => $row['namaproduk'] . ' ukuran: ' . $dataukuran['ukuran'],
                ];
              }
            }
          }
          $totalbayar += $hargajual;
          $no++;
        }

        // penambahan ongkir
        $fieldDetail[] = [
          'id' => $no,
          'quantity' =>  1,
          'price' => $ongkir,
          'name' => 'Ongkir',
        ];

        $datapembeli = $this->ModelPembeli->find($pembeliid);
        $namapembeli = $datapembeli['namapembeli'];

        $jmllolos = (count($fieldDetail) - 1);  // dikurangi karena ada penambahan ongkir
        if ($jmllolos == $jmldatakeranjang) {
          $billing_address = array(
            'first_name'   => $namapembeli,
            'address'      => $alamat,
            'city'         => $distrik,
            'postal_code'  => $kodepos,
            'phone'        => $notelp,
          );

          // Populate customer's shipping address
          $shipping_address = array(
            'first_name'   => $namapembeli,
            'address'      => $alamat,
            'city'         => $distrik,
            'postal_code'  => $kodepos,
            'phone'        => $notelp,
          );

          // Populate customer's info
          $customer_details = array(
            'first_name'       => $namapembeli,
            'email'            => $datapembeli['emailpembeli'],
            'phone'            => $notelp,
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
          );

          $params = [
            'transaction_details' => array(
              'order_id' => rand(),
              'gross_amount' => $totalbayar,  // total pembayaran
            ),
            'item_details'        => $fieldDetail,
            'customer_details'    => $customer_details
          ];

          $json = [
            'snapToken' => \Midtrans\Snap::getSnapToken($params)
          ];
        } else {
          $json = [
            'pesanerror' => 'Terdapat ' . intval($jmldatakeranjang - count($fieldDetail)) . ' produk tidak tersedia/habis'
          ];
        }
      } else {
        $json = [
          'keranjangkosong' => 'Keranjang Kosong!'
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function checkout()
  {
    if ($this->request->isAJAX()) {
      $pembeliid = $this->request->getVar('pembeliid');
      $totalberat = $this->request->getVar('totalberat');
      $provinsi = $this->request->getVar('provinsi');
      $distrik = $this->request->getVar('distrik');
      $tipe = $this->request->getVar('tipe');
      $kodepos = $this->request->getVar('kodepos');
      $ekspedisi = $this->request->getVar('ekspedisi');
      $paket = $this->request->getVar('paket');
      $ongkir = $this->request->getVar('ongkir');
      $estimasi = $this->request->getVar('estimasi');
      $totalpembelian = $this->request->getVar('totalpembelian');
      $totalbayar = $this->request->getVar('totalbayar');
      $alamat = $this->request->getVar('alamat');
      $notelp = $this->request->getVar('notelp');

      $order_id = $this->request->getVar('order_id');
      $payment_type = $this->request->getVar('payment_type');
      $waktupembayaran = $this->request->getVar('waktupembayaran');
      $statuspembayaran = $this->request->getVar('statuspembayaran');
      $pdf_url = $this->request->getVar('pdf_url');
      $snapToken = $this->request->getVar('snapToken');

      $datakeranjang = $this->ModelKeranjang
        ->join('tbl_produk', 'tbl_produk.produkid=tbl_keranjang.produkid')
        ->where('pembeliid', $pembeliid)->get();
      $cekdata = $datakeranjang;
      if ($cekdata->getNumRows() > 0) {
        $transonlineid = $this->ModelTransaksiOnline->transonlineid(date('Y-m-d'));
        $simpanTransaksi = [
          'transonlineid' => $transonlineid,
          'pembeliid' => $pembeliid,
          'provinsi' => $provinsi,
          'distrik' => $distrik,
          'tipe' => $tipe,
          'kodepos' => $kodepos,
          'ekspedisi' => $ekspedisi,
          'paket' => $paket,
          'ongkir' => $ongkir,
          'estimasi' => $estimasi,
          'totalpembelian' => $totalpembelian,
          'totalbayar' => $totalbayar,
          'totalberat' => $totalberat,
          'alamat' => $alamat,
          'notelp' => $notelp,
          'order_id' => $order_id,
          'payment_type' => $payment_type,
          'tgltransaksi' => $waktupembayaran,
          'statuspembayaran' => $statuspembayaran,
          'pdf_url' => $pdf_url,
          'snapToken' => $snapToken,
          'statuspembelian' => 'pending',
        ];

        $fieldDetail = [];
        $jmldatakeranjang = $cekdata->getNumRows();
        foreach ($datakeranjang->getResultArray() as $row) {
          if ($row['statusproduk'] == 1) {
            if ($row['ukuranprodukid'] == null) {
              $dataproduk = $this->ModelProduk->find($row['produkid']);
              $ukuran = null;
              $hargajual = $dataproduk['hargaproduk'];
              $subtotal = intval($hargajual * $row['jml']);
              $fieldDetail[] = [
                'pembeliid' => $row['pembeliid'],
                'produkid' => $row['produkid'],
                'jml' => $row['jml'],
                'ukuran' => $ukuran,
                'hargajual' => $hargajual,
                'subtotal' => $subtotal,
                'transonlineid' => $transonlineid,
              ];
            } else {
              $dataukuran = $this->ModelUkuranProduk
                ->where('ukuranprodukid', $row['ukuranprodukid'])
                ->where('status', 1)
                ->get()->getRowArray();
              if ($dataukuran) {
                $ukuran = $dataukuran['ukuran'];
                $hargajual = $dataukuran['hargaproduk'];
                $subtotal = intval($hargajual * $row['jml']);
                $fieldDetail[] = [
                  'pembeliid' => $row['pembeliid'],
                  'produkid' => $row['produkid'],
                  'jml' => $row['jml'],
                  'ukuran' => $ukuran,
                  'hargajual' => $hargajual,
                  'subtotal' => $subtotal,
                  'transonlineid' => $transonlineid,
                ];
              }
            }
          }
        }

        if (count($fieldDetail) == $jmldatakeranjang) {
          $this->ModelTransaksiOnline->insert($simpanTransaksi);
          $this->ModelDetailTransaksiOnline->insertBatch($fieldDetail);
          $this->ModelKeranjang->hapusKeranjang($pembeliid);
          $json = [
            'sukses' => 'Checkout berhasil'
          ];
        } else {
          $json = [
            'pesanerror' => 'Terdapat ' . intval($jmldatakeranjang - count($fieldDetail)) . ' produk tidak tersedia/habis'
          ];
        }
      } else {
        $json = [
          'keranjangkosong' => 'Keranjang Kosong!'
        ];
      }
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function daftar_transaksi()
  {
    $pembeliid = session()->get("LoggedUserData")['userid'];
    $cektransaksi = $this->ModelTransaksiOnline->daftarTransaksi($pembeliid)->get();
    if ($cektransaksi->getNumRows() > 0) {

      // paginasi
      $datatransaksi = $this->ModelTransaksiOnline->daftarTransaksi($pembeliid)->paginate(5, 'daftar-transaksi');

      // Set your Merchant Server Key
      \Midtrans\Config::$serverKey = getenv('API_KEY_MIDTRANS');
      // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
      \Midtrans\Config::$isProduction = false;
      // Set sanitization on (default)
      \Midtrans\Config::$isSanitized = true;
      // Set 3DS transaction for credit card to true
      \Midtrans\Config::$is3ds = true;

      $cekTransaksi = $datatransaksi;
      foreach ($cekTransaksi as $d) {
        // Update status transaksi
        $status = \Midtrans\Transaction::status($d['order_id']);
        $this->ModelTransaksiOnline->update($d['transonlineid'], [
          'statuspembayaran' => $status->transaction_status
        ]);
      }

      $cek = $this->ModelTransaksiOnline->select('transonlineid')
        ->where('pembeliid', $pembeliid)
        ->whereIn('statuspembayaran', ['cancel', 'failure', 'expire'])
        ->orderBy('tgltransaksi', 'DESC')
        ->get()->getResultArray();
      // dd($cek);
      foreach ($cek as $row) {
        $this->ModelTransaksiOnline->update($row['transonlineid'], [
          'statuspembelian' => 'gagal'
        ]);
      }

      // hapus data transaksi yang status pembayarannya cancel/failure
      // $cek = $this->ModelTransaksiOnline
      //   ->where('pembeliid', $pembeliid)
      //   ->whereIn('statuspembayaran', ['cancel', 'failure', 'expire'])
      //   ->get()->getResultArray();
      // foreach ($cek as $d) {
      //   $this->ModelDetailTransaksiOnline->hapusDetailTransaksi($d['transonlineid']);
      //   $this->ModelTransaksiOnline->delete($d['transonlineid']);
      // }

      $nohalaman = $this->request->getVar('page_daftar-transaksi') ? $this->request->getVar('page_daftar-transaksi') : 1;

      $data = [
        'title' => 'Daftar Transaksi',
        'datatransaksi' => $datatransaksi,
        'nohalaman' => $nohalaman,
        'pager' => $this->ModelTransaksiOnline->pager,
      ];
      return view('view_daftartransaksi', $data);
    } else {
      session()->setFlashData("msg", 'error#Daftar transaksi kosong..');
      return redirect()->to(site_url('/'));
    }
  }

  public function detail_transaksi($transonlineid)
  {
    $pembeliid = session()->get("LoggedUserData")['userid'];
    $cekid = $this->ModelTransaksiOnline
      ->cektransonlineid($pembeliid, $transonlineid)->get()->getRowArray();
    if ($cekid) {
      $transonlineid = $cekid['transonlineid'];

      // Set your Merchant Server Key
      \Midtrans\Config::$serverKey = getenv('API_KEY_MIDTRANS');
      // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
      \Midtrans\Config::$isProduction = false;
      // Set sanitization on (default)
      \Midtrans\Config::$isSanitized = true;
      // Set 3DS transaction for credit card to true
      \Midtrans\Config::$is3ds = true;

      // Update status
      $cekubah = $this->ModelTransaksiOnline->dataTransaksiPembeli($pembeliid, $transonlineid)->get()->getRowArray();
      $status = \Midtrans\Transaction::status($cekubah['order_id']);
      // dd($status);

      $this->ModelTransaksiOnline->update($transonlineid, [
        'statuspembayaran' => $status->transaction_status
      ]);

      $datatransaksi = $this->ModelTransaksiOnline->find($transonlineid);
      if (
        $datatransaksi['statuspembayaran'] == 'cancel' || $datatransaksi['statuspembayaran'] == 'failure' || $datatransaksi['statuspembayaran'] == 'expire'
      ) {
        $this->ModelTransaksiOnline->update($transonlineid, [
          'statuspembelian' => 'gagal'
        ]);
      }

      // hapus transaksi jika status pembayaran cancel/failure
      // $cekhapus = $this->ModelTransaksiOnline
      //   ->where('transonlineid', $transonlineid)
      //   ->whereIn('statuspembayaran', ['cancel', 'failure', 'expire'])
      //   ->get()->getRowArray();
      // // $cekhapus = $this->ModelTransaksiOnline->query("SELECT * FROM tbl_admin WHERE transonlineid='$transonlineid' OR ");
      // if ($cekhapus) {
      //   $this->ModelDetailTransaksiOnline->hapusDetailTransaksi($cekhapus['transonlineid']);
      //   $this->ModelTransaksiOnline->delete($cekhapus['transonlineid']);
      // }

      // dd($status);
      $datatransaksi = $this->ModelTransaksiOnline->dataTransaksiPembeli($pembeliid, $transonlineid)->get();
      $datadetail = $this->ModelDetailTransaksiOnline->detailTransaksi($pembeliid, $transonlineid)->get();

      $data = [
        'title' => 'Detail Transaksi',
        'datatransaksi' => $datatransaksi->getRowArray(),
        'detailtransaksi' => $datadetail->getResultArray(),
        'statuspayment' => $status
      ];
      return view('view_detailtransaksi', $data);
    } else {
      return redirect()->to(site_url('/daftar-transaksi'));
    }
  }

  public function cetak_transaksi($id)
  {
    $pembeliid = session()->get("LoggedUserData")['userid'];
    $cekData = $this->ModelTransaksiOnline
      ->join('tbl_pembeli', 'tbl_transaksionline.pembeliid=tbl_pembeli.pembeliid')
      ->getWhere(
        [
          'sha(transonlineid)' => $id,
          'tbl_transaksionline.pembeliid' => $pembeliid
        ]
      )->getRowArray();
    if ($cekData != null) {
      // Set your Merchant Server Key
      \Midtrans\Config::$serverKey = getenv('API_KEY_MIDTRANS');
      // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
      \Midtrans\Config::$isProduction = false;
      // Set sanitization on (default)
      \Midtrans\Config::$isSanitized = true;
      // Set 3DS transaction for credit card to true
      \Midtrans\Config::$is3ds = true;

      $status = \Midtrans\Transaction::status($cekData['order_id']);

      $data = [
        'id' => $cekData['transonlineid'],
        'tanggal' => $cekData['tgltransaksi'],
        'namapembeli' => $cekData['namapembeli'],
        'datatransaksi' => $cekData,
        'detailbarang' => $this->ModelDetailTransaksiOnline->detailItem($id)->get(),
        'statuspayment' => $status
      ];
      return view('cetaktransaksi', $data);
    } else {
      return redirect()->to(site_url('/daftar-transaksi'));
    }
  }

  public function hapusTransaksi()
  {
    if ($this->request->isAJAX()) {
      $transonlineid = $this->request->getVar('transonlineid');
      $cekID = $this->ModelTransaksiOnline->find($transonlineid);
      if ($cekID) {
        $this->ModelDetailTransaksiOnline->hapusDetailTransaksi($transonlineid);
        $this->ModelTransaksiOnline->delete($transonlineid);
        $json = [
          'sukses' => 'Data transaksi ' . $transonlineid . ' berhasil dihapus'
        ];
      } else {
        $json = [
          'error' => 'Data transaksi dengan ' . $transonlineid . ' tidak ditemukan'
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }
}
