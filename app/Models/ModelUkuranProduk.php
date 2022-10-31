<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUkuranProduk extends Model
{
    protected $table            = 'tbl_ukuran_produk';
    protected $primaryKey       = 'ukuranprodukid';
    protected $allowedFields    = [
        'ukuranprodukid', 'produkid', 'ukuran', 'status', 'hargaproduk'
    ];

    public function cariProduk($id)
    {
        if ($id !== "") {
            return $this->table('tbl_ukuran_produk')->where('produkid', $id);
        }
    }

    public function hapusUkuran($id)
    {
        $this->table('tbl_ukuran_produk')->where('produkid', $id);
        return $this->table('tbl_ukuran_produk')->delete();
    }
}
