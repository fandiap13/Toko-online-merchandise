<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelPembeli;
use \Hermawan\DataTables\DataTable;

class Pembeli extends BaseController
{
  protected $ModelPembeli;

  public function __construct()
  {
    $this->ModelPembeli = new ModelPembeli();
  }

  public function index()
  {
    $data = [
      'title' => 'Data Pembeli'
    ];
    return view('admin/pembeli/view', $data);
  }

  public function datapembeli()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view("admin/pembeli/datapembeli")
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
      $builder = $db->table('tbl_pembeli')->select('pembeliid, emailpembeli, namapembeli, telppembeli, level');

      return DataTable::of($builder)
        ->add('aksi', function ($row) {
          return
            "
          <div class='text-center'>
          <button type='button' class='btn btn-sm btn-info' title='Edit Data' onclick='edit(\"$row->pembeliid\");'><i class='fa fa-edit'></i></button>

          <button type='submit' class='btn btn-sm btn-danger' title='Hapus Data' onclick='hapus(\"$row->pembeliid\", \"$row->namapembeli\");'><i class='fa fa-trash-alt'></i></button>
          ";
        })
        ->add('aksi2', function ($row) {
          return
            "
          <div class='text-center'>
          <button type='button' class='btn btn-sm btn-info' title='Pilih Data' onclick='pilih(\"$row->namapembeli\");'>Pilih</button>
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
        'data' => view("admin/pembeli/tambah")
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function tambahpembeli()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view("admin/pembeli/tambahpembeli")
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function edit()
  {
    if ($this->request->isAJAX()) {
      $pembeliid = $this->request->getVar('pembeliid');
      $cekData = $this->ModelPembeli->find($pembeliid);
      if ($cekData) {
        $data = [
          'data' => $this->ModelPembeli->find($pembeliid)
        ];
        $json = [
          'data' => view("admin/pembeli/edit", $data)
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
      $emailpembeli = $this->request->getVar('emailpembeli');
      $namapembeli = $this->request->getVar('namapembeli');
      $telppembeli = $this->request->getVar('telppembeli');

      $validation = \Config\Services::validation();

      if ($emailpembeli) {
        $ruleemail = 'valid_email|is_unique[tbl_pembeli.emailpembeli]|is_unique[tbl_admin.emailadmin]';
      } else {
        $ruleemail = 'permit_empty';
      }

      $valid = $this->validate([
        'emailpembeli' => [
          'label' => 'E-mail',
          'rules' => $ruleemail,
          'errors' => [
            'valid_email' => 'Yang anda masukkan bukan email',
            'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
          ]
        ],
        'namapembeli' => [
          'label' => 'Nama',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'telppembeli' => [
          'label' => 'No. Telp',
          'rules' => 'required|numeric',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'numeric' => 'Format penulisan salah',
          ]
        ],
      ]);

      if ($valid) {
        $simpan = [
          'emailpembeli' => $emailpembeli,
          'namapembeli' => $namapembeli,
          'telppembeli' => $telppembeli,
          'level' => 'Pembeli'
        ];
        $proses = $this->ModelPembeli->insert($simpan);
        if ($proses) {
          $msg = [
            'sukses' => 'Data pembeli dengan nama ' . $namapembeli . ' berhasil ditambahkan',
            'namapembeli' => $namapembeli
          ];
        }
      } else {
        $msg = [
          'error' => [
            'emailpembeli' => $validation->getError('emailpembeli'),
            'namapembeli' => $validation->getError('namapembeli'),
            'telppembeli' => $validation->getError('telppembeli'),
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
      $cekData = $this->ModelPembeli->find($id);
      if ($cekData) {
        $emailpembeli = $this->request->getVar('emailpembeli');
        $namapembeli = $this->request->getVar('namapembeli');
        $telppembeli = $this->request->getVar('telppembeli');

        $validation = \Config\Services::validation();

        if ($emailpembeli !== "" || $emailpembeli !== NULL) {
          if ($emailpembeli == $cekData['emailpembeli']) {
            $ruleemail = 'required|valid_email';
          } else {
            $ruleemail = 'valid_email|is_unique[tbl_pembeli.emailpembeli]|is_unique[tbl_admin.emailadmin]';
          }
        } else {
          $ruleemail = 'permit_empty';
        }

        $valid = $this->validate([
          'emailpembeli' => [
            'label' => 'E-mail',
            'rules' => $ruleemail,
            'errors' => [
              'valid_email' => 'Yang anda masukkan bukan email',
              'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
            ]
          ],
          'namapembeli' => [
            'label' => 'Nama',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'telppembeli' => [
            'label' => 'No. Telp',
            'rules' => 'required|numeric',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'numeric' => 'Format penulisan salah',
            ]
          ],
        ]);

        if ($valid) {
          $ubah = [
            'emailpembeli' => $emailpembeli,
            'namapembeli' => $namapembeli,
            'telppembeli' => $telppembeli,
            'level' => 'Pembeli'
          ];
          $proses = $this->ModelPembeli->update($id, $ubah);
          if ($proses) {
            $msg = [
              'sukses' => 'Data pembeli dengan nama ' . $namapembeli . ' berhasil diubah'
            ];
          }
        } else {
          $msg = [
            'error' => [
              'emailpembeli' => $validation->getError('emailpembeli'),
              'namapembeli' => $validation->getError('namapembeli'),
              'telppembeli' => $validation->getError('telppembeli'),
            ]
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data pembeli tidak ditemukan',
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
      $id = $this->request->getVar('pembeliid');
      $cekData = $this->ModelPembeli->find($id);
      if ($cekData) {
        $namapembeli = $cekData['namapembeli'];

        try {
          $this->ModelPembeli->delete($id);
          $msg = [
            'sukses' => 'Data pembeli dengan nama ' . $namapembeli . ' berhasil dihapus'
          ];
        } catch (\Throwable $th) {
          $msg = [
            'error' => 'Pembeli dengan nama ' . $namapembeli . ' tidak dapat dihapus !'
          ];
        }
        echo json_encode($msg);
      } else {
        $msg = [
          'error' => 'Data tidak ditemukan'
        ];
      }
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function modalcaripembeli()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view('admin/pembeli/modalcaripembeli')
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }
}
