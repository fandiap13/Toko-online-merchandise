<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelPembeli;
use CodeIgniter\API\ResponseTrait;
use Exception;

class Otentikasi extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $validation = \Config\Services::validation();
        $valid = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Silahkan masukkan email',
                    'valid_email' => 'Silahkan masukkan email yang valid'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukkan password',
                ]
            ]
        ];

        $validation->setRules($valid);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $modelOtentikasi = new ModelPembeli();
        $emailpembeli = $this->request->getVar('email');
        $passwordpembeli = $this->request->getVar('password');

        $data = $modelOtentikasi->getWhere([
            'emailpembeli' => $emailpembeli,
        ])->getRowArray();
        if (!$data) {
            throw new Exception("Data otentikasi tidak ditemukan");
        }

        if (!password_verify($passwordpembeli, $data['passwordpembeli'])) {
            return $this->fail('Password salah');
        }

        helper('jwt');
        $response = [
            'message' => "Otentikasi berhasil dilakukan",
            'data' => $data,
            'acces_token' => createJWT($emailpembeli),
        ];
        return $this->respond($response);
    }
}
