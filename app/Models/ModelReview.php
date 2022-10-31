<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelReview extends Model
{
    protected $table            = 'tbl_review';
    protected $primaryKey       = 'reviewid';
    protected $allowedFields    = [
        'detailtransid', 'tanggal', 'review', 'ranting',
    ];
}
