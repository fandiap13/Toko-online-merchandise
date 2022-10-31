<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelSatuan;
use \Hermawan\DataTables\DataTable;

class Satuan extends BaseController
{
  protected $ModelSatuan;

  public function __construct()
  {
    $this->ModelSatuan = new ModelSatuan();
  }

  public function index()
  {
    $data = [
      'title' => 'Data Satuan'
    ];
    return view('admin/satuan/view', $data);
  }

  public function datasatuan()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view("admin/satuan/datasatuan")
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
      $builder = $db->table('tbl_satuan')->select('satuanid, namasatuan');

      return DataTable::of($builder)
        ->add('aksi', function ($row) {
          return
            "
          <div class='text-center'>
          <button type='button' class='btn btn-sm btn-info' title='Edit Data' onclick='edit(\"$row->satuanid\");'><i class='fa fa-edit'></i></button>

          <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' onclick='hapus(\"$row->satuanid\", \"$row->namasatuan\");'><i class='fa fa-trash-alt'></i></button>
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
        'data' => view("admin/satuan/tambah")
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function edit()
  {
    if ($this->request->isAJAX()) {
      $satuanid = $this->request->getVar('satuanid');
      $cekData = $this->ModelSatuan->find($satuanid);
      if ($cekData) {
        $data = [
          'data' => $this->ModelSatuan->find($satuanid)
        ];
        $json = [
          'data' => view("admin/satuan/edit", $data)
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
      $namasatuan = $this->request->getVar('namasatuan');

      $validation = \Config\Services::validation();

      $valid = $this->validate([
        'namasatuan' => [
          'label' => 'Satuan',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
      ]);

      if ($valid) {
        $simpan = [
          'namasatuan' => $namasatuan,
        ];
        $proses = $this->ModelSatuan->insert($simpan);
        if ($proses) {
          $msg = [
            'sukses' => 'Data satuan ' . $namasatuan . ' berhasil ditambahkan'
          ];
        }
      } else {
        $msg = [
          'error' => [
            'namasatuan' => $validation->getError('namasatuan'),
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
      $cekData = $this->ModelSatuan->find($id);
      if ($cekData) {
        $namasatuan = $this->request->getVar('namasatuan');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
          'namasatuan' => [
            'label' => 'Satuan',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
        ]);

        if ($valid) {
          $ubah = [
            'namasatuan' => $namasatuan,
          ];
          $proses = $this->ModelSatuan->update($id, $ubah);
          if ($proses) {
            $msg = [
              'sukses' => 'Data satuan berhasil diubah'
            ];
          }
        } else {
          $msg = [
            'error' => [
              'namasatuan' => $validation->getError('namasatuan'),
            ]
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data satuan tidak ditemukan',
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
      $id = $this->request->getVar('satuanid');
      $cekData = $this->ModelSatuan->find($id);
      if ($cekData) {
        $namasatuan = $cekData['namasatuan'];
        try {
          $this->ModelSatuan->delete($id);
          $msg = [
            'sukses' => 'Data satuan ' . $namasatuan . ' berhasil dihapus'
          ];
        } catch (\Throwable $th) {
          $msg = [
            'error' => 'Satuan ' . $namasatuan . ' tidak dapat dihapus'
          ];
        }
      } else {
        $msg = [
          'error' => 'Data satuan tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }
}
