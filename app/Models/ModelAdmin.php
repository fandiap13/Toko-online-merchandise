<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    protected $table            = 'tbl_admin';
    protected $primaryKey       = 'adminid';
    protected $allowedFields    = [
        'adminid', 'emailadmin', 'namaadmin', 'level', 'profiladmin'
    ];

    public function updateAdmin($email, $update)
    {
        return $this->table('tbl_admin')->where(['emailadmin' => $email])->update($update);
    }
}
