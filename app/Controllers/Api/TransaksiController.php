<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksiOnline;
use App\Models\ModelTransaksiOnline;
use CodeIgniter\API\ResponseTrait;

class TransaksiController extends BaseController
{
    use ResponseTrait;

    protected $ModelTransaksi;
    protected $ModelDetailTransaksi;

    public function __construct()
    {
        $this->ModelTransaksi = new ModelTransaksiOnline();
        $this->ModelDetailTransaksi = new ModelDetailTransaksiOnline();
        session()->set('userid', 2);
    }

    public function index()
    {
        $dataTransaksi = $this->ModelTransaksi
            ->select('namapembeli, tbl_transaksionline.*')
            ->join('tbl_pembeli', 'tbl_transaksionline.pembeliid=tbl_pembeli.pembeliid')
            ->getWhere([
                'tbl_transaksionline.pembeliid' => session('userid'),
            ])->getResultArray();

        $data = [
            'status' => 200,
            'error' => null,
            'data' => $dataTransaksi
        ];
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $detailTransaksi = $this->ModelDetailTransaksi
            ->setTable('tbl_detail_transaksionline t')
            ->select('t.id, t.transonlineid, t.pembeliid, t.produkid, p.namaproduk, p.gambarutama, t.ukuran, s.namasatuan, k.namakategori, p.beratproduk, t.jml, t.subtotal')
            ->join('tbl_produk p', 't.produkid=p.produkid')
            ->join('tbl_satuan s', 'p.satuanid=s.satuanid')
            ->join('tbl_kategori k', 'p.kategoriid=k.kategoriid')
            ->getWhere([
                'transonlineid' => $id,
                'pembeliid' => session('userid')
            ]);
        $cekData = $detailTransaksi;
        if ($cekData->getNumRows() > 0) {
            $data = [
                'status' => 200,
                'error' => null,
                'data' => $detailTransaksi->getResultArray()
            ];

            return $this->respond($data, 200);
        } else {
            return $this->failNotFound('Transaksi dengan ID ' . $id . ' tidak ditemukan');
        }
    }
}
