<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGambarReview extends Model
{
    protected $table            = 'tbl_gambar_review';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'reviewid', 'gambar',
    ];
}
