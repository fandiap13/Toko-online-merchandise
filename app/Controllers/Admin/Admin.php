<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelAdmin;
use \Hermawan\DataTables\DataTable;

class Admin extends BaseController
{
  protected $ModelAdmin;

  public function __construct()
  {
    $this->ModelAdmin = new ModelAdmin();
  }

  public function index()
  {
    $data = [
      'title' => 'Data Admin'
    ];
    return view('admin/admin/view', $data);
  }

  public function dataadmin()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view("admin/admin/dataadmin")
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
      $builder = $db->table('tbl_admin')->select('adminid, emailadmin, namaadmin, level');

      return DataTable::of($builder)
        ->add('aksi', function ($row) {
          return
            "
          <div class='text-center'>
          <button type='button' class='btn btn-sm btn-info' title='Edit Data' onclick='edit(\"$row->adminid\");'><i class='fa fa-edit'></i></button>

          <button type='submit' class='btn btn-sm btn-danger' title='Hapus Data' onclick='hapus(\"$row->adminid\", \"$row->namaadmin\");'><i class='fa fa-trash-alt'></i></button>
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
        'data' => view("admin/admin/tambah")
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function edit()
  {
    if ($this->request->isAJAX()) {
      $adminid = $this->request->getVar('adminid');
      $cekData = $this->ModelAdmin->find($adminid);
      if ($cekData) {
        $data = [
          'data' => $this->ModelAdmin->find($adminid)
        ];
        $json = [
          'data' => view("admin/admin/edit", $data)
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
      $emailadmin = $this->request->getVar('emailadmin');
      $namaadmin = $this->request->getVar('namaadmin');

      $validation = \Config\Services::validation();

      $valid = $this->validate([
        'emailadmin' => [
          'label' => 'E-mail',
          'rules' => 'required|valid_email|is_unique[tbl_admin.emailadmin]|is_unique[tbl_pembeli.emailpembeli]',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'valid_email' => 'Yang anda masukkan bukan email',
            'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
          ]
        ],
        'namaadmin' => [
          'label' => 'Nama',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
      ]);

      if ($valid) {
        $simpan = [
          'emailadmin' => $emailadmin,
          'namaadmin' => $namaadmin,
          'level' => 'Admin'
        ];
        $proses = $this->ModelAdmin->insert($simpan);
        if ($proses) {
          $msg = [
            'sukses' => 'Data admin dengan nama ' . $namaadmin . ' berhasil ditambahkan'
          ];
        }
      } else {
        $msg = [
          'error' => [
            'emailadmin' => $validation->getError('emailadmin'),
            'namaadmin' => $validation->getError('namaadmin'),
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
      $cekData = $this->ModelAdmin->find($id);
      if ($cekData) {
        $emailadmin = $this->request->getVar('emailadmin');
        $namaadmin = $this->request->getVar('namaadmin');

        $validation = \Config\Services::validation();

        if ($emailadmin == $cekData['emailadmin']) {
          $ruleemail = 'required|valid_email';
        } else {
          $ruleemail = 'required|valid_email|is_unique[tbl_admin.emailadmin]|is_unique[tbl_pembeli.emailpembeli]';
        }

        $valid = $this->validate([
          'emailadmin' => [
            'label' => 'E-mail',
            'rules' => $ruleemail,
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'valid_email' => 'Yang anda masukkan bukan email',
              'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
            ]
          ],
          'namaadmin' => [
            'label' => 'Nama',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
        ]);

        if ($valid) {
          $ubah = [
            'emailadmin' => $emailadmin,
            'namaadmin' => $namaadmin,
            'level' => 'Admin'
          ];
          $proses = $this->ModelAdmin->update($id, $ubah);
          if ($proses) {
            $msg = [
              'sukses' => 'Data admin dengan nama ' . $namaadmin . ' berhasil diubah'
            ];
          }
        } else {
          $msg = [
            'error' => [
              'emailadmin' => $validation->getError('emailadmin'),
              'namaadmin' => $validation->getError('namaadmin'),
            ]
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data admin tidak ditemukan',
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
      $id = $this->request->getVar('adminid');
      $cekData = $this->ModelAdmin->find($id);
      if ($cekData) {
        $namaadmin = $cekData['namaadmin'];
        $hapus = $this->ModelAdmin->delete($id);
        if ($hapus) {
          $msg = [
            'sukses' => 'Data admin dengan nama ' . $namaadmin . ' berhasil dihapus'
          ];
        }
      } else {
        $msg = [
          'error' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }
}
