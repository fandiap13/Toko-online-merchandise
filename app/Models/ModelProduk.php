<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduk extends Model
{
    protected $table            = 'tbl_produk';
    protected $primaryKey       = 'produkid';
    protected $allowedFields    = [
        'produkid', 'tglpost', 'namaproduk', 'kategoriid', 'satuanid', 'deskripsiproduk', 'hargaproduk', 'beratproduk', 'statusproduk', 'gambarutama'
    ];
}
