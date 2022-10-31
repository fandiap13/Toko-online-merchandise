<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelKategori;
use \Hermawan\DataTables\DataTable;

class Kategori extends BaseController
{
  protected $ModelKategori;

  public function __construct()
  {
    $this->ModelKategori = new ModelKategori();
  }

  public function index()
  {
    $data = [
      'title' => 'Data Kategori'
    ];
    return view('admin/kategori/view', $data);
  }

  public function datakategori()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view("admin/kategori/datakategori")
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function listData()
  {
    if ($this->request->isAJAX()) {
      $db = \Config\Database::connect();
      $builder = $db->table('tbl_kategori')->select('kategoriid, namakategori');

      return DataTable::of($builder)
        ->add('aksi', function ($row) {
          return
            "
          <div class='text-center'>
          <button type='button' class='btn btn-sm btn-info' title='Edit Data' onclick='edit(\"$row->kategoriid\");'><i class='fa fa-edit'></i></button>

          <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' onclick='hapus(\"$row->kategoriid\", \"$row->namakategori\");'><i class='fa fa-trash-alt'></i></button>
          </div>
          ";
        })
        ->addNumbering('nomor')
        ->toJson(true);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function tambah()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view("admin/kategori/tambah")
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function edit()
  {
    if ($this->request->isAJAX()) {
      $kategoriid = $this->request->getVar('kategoriid');
      $cekData = $this->ModelKategori->find($kategoriid);
      if ($cekData) {
        $data = [
          'data' => $this->ModelKategori->find($kategoriid)
        ];
        $json = [
          'data' => view("admin/kategori/edit", $data)
        ];
      } else {
        $json = [
          'error' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function simpandata()
  {
    if ($this->request->isAJAX()) {
      $namakategori = $this->request->getVar('namakategori');

      $validation = \Config\Services::validation();

      $valid = $this->validate([
        'namakategori' => [
          'label' => 'Kategori',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
      ]);

      if ($valid) {
        $simpan = [
          'namakategori' => $namakategori,
        ];
        $proses = $this->ModelKategori->insert($simpan);
        if ($proses) {
          $msg = [
            'sukses' => 'Data kategori ' . $namakategori . ' berhasil ditambahkan'
          ];
        }
      } else {
        $msg = [
          'error' => [
            'namakategori' => $validation->getError('namakategori'),
          ]
        ];
      }

      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function ubahdata($id)
  {
    if ($this->request->isAJAX()) {
      $cekData = $this->ModelKategori->find($id);
      if ($cekData) {
        $namakategori = $this->request->getVar('namakategori');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
          'namakategori' => [
            'label' => 'Kategori',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
        ]);

        if ($valid) {
          $ubah = [
            'namakategori' => $namakategori,
          ];
          $proses = $this->ModelKategori->update($id, $ubah);
          if ($proses) {
            $msg = [
              'sukses' => 'Data kategori berhasil diubah'
            ];
          }
        } else {
          $msg = [
            'error' => [
              'namakategori' => $validation->getError('namakategori'),
            ]
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data kategori tidak ditemukan',
        ];
      }

      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function hapus()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getVar('kategoriid');
      $cekData = $this->ModelKategori->find($id);
      if ($cekData) {
        $namakategori = $cekData['namakategori'];
        try {
          $this->ModelKategori->delete($id);
          $msg = [
            'sukses' => 'Data kategori ' . $namakategori . ' berhasil dihapus'
          ];
        } catch (\Throwable $th) {
          $msg = [
            'error' => 'Data kategori ' . $namakategori . ' tidak dapat dihapus'
          ];
        }
      } else {
        $msg = [
          'error' => 'Data kategori tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }
}
