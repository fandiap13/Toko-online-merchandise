<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelGambarProduk;
use App\Models\ModelProduk;
use App\Models\ModelUkuranProduk;
use CodeIgniter\API\ResponseTrait;

class ProdukController extends BaseController
{
    use ResponseTrait;

    protected $ModelProduk;
    protected $ModelGambarProduk;
    protected $ModelUkuranProduk;

    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelGambarProduk = new ModelGambarProduk();
        $this->ModelUkuranProduk = new ModelUkuranProduk();
    }

    public function index()
    {
        $dataProduk = $this->ModelProduk->orderBy('produkid', 'ASC')->findAll();
        $data = [
            'status' => 200,
            'error' => null,
            'data' => $dataProduk
        ];
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $dataProduk = $this->ModelProduk
            ->select('tbl_produk.produkid, tglpost, namaproduk, gambarutama, namakategori, namasatuan, deskripsiproduk, beratproduk, hargaproduk, statusproduk')
            ->join('tbl_kategori', 'tbl_produk.kategoriid=tbl_kategori.kategoriid')
            ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
            ->where('tbl_produk.produkid', $id)->get()->getRowArray();
        $dataGambar = $this->ModelGambarProduk->select('gambarprodukid, gambarproduk')
            ->where('produkid', $id)->get()->getResultArray();
        $dataUkuran = $this->ModelUkuranProduk
            ->select('ukuranprodukid, ukuran, status, hargaproduk')
            ->getWhere([
                'produkid' => $id
            ])->getResultArray();

        if ($dataProduk) {
            return $this->respond([
                'status' => 200,
                'error' => null,
                'data' => [
                    'produkid' => $dataProduk['produkid'],
                    'tglpost' => $dataProduk['tglpost'],
                    'namaproduk' => $dataProduk['namaproduk'],
                    'gambarutama' => $dataProduk['gambarutama'],
                    'namakategori' => $dataProduk['namakategori'],
                    'namasatuan' => $dataProduk['namasatuan'],
                    'deskripsiproduk' => $dataProduk['deskripsiproduk'],
                    'beratproduk' => $dataProduk['beratproduk'],
                    'hargaproduk' => $dataProduk['hargaproduk'],
                    'statusproduk' => $dataProduk['statusproduk'],
                    'listGambar' => $dataGambar,
                    'listUkuran' => $dataUkuran,
                ],
            ], 200);
        } else {
            return $this->failNotFound('Data Produk tidak ditemukan', 404);
        }
    }
}
