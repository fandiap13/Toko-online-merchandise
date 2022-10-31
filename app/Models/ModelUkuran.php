<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUkuran extends Model
{
    protected $table            = 'tbl_ukuran';
    protected $primaryKey       = 'ukuranid';
    protected $allowedFields    = [
        'ukuranid', 'namaukuran',
    ];
}
