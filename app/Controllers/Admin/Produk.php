<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksiOffline;
use App\Models\ModelGambarProduk;
use App\Models\ModelKategori;
use App\Models\ModelProduk;
use App\Models\ModelSatuan;
use App\Models\ModelUkuranProduk;
use \Hermawan\DataTables\DataTable;

class Produk extends BaseController
{
  protected $ModelProduk;
  protected $ModelKategori;
  protected $ModelSatuan;
  protected $ModelGambarProduk;
  protected $ModelUkuranProduk;
  protected $ModelDetailTransaksiOffline;

  public function __construct()
  {
    $this->ModelProduk = new ModelProduk();
    $this->ModelKategori = new ModelKategori();
    $this->ModelSatuan = new ModelSatuan();
    $this->ModelGambarProduk = new ModelGambarProduk();
    $this->ModelUkuranProduk = new ModelUkuranProduk();
    $this->ModelDetailTransaksiOffline = new ModelDetailTransaksiOffline();
  }

  public function index()
  {
    $data = [
      'title' => 'Data Produk'
    ];
    return view('admin/produk/view', $data);
  }

  public function dataproduk()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view("admin/produk/dataproduk")
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
      $builder = $db->table('tbl_produk')
        ->select('produkid, namaproduk, namakategori, hargaproduk, namasatuan, beratproduk, statusproduk')
        ->join('tbl_kategori', 'tbl_produk.kategoriid=tbl_kategori.kategoriid')
        ->join('tbl_satuan', 'tbl_produk.satuanid=tbl_satuan.satuanid')
        ->orderBy('produkid', 'DESC');

      return DataTable::of($builder)
        ->add('aksi', function ($row) {
          return
            "
          <div class='text-center'>
          <button type='button' class='btn btn-sm btn-info' title='Edit Data' onclick='edit(\"$row->produkid\");'><i class='fa fa-edit'></i></button>

          <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' onclick='hapus(\"$row->produkid\", \"$row->namaproduk\");'><i class='fa fa-trash-alt'></i></button>

          <button type='button' class='btn btn-sm btn-primary' title='Upload Gambar' onclick='upload(\"$row->produkid\");'><i class='fa fa-image'></i></button>

          <button type='button' class='btn btn-sm btn-secondary' title='Upload Ukuran' onclick='ukuran(\"$row->produkid\");'><i class='fa fa-ruler'></i></button>
          ";
        })
        ->add('status', function ($row) {
          if ($row->statusproduk == 0) {
            $status = 'Habis';
            $color = 'danger';
          } else {
            $status = 'Tersedia';
            $color = 'success';
          }
          return "<nav class='badge badge-" . $color . "'>" . $status . "</nav>";
        })
        ->add('hargaproduk', function ($row) {
          return "
            <div class='text-right'>" . number_format($row->hargaproduk, 0, ',', '.') . "</div>
          ";
        })
        ->add('beratproduk', function ($row) {
          return "
            <div class='text-right'>" . number_format($row->beratproduk, 0, ',', '.') . "</div>
          ";
        })
        ->add('aksi2', function ($row) {
          if ($row->statusproduk == 0) {
            return "
            <div class='text-center'>
            <button type='button' class='btn btn-sm btn-info' title='Pilih Data' disabled>Pilih</button>
            </div>
            ";
          } else {
            return
              "
            <div class='text-center'>
            <button type='button' class='btn btn-sm btn-info' title='Pilih Data' onclick='pilih(\"$row->produkid\", \"$row->namaproduk\");'>Pilih</button>
            </div>
            ";
          }
        })
        ->addNumbering('nomor')
        ->toJson(true);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function tambah()
  {
    $data = [
      'title' => 'Tambah Produk',
      'dataKategori' => $this->ModelKategori->findAll(),
      'dataSatuan' => $this->ModelSatuan->findAll()
    ];
    return view("admin/produk/tambah", $data);
  }

  public function edit($id)
  {
    $cekData = $this->ModelProduk->find($id);
    if ($cekData) {
      $data = [
        'title' => 'Edit Produk',
        'dataKategori' => $this->ModelKategori->findAll(),
        'dataSatuan' => $this->ModelSatuan->findAll(),
        'dataProduk' => $cekData,
      ];
      return view("admin/produk/edit", $data);
    } else {
      return redirect()->to(base_url('/admin/produk/index'));
    }
  }

  public function simpandata()
  {
    if ($this->request->isAJAX()) {
      $namaproduk = $this->request->getVar('namaproduk');
      $kategoriid = $this->request->getVar('kategoriid');
      $satuanid = $this->request->getVar('satuanid');
      $deskripsiproduk = $this->request->getVar('deskripsiproduk');
      $hargaproduk = $this->request->getVar('hargaproduk');
      $statusproduk = $this->request->getVar('statusproduk');
      $beratproduk = $this->request->getVar('beratproduk');
      $gambarutama = $this->request->getFile('gambarutama');

      $validation = \Config\Services::validation();

      $valid = $this->validate([
        'namaproduk' => [
          'label' => 'Nama Produk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'kategoriid' => [
          'label' => 'Kategori Produk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'satuanid' => [
          'label' => 'Satuan Produk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'deskripsiproduk' => [
          'label' => 'Deskripsi Produk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'statusproduk' => [
          'label' => 'Status Produk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'beratproduk' => [
          'label' => 'Berat Produk',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'hargaproduk' => [
          'label' => 'Harga Produk',
          'rules' => 'required|numeric',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'numeric' => 'Format penulisan salah',
          ]
        ],
        'gambarutama' => [
          'label' => 'Gambar utama',
          'rules' => 'uploaded[gambarutama]|max_size[gambarutama,3072]|is_image[gambarutama]|mime_in[gambarutama,image/jpg,image/jpeg,image/png]',
          'errors' => [
            'uploaded' => '{field} tidak boleh kosong',
            'max_size' => 'Ukuran gambar max 3 mb !',
            'is_image' => 'Yang anda pilih bukan gambar',
            'mime_in' => '{field} harus dalam format jpg/jpeg/png'
          ]
        ]
      ]);

      if ($valid) {
        $namagambar = $gambarutama->getRandomName();
        $gambarutama->move('gambar/produk/', $namagambar);
        $simpan = [
          'tglpost' => date('Y-m-d'),
          'namaproduk' => $namaproduk,
          'kategoriid' => $kategoriid,
          'satuanid' => $satuanid,
          'deskripsiproduk' => $deskripsiproduk,
          'hargaproduk' => $hargaproduk,
          'statusproduk' => $statusproduk,
          'beratproduk' => $beratproduk,
          'gambarutama' => $namagambar
        ];
        $proses = $this->ModelProduk->insert($simpan);
        if ($proses) {
          $msg = [
            'sukses' => 'Data produk dengan nama ' . $namaproduk . ' berhasil ditambahkan'
          ];
        }
      } else {
        $msg = [
          'error' => [
            'namaproduk' => $validation->getError('namaproduk'),
            'kategoriid' => $validation->getError('kategoriid'),
            'satuanid' => $validation->getError('satuanid'),
            'deskripsiproduk' => $validation->getError('deskripsiproduk'),
            'hargaproduk' => $validation->getError('hargaproduk'),
            'statusproduk' => $validation->getError('statusproduk'),
            'beratproduk' => $validation->getError('beratproduk'),
            'gambarutama' => $validation->getError('gambarutama'),
          ]
        ];
      }

      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function ubahdata()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $namaproduk = $this->request->getVar('namaproduk');
      $kategoriid = $this->request->getVar('kategoriid');
      $satuanid = $this->request->getVar('satuanid');
      $deskripsiproduk = $this->request->getVar('deskripsiproduk');
      $hargaproduk = $this->request->getVar('hargaproduk');
      $statusproduk = $this->request->getVar('statusproduk');
      $beratproduk = $this->request->getVar('beratproduk');
      $gambarutama = $this->request->getFile('gambarutama');

      $cekData = $this->ModelProduk->find($produkid);
      if ($cekData) {
        $validation = \Config\Services::validation();
        $valid = $this->validate([
          'namaproduk' => [
            'label' => 'Nama Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'kategoriid' => [
            'label' => 'Kategori Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'satuanid' => [
            'label' => 'Satuan Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'deskripsiproduk' => [
            'label' => 'Deskripsi Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'statusproduk' => [
            'label' => 'Status Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'beratproduk' => [
            'label' => 'Berat Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'hargaproduk' => [
            'label' => 'Harga Produk',
            'rules' => 'required|numeric',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'numeric' => 'Format penulisan salah',
            ]
          ],
          'gambarutama' => [
            'label' => 'Gambar utama',
            'rules' => 'max_size[gambarutama,3072]|is_image[gambarutama]|mime_in[gambarutama,image/jpg,image/jpeg,image/png]',
            'errors' => [
              'max_size' => 'Ukuran gambar max 3 mb !',
              'is_image' => 'Yang anda pilih bukan gambar',
              'mime_in' => '{field} harus dalam format jpg/jpeg/png'
            ]
          ]
        ]);

        if ($valid) {
          if ($gambarutama->getError() == 4) {
            $namagambar = $cekData['gambarutama'];
          } else {
            unlink('gambar/produk/' . $cekData['gambarutama']);
            $namagambar = $gambarutama->getRandomName();
            $gambarutama->move('gambar/produk/', $namagambar);
          }
          $ubah = [
            'namaproduk' => $namaproduk,
            'kategoriid' => $kategoriid,
            'satuanid' => $satuanid,
            'deskripsiproduk' => $deskripsiproduk,
            'hargaproduk' => $hargaproduk,
            'statusproduk' => $statusproduk,
            'beratproduk' => $beratproduk,
            'gambarutama' => $namagambar,
          ];
          $proses = $this->ModelProduk->update($produkid, $ubah);
          if ($proses) {
            $msg = [
              'sukses' => 'Data produk dengan nama ' . $namaproduk . ' berhasil diubah'
            ];
          }
        } else {
          $msg = [
            'error' => [
              'namaproduk' => $validation->getError('namaproduk'),
              'kategoriid' => $validation->getError('kategoriid'),
              'satuanid' => $validation->getError('satuanid'),
              'deskripsiproduk' => $validation->getError('deskripsiproduk'),
              'hargaproduk' => $validation->getError('hargaproduk'),
              'statusproduk' => $validation->getError('statusproduk'),
              'beratproduk' => $validation->getError('beratproduk'),
              'gambarutama' => $validation->getError('gambarutama'),
            ]
          ];
        }
      } else {
        $msg = [
          'pesanerror' => "Data Produk Tidak Ditemukan"
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function ukuran()
  {
    if ($this->request->isAJAX()) {
      $data = [
        'produkid' => $this->request->getVar('produkid'),
        'dataukuran' => $this->ModelUkuranProduk->findAll(),
      ];
      $json = [
        'data' => view('admin/produk/modalukuran', $data)
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function dataukuranproduk()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $data = [
        'dataukuran' => $this->ModelUkuranProduk->where('produkid', $produkid)->get()->getResultArray()
      ];
      $json = [
        'data' => view('admin/produk/dataukuran', $data)
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpanukuran()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $ukuran = $this->request->getVar('ukuran');
      $status = $this->request->getVar('status');
      $hargaproduk = $this->request->getVar('hargaproduk');
      $cekData = $this->ModelProduk->find($produkid);
      if ($cekData) {
        $validation = \Config\Services::validation();

        // jika ukuran tidak ada yang sama pada tbl ukuran produk
        $cariukuranproduk = $this->ModelUkuranProduk->where('produkid', $produkid)
          ->where('ukuran', $ukuran)->countAllResults();
        if ($cariukuranproduk == 0) {
          $ruleukuran = 'required';
        } else {
          // jika ukuran ada yang sama pada tbl ukuran produk
          $ruleukuran = 'required|is_unique[tbl_ukuran_produk.ukuran]';
        }

        $valid = $this->validate([
          'ukuran' => [
            'label' => 'Ukuran Produk',
            'rules' => $ruleukuran,
            'errors' => [
              'required' => '{field} tidak boleh kosong',
              'is_unique' => '{field} sudah ada'
            ]
          ],
          'status' => [
            'label' => 'Status Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'hargaproduk' => [
            'label' => 'Harga Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ]
        ]);
        if ($valid) {
          $this->ModelUkuranProduk->insert([
            'ukuran' => $ukuran,
            'produkid' => $produkid,
            'hargaproduk' => $hargaproduk,
            'status' => $status,
          ]);
          $msg = [
            'sukses' => 'Data ukuran berhasil ditambahkan'
          ];
        } else {
          $msg = [
            'error' => $validation->listErrors()
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function ubahukuran()
  {
    if ($this->request->isAJAX()) {
      $ukuranprodukid = $this->request->getVar('ukuranprodukid');
      $status = $this->request->getVar('status');
      $hargaproduk = $this->request->getVar('hargaproduk');

      $cekData = $this->ModelUkuranProduk->find($ukuranprodukid);
      if ($cekData) {
        $validation = \Config\Services::validation();

        $valid = $this->validate([
          'status' => [
            'label' => 'Status Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ],
          'hargaproduk' => [
            'label' => 'Harga Produk',
            'rules' => 'required',
            'errors' => [
              'required' => '{field} tidak boleh kosong',
            ]
          ]
        ]);
        if ($valid) {
          $this->ModelUkuranProduk->update($ukuranprodukid, [
            'status' => $status,
            'hargaproduk' => $hargaproduk,
          ]);
          $msg = [
            'sukses' => 'Data ukuran berhasil diubah'
          ];
        } else {
          $msg = [
            'error' => $validation->listErrors()
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function hapusukuran()
  {
    if ($this->request->isAJAX()) {
      $ukuranprodukid = $this->request->getVar('ukuranprodukid');
      $cekData = $this->ModelUkuranProduk->find($ukuranprodukid);
      if ($cekData) {
        try {
          $this->ModelUkuranProduk->delete($ukuranprodukid);
          $msg = [
            'sukses' => 'Ukuran berhasil dihapus'
          ];
        } catch (\Throwable $th) {
          $msg = [
            'pesanerror' => 'Ukuran ' . $cekData['ukuran'] . ' tidak dapat dihapus'
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function editukuran()
  {
    if ($this->request->isAJAX()) {
      $ukuranprodukid = $this->request->getVar('ukuranprodukid');
      $cekData = $this->ModelUkuranProduk->find($ukuranprodukid);
      if ($cekData) {
        $msg = [
          'data' => [
            'ukuran' => $cekData['ukuran'],
            'hargaproduk' => $cekData['hargaproduk'],
            'status' => $cekData['status']
          ]
        ];
      } else {
        $msg = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function uploadgambar()
  {
    if ($this->request->isAJAX()) {
      $data = [
        'produkid' => $this->request->getVar('produkid')
      ];
      $json = [
        'data' => view('admin/produk/uploadgambar', $data)
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function datagambar()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $data = [
        'datagambar' => $this->ModelGambarProduk->cariProduk($produkid)->get()->getResultArray()
      ];
      $json = [
        'data' => view('admin/produk/datagambar', $data)
      ];

      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function simpangambar()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $gambarproduk = $this->request->getFile('gambarproduk');

      $cekData = $this->ModelProduk->find($produkid);
      if ($cekData) {
        $validation = \Config\Services::validation();
        $valid = $this->validate([
          'gambarproduk' => [
            'label' => 'Gambar produk',
            'rules' => 'max_size[gambarproduk,3072]|is_image[gambarproduk]|mime_in[gambarproduk,image/jpg,image/jpeg,image/png]',
            'errors' => [
              // 'required' => '{field} tidak boleh kosong',
              'max_size' => 'Ukuran gambar max 3 mb !',
              'is_image' => 'Yang anda pilih bukan gambar',
              'mime_in' => '{field} harus dalam format jpg/jpeg/png'
            ]
          ]
        ]);

        if ($valid) {
          if ($gambarproduk !== "" || $gambarproduk !== NULL) {
            $namaGambar = $gambarproduk->getRandomName();
            $gambarproduk->move('gambar/produk/', $namaGambar);
            $simpan = $this->ModelGambarProduk->insert([
              'produkid' => $produkid,
              'gambarproduk' => $namaGambar
            ]);
            if ($simpan) {
              $msg = [
                'sukses' => 'Gambar berhasil disimpan'
              ];
            }
          } else {
            $msg = [
              'error' => [
                'gambarproduk' => "Gambar tidak boleh kosong",
              ]
            ];
          }
        } else {
          $msg = [
            'error' => [
              'gambarproduk' => $validation->getError('gambarproduk'),
            ]
          ];
        }
      } else {
        $msg = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function hapusgambar()
  {
    if ($this->request->isAJAX()) {
      $gambarprodukid = $this->request->getVar('gambarprodukid');
      $cekData = $this->ModelGambarProduk->find($gambarprodukid);
      if ($cekData) {
        unlink('gambar/produk/' . $cekData['gambarproduk']);
        $this->ModelGambarProduk->delete($gambarprodukid);
        $msg = [
          'sukses' => 'Gambar berhasil dihapus'
        ];
      } else {
        $msg = [
          'pesanerror' => 'Data tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diproses');
    }
  }

  public function hapus()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getVar('produkid');
      $cekData = $this->ModelProduk->find($id);

      if ($cekData) {
        $namaproduk = $cekData['namaproduk'];
        try {
          // hapus gambar produk
          $dataGambar = $this->ModelGambarProduk->cariProduk($id);
          if ($dataGambar->countAllResults() !== 0) {
            foreach ($this->ModelGambarProduk->cariProduk($id)->get()->getResultArray() as $gambar) {
              $gambarproduk = $gambar['gambarproduk'];
              $this->ModelGambarProduk->hapusGambar($id);
              unlink('gambar/produk/' . $gambarproduk);
            }
          }

          // hapus ukuran produk
          $dataUkuran = $this->ModelUkuranProduk->cariProduk($id);
          if ($dataUkuran->countAllResults() !== 0) {
            foreach ($this->ModelUkuranProduk->cariProduk($id)->get()->getResultArray() as $gambar) {
              $this->ModelUkuranProduk->hapusUkuran($id);
            }
          }

          unlink('gambar/produk/' . $cekData['gambarutama']);
          $this->ModelProduk->delete($id);

          $msg = [
            'sukses' => 'Data produk dengan nama ' . $namaproduk . ' berhasil dihapus'
          ];
        } catch (\Throwable $th) {
          $msg = [
            'error' => 'Produk ' . $namaproduk . ' tidak dapat dihapus !'
          ];
        }
      } else {
        $msg = [
          'error' => 'Produk tidak ditemukan'
        ];
      }
      echo json_encode($msg);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  public function modalcariproduk()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view('admin/produk/modalcariproduk')
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  // pilih produk
  public function cariproduk()
  {
    if ($this->request->isAJAX()) {
      $produkid = $this->request->getVar('produkid');
      $id = $this->request->getVar('id');
      $cekData = $this->ModelUkuranProduk->where('produkid', $produkid)->countAllResults();
      // jika produk memiliki pilihan ukuran
      if ($cekData > 0) {
        if ($id) {
          // untuk edit data
          $data = [
            'ukuranprodukoptions' => $this->ModelUkuranProduk->where('produkid', $produkid)->where('status', 1)->get()->getResultArray(),
            'ukuranprodukdetail' => $this->ModelDetailTransaksiOffline->find($id)
          ];
          // untuk tambah data
        } else {
          $data = [
            'ukuranprodukoptions' => $this->ModelUkuranProduk->where('produkid', $produkid)->where('status', 1)->get()->getResultArray(),
            'ukuranprodukdetail' => null
          ];
        }
        $json = [
          'data' => view('admin/produk/ukuranprodukoptions', $data)
        ];
        // jika produk tidak memiliki ukuran
      } else {
        $hargaproduk = $this->ModelProduk->find($produkid);
        $json = [
          'hargajual' => $hargaproduk['hargaproduk']
        ];
      }
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }

  // mencari hargajual produk
  public function hargajual()
  {
    if ($this->request->isAJAX()) {
      $ukuranprodukid = $this->request->getVar('ukuranprodukid');
      // $produkid = $this->request->getVar('produkid');
      // $cekData = $this->ModelUkuranProduk->cariUkuran($produkid, $ukuranprodukid)->get()->getResultArray();
      $cekData = $this->ModelUkuranProduk->find($ukuranprodukid);
      $json = [
        'hargajual' => $cekData['hargaproduk']
      ];
      echo json_encode($json);
    } else {
      exit('Maaf tidak dapat diperoses');
    }
  }
}
