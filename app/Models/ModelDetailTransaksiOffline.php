<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailTransaksiOffline extends Model
{
    protected $table            = 'tbl_detail_transaksioffline';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'transofflineid', 'produkid', 'hargajual', 'jml', 'ukuran', 'subtotal'
    ];

    public function tampilDetail($id)
    {
        return $this->table('tbl_detail_transaksioffline')
            ->join('tbl_produk', 'tbl_detail_transaksioffline.produkid=tbl_produk.produkid')
            ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
            ->where('transofflineid', $id)->get();
    }

    public function hapusTransaksi($id)
    {
        $this->table('tbl_detail_transaksioffline')->where('transofflineid', $id);
        return $this->table('tbl_detail_transaksioffline')->delete();
    }

    public function ambilDataBarang($id)
    {
        return $this->table('tbl_detail_transaksioffline')
            ->join('tbl_produk', 'tbl_detail_transaksioffline.produkid=tbl_produk.produkid')
            ->where('id', $id)->get();
    }

    public function ambilTotalBayar($id)
    {
        $data = $this->table('tbl_detail_transaksioffline')->where('transofflineid', $id)->get()->getResultArray();
        $totalBayar = 0;
        foreach ($data as $d) {
            $totalBayar += $d['subtotal'];
        }
        return $totalBayar;
    }
}
