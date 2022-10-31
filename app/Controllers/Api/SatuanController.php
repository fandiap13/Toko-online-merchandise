<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelSatuan;
use CodeIgniter\API\ResponseTrait;

class SatuanController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $ModelSatuan = new ModelSatuan();
        $dataKategori = $ModelSatuan->orderBy('namasatuan', 'ASC')->findAll();

        $data = [
            'status' => 200,
            'error' => null,
            'data' => $dataKategori
        ];
        return $this->respond($data, 200);
    }
}
