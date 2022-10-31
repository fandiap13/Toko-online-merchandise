<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSatuan extends Model
{
    protected $table            = 'tbl_satuan';
    protected $primaryKey       = 'satuanid';
    protected $allowedFields    = [
        'satuanid', 'namasatuan',
    ];
}
