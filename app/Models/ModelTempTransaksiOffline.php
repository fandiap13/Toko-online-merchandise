<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTempTransaksiOffline extends Model
{
    protected $table            = 'tbl_temp_transaksioffline';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'transofflineid', 'produkid', 'hargajual', 'jml', 'ukuran', 'subtotal'
    ];

    public function tampilTemp($id)
    {
        return $this->table('tbl_temp_transaksioffline')
            ->join('tbl_produk', 'tbl_temp_transaksioffline.produkid=tbl_produk.produkid')
            ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
            ->where('transofflineid', $id)->get();
    }

    public function hapusdata($id)
    {
        $this->table('tbl_temp_transaksioffline')->where('transofflineid', $id);
        return $this->table('tbl_temp_transaksioffline')->delete();
    }
}
