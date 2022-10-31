<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailTransaksiOnline extends Model
{
    protected $table            = 'tbl_detail_transaksionline';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'pembeliid', 'transonlineid', 'produkid', 'hargajual', 'jml', 'ukuran', 'subtotal'
    ];

    // public function hapusDetail($pembeliid)
    // {
    //     $this->table('tbl_detail_transaksionline')->where('pembeliid', $pembeliid);
    //     return $this->table('tbl_detail_transaksionline')->delete();
    // }

    public function hapusDetailTransaksi($transonlineid)
    {
        $this->table('tbl_detail_transaksionline')->where('transonlineid', $transonlineid);
        return $this->table('tbl_detail_transaksionline')->delete();
    }

    public function detailTransaksi($pembeliid, $transonlineid)
    {
        return $this->table('tbl_detail_transaksionline')->join('tbl_produk', 'tbl_detail_transaksionline.produkid=tbl_produk.produkid')
            ->join('tbl_satuan', 'tbl_satuan.satuanid=tbl_produk.satuanid')
            ->where('transonlineid', $transonlineid)
            ->where('pembeliid', $pembeliid);
    }

    public function detailItem($transonlineid)
    {
        return $this->table('tbl_detail_transaksionline')
            ->join('tbl_produk', 'tbl_detail_transaksionline.produkid=tbl_produk.produkid')
            ->join('tbl_satuan', 'tbl_satuan.satuanid=tbl_produk.satuanid')
            ->where('sha1(transonlineid)', $transonlineid);
    }
}
