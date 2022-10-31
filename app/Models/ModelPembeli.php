<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembeli extends Model
{
    protected $table            = 'tbl_pembeli';
    protected $primaryKey       = 'pembeliid';
    protected $allowedFields    = [
        'pembeliid', 'emailpembeli', 'namapembeli', 'telppembeli', 'alamatpembeli', 'provinsipembeli', 'distrikpembeli', 'profilpembeli', 'level', 'passwordpembeli', 'token_daftar'
    ];
}
