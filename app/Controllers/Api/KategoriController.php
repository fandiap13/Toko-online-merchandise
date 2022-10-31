<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelKategori;
use CodeIgniter\API\ResponseTrait;

class KategoriController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $ModelKategori = new ModelKategori();
        $dataKategori = $ModelKategori->orderBy('namakategori', 'ASC')->findAll();

        $data = [
            'status' => 200,
            'error' => null,
            'data' => $dataKategori
        ];
        return $this->respond($data, 200);
    }
}
