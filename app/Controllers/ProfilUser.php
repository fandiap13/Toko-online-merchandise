<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPembeli;

class ProfilUser extends BaseController
{
    protected $ModelPembeli;

    public function __construct()
    {
        $this->ModelPembeli = new ModelPembeli();
    }

    public function index()
    {
        $pembeliid = session('LoggedUserData')['userid'];
        return view('view_profiluser', [
            'title' => 'Profil User',
            'pembeli' => $this->ModelPembeli->find($pembeliid),
            'validation' => \Config\Services::validation()
        ]);
    }

    public function simpanPerubahan($id)
    {
        // dd($this->request->getPost());
        $cekData = $this->ModelPembeli->find($id);
        // dd($cekData['profilpembeli'] !== '');
        if ($cekData) {
            $data = [];
            $data = $this->request->getPost();

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
                'emailpembeli' => [
                    'label' => 'Email',
                    'rules' => "required|valid_email|is_unique[tbl_pembeli.emailpembeli, pembeliid, {$id}]|is_unique[tbl_admin.emailadmin]|max_length[150]",
                    'errors' => [
                        'is_unique' => '{field} ' . $this->request->getPost('emailpembeli') . ' sudah digunakan',
                        'required' => '{field} tidak boleh kosong',
                        'valid_email' => '{field} tidak valid',
                        'max_length' => '{field} maksimal terdiri dari 150 karakter'
                    ],
                ],
                'namapembeli' => [
                    'label' => 'Nama',
                    'rules' => "required|is_unique[tbl_pembeli.namapembeli, pembeliid, {$id}]|max_length[150]",
                    'errors' => [
                        'is_unique' => '{field} ' . $this->request->getPost('namapembeli') . ' sudah digunakan',
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
                // 'alamatpembeli' => [
                //     'label' => 'Alamat',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ],
                // ],
                // 'provinsipembeli' => [
                //     'label' => 'Provinsi',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ],
                // ],
                // 'distrikpembeli' => [
                //     'label' => 'Kota / Kabupaten',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ],
                // ],
            ]);

            if ($valid) {
                $gambar = $this->request->getFile('profilpembeli');
                $gambarLama = $cekData['profilpembeli'];
                if ($gambar->getError() !== 4) {
                    if ($gambarLama !== null && $gambarLama !== "") {
                        unlink('gambar/profil/' . $gambarLama);
                    }
                    $namagambar = $id . '-' . time() . '.' . $gambar->getExtension();
                    $gambar->move('gambar/profil/', $namagambar);
                } else {
                    $namagambar = $cekData['profilpembeli'];
                }

                $data['profilpembeli'] = $namagambar;
                $update = $this->ModelPembeli->update($id, $data);
                if ($update) {
                    session()->setFlashdata('msg', 'success#Profil berhasil diperbarui');
                }
                return redirect()->to(site_url('/profiluser'));
            } else {
                return redirect()->to(site_url('/profiluser'))->withInput();
            }
        } else {
            session()->setFlashdata('msg', 'error#Inputan tidak valid');
            return redirect()->to(site_url('/profiluser'));
        }
    }
}
