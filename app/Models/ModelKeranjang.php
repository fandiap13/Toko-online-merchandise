<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKeranjang extends Model
{
    protected $table            = 'tbl_keranjang';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'pembeliid', 'produkid', 'ukuranprodukid', 'jml',
    ];

    public function hapusKeranjang($pembeliid)
    {
        $this->table('tbl_keranjang')->where('pembeliid', $pembeliid);
        return $this->table('tbl_keranjang')->delete();
    }

    public function hapusItem($ukuranprodukid)
    {
        $this->table('tbl_keranjang')->where('ukuranprodukid', $ukuranprodukid);
        return $this->table('tbl_keranjang')->delete();
    }
}
