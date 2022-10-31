<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table            = 'tbl_kategori';
    protected $primaryKey       = 'kategoriid';
    protected $allowedFields    = [
        'kategoriid', 'namakategori',
    ];
}
