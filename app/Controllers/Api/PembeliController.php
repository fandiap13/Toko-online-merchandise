<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelPembeli;
use CodeIgniter\API\ResponseTrait;

class PembeliController extends BaseController
{
    use ResponseTrait;

    protected $ModelUser;

    public function __construct()
    {
        $this->ModelUser = new ModelPembeli();
    }

    public function show($id = null)
    {
        $dataUser = $this->ModelUser->find($id);
        if ($dataUser) {
            $data = [
                'status' => 200,
                'error' => null,
                'data' => $dataUser
            ];
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound('User tidak dapat ditemukan');
        }
    }

    public function update($id = null)
    {
        $dataUser = $this->ModelUser->find($id);
        if ($dataUser) {
            $namapembeli = $this->request->getVar('namapembeli');
            $telppembeli = $this->request->getVar('telppembeli');
            $alamatpembeli = $this->request->getVar('alamatpembeli');
            $provinsipembeli = $this->request->getVar('provinsipembeli');
            $distrikpembeli = $this->request->getVar('distrikpembeli');

            $validation = \Config\Services::validation();

            if (!str_starts_with($telppembeli, '08')) {
                $data = [
                    'errors' => [
                        'notelp' => 'No telp tidak valid (aturan : 08XXXXXXXXXX)'
                    ]
                ];
                return $this->fail($data);
            }

            $valid = $this->validate([
                'profilpembeli' => [
                    'label' => 'Foto profil',
                    'rules' => 'max_size[profilpembeli,2048]|is_image[profilpembeli]|mime_in[profilpembeli,image/png,image/jpg,image/jpeg]',
                    'errors' => [
                        'max_size' => '{field} maksimal 2 mb',
                        'is_image' => '{field} harus gambar',
                        'mime_in' => 'Format gambar harus jpg/jpeg/png'
                    ]
                ],
                'namapembeli' => [
                    'label' => 'Nama',
                    'rules' => 'required|max_length[150]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'max_length' => '{field} maksimal terdiri dari 150 karakter'
                    ],
                ],
                'telppembeli' => [
                    'label' => 'No. telp',
                    'rules' => 'required|max_length[13]|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'max_length' => '{field} maksimal terdiri dari 13 karakter',
                        'numeric' => '{field} harus dalam bentuk angka'
                    ],
                ],
                'alamatpembeli' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'provinsipembeli' => [
                    'label' => 'Provinsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'distrikpembeli' => [
                    'label' => 'Kota / Kabupaten',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if ($valid) {
                $gambar = $this->request->getFile('profilpembeli');
                $gambarLama = $dataUser['profilpembeli'];
                if ($gambar->getError() !== 4) {
                    if ($gambarLama !== null && $gambarLama !== "") {
                        unlink('gambar/profil/' . $gambarLama);
                    }
                    $namagambar = $id . '-' . time() . '.' . $gambar->getExtension();
                    $gambar->move('gambar/profil/', $namagambar);
                } else {
                    $namagambar = $dataUser['profilpembeli'];
                }

                try {
                    $this->ModelUser->update($id, [
                        'namapembeli' => $namapembeli,
                        'telppembeli' => $telppembeli,
                        'alamatpembeli' => $alamatpembeli,
                        'provinsipembeli' => $provinsipembeli,
                        'distrikpembeli' => $distrikpembeli,
                        'profilpembeli' => $namagambar,
                    ]);

                    $data = [
                        'status' => 200,
                        'error' => null,
                        'message' => [
                            'success' => 'Data berhasil diubah'
                        ]
                    ];
                    return $this->respond($data, 200);
                } catch (\Throwable $th) {
                    return $this->failServerError('Internal Server Error');
                }
            } else {
                $data = [
                    'errors' => [
                        'namapembeli' => $validation->getError('namapembeli'),
                        'telppembeli' => $validation->getError('telppembeli'),
                        'alamatpembeli' => $validation->getError('alamatpembeli'),
                        'distrikpembeli' => $validation->getError('distrikpembeli'),
                        'profilpembeli' => $validation->getError('profilpembeli'),
                    ]
                ];
                return $this->fail($data);
            }
        } else {
            return $this->failNotFound('User tidak dapat ditemukan');
        }
    }
}
