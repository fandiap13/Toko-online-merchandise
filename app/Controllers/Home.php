<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelProduk;
use App\Models\ModelUkuranProduk;

class Home extends BaseController
{
    protected $ModelProduk;
    protected $ModelKategori;

    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelKategori = new ModelKategori();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $data = [
            'title' => 'Beranda',
            'dataproduk' => $this->ModelProduk->select('namaproduk, produkid, gambarutama, namasatuan, hargaproduk')
                ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
                ->limit(6)
                ->get()->getResultArray(),
            'bestseller' => $db->query("SELECT tbl_detail_transaksionline.produkid, namasatuan, hargaproduk, namaproduk, gambarutama, SUM(jml) AS jumlah_terbanyak FROM tbl_detail_transaksionline INNER JOIN tbl_produk ON tbl_detail_transaksionline.produkid = tbl_produk.produkid INNER JOIN tbl_satuan ON tbl_produk.satuanid=tbl_satuan.satuanid GROUP BY tbl_detail_transaksionline.produkid ORDER BY jumlah_terbanyak DESC limit 6")->getResultArray()
            // 'datakategori' => $this->ModelKategori->findAll(),
        ];
        return view('index', $data);
    }

    public function daftar_produk()
    {
        $daftarproduk = $this->ModelProduk->select('namaproduk, produkid, gambarutama, namasatuan, hargaproduk')
            ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
            ->paginate(9, 'produk');
        $nohalaman = $this->request->getVar('page_produk') ? $this->request->getVar('page_produk') : 1;
        $data = [
            'title' => 'Daftar Produk',
            'daftarproduk' => $daftarproduk,
            'nohalaman' => $nohalaman,
            'pager' => $this->ModelProduk->pager,
        ];
        return view('view_daftarproduk', $data);
    }

    public function detailproduk($id)
    {
        $cekdata = $this->ModelProduk
            ->join('tbl_kategori', 'tbl_produk.kategoriid=tbl_kategori.kategoriid')
            ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
            ->where('produkid', $id)->get()->getRowArray();
        if ($cekdata) {
            $data = [
                'title' => 'Detail Produk',
                'produk' => $cekdata
            ];
            return view('view_detailproduk', $data);
        } else {
            return redirect()->to(site_url('/'));
        }
    }

    public function hargaukuranproduk()
    {
        if ($this->request->isAJAX()) {
            $ukuranprodukid = $this->request->getVar('ukuranprodukid');
            $modelukuranproduk = new ModelUkuranProduk();
            $cekdata = $modelukuranproduk->find($ukuranprodukid);
            if ($cekdata) {
                $json = [
                    'hargaproduk' => "Rp " . number_format($cekdata['hargaproduk'], 0, ',', '.')
                ];
            } else {
                $json = [
                    'error' => 'Data tidak ditemukan'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
