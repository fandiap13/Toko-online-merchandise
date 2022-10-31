<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSupport extends Model
{
    protected $table            = 'tbl_support';
    protected $primaryKey       = 'supportid';
    protected $allowedFields    = [
        'supported', 'gambar', 'linkwebsite', 'settingid',
    ];
}
