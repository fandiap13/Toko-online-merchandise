<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSetting extends Model
{
    protected $table            = 'tbl_setting';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'namawebsite', 'logowebsite', 'alamattoko', 'provinsi', 'distrik', 'judulcarousel', 'gambarcarousel', 'deskripsicarousel', 'lokasigmap', 'tentangkami', 'kontak', 'supported', 'favicon'
    ];
}
