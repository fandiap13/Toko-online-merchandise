<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGambarProduk extends Model
{
    protected $table            = 'tbl_gambar_produk';
    protected $primaryKey       = 'gambarprodukid';
    protected $allowedFields    = [
        'gambarprodukid', 'gambarproduk', 'produkid',
    ];

    public function cariProduk($id)
    {
        if ($id !== "") {
            return $this->table('tbl_gambar_produk')->where('produkid', $id);
        }
    }

    public function hapusGambar($id)
    {
        $this->table('tbl_gambar_produk')->where('produkid', $id);
        return $this->table('tbl_gambar_produk')->delete();
    }
}
