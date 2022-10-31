<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelSupport;

class Setting extends BaseController
{
    protected $ModelSetting;
    protected $ModelSupport;

    public function __construct()
    {
        $this->ModelSetting = new ModelSetting();
        $this->ModelSupport = new ModelSupport();
    }

    public function index()
    {
        return view('admin/settingweb/view', [
            'title' => 'Setting Web',
            'setting' => $this->ModelSetting->first(),
        ]);
    }

    public function updateCarousel($id)
    {
        if ($this->request->isAJAX()) {
            $judulcarousel = $this->request->getVar('judulcarousel');
            $deskripsicarousel = $this->request->getVar('deskripsicarousel');
            $gambarcarousel = $this->request->getFile('gambarcarousel');
            $cekData = $this->ModelSetting->find($id);

            // dd($cekData);
            if ($cekData) {
                $valid = $this->validate([
                    'judulcarousel' => [
                        'label' => 'Judul carousel',
                        'rules' => 'required|max_length[100]',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'max_length' => '{field} tidak boleh lebih dari 100 karakter'
                        ]
                    ],
                    'deskripsicarousel' => [
                        'label' => 'Deskripsi carousel',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                    'gambarcarousel' => [
                        'label' => 'Gambar carousel',
                        'rules' => 'max_size[gambarcarousel,2048]|is_image[gambarcarousel]|mime_in[gambarcarousel,image/png,image/jpg,image/jpeg]',
                        'errors' => [
                            'max_size' => '{field} tidak boleh lebih dari 2 mb',
                            'is_image' => 'Yang anda upload bukan gambar',
                            'mime_in' => '{field} hanya bisa berformat jpg/jpeg/png',
                        ]
                    ],
                ]);

                $validation = \Config\Services::validation();

                if ($valid) {
                    $gambarLama = $this->ModelSetting->find($id)['gambarcarousel'];
                    if ($gambarcarousel->getError() !== 4) {
                        unlink('gambar/setting/' . $gambarLama);
                        $namagambar = $gambarcarousel->getRandomName();
                        $gambarcarousel->move('gambar/setting/', $namagambar);
                    } else {
                        $namagambar = $gambarLama;
                    }

                    $data = [
                        'judulcarousel' => $judulcarousel,
                        'deskripsicarousel' => $deskripsicarousel,
                        'gambarcarousel' => $namagambar,
                    ];

                    $this->ModelSetting->update($id, $data);

                    $json = [
                        'sukses' => 'Setting carousel berhasil diubah'
                    ];
                } else {
                    $json = [
                        'errors' => [
                            'judulcarousel' => $validation->getError('judulcarousel'),
                            'gambarcarousel' => $validation->getError('gambarcarousel'),
                            'deskripsicarousel' => $validation->getError('deskripsicarousel'),
                        ]
                    ];
                }
                echo json_encode($json);
            } else {
                return redirect()->to(site_url('/admin/setting/index'));
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function updateSettingWeb($id)
    {
        if ($this->request->isAJAX()) {
            $namawebsite = $this->request->getVar('namawebsite');
            $logowebsite = $this->request->getFile('logowebsite');
            $favicon = $this->request->getFile('favicon');

            $cekData = $this->ModelSetting->find($id);

            // dd($cekData);
            if ($cekData) {
                $valid = $this->validate([
                    'namawebsite' => [
                        'label' => 'Judul carousel',
                        'rules' => 'required|max_length[100]',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'max_length' => '{field} tidak boleh lebih dari 100 karakter'
                        ]
                    ],
                    'favicon' => [
                        'label' => 'Gambar carousel',
                        'rules' => 'max_size[favicon,2048]|is_image[favicon]|mime_in[favicon,image/png,image/jpg,image/jpeg]',
                        'errors' => [
                            'max_size' => '{field} tidak boleh lebih dari 2 mb',
                            'is_image' => 'Yang anda upload bukan gambar',
                            'mime_in' => '{field} hanya bisa berformat jpg/jpeg/png',
                        ]
                    ],
                    'logowebsite' => [
                        'label' => 'Logo website',
                        'rules' => 'max_size[logowebsite,2048]|is_image[logowebsite]|mime_in[logowebsite,image/png,image/jpg,image/jpeg]',
                        'errors' => [
                            'max_size' => '{field} tidak boleh lebih dari 2 mb',
                            'is_image' => 'Yang anda upload bukan gambar',
                            'mime_in' => '{field} hanya bisa berformat jpg/jpeg/png',
                        ]
                    ],
                ]);

                $validation = \Config\Services::validation();

                if ($valid) {
                    $logoLama = $cekData['logowebsite'];
                    $faviconLama = $cekData['favicon'];

                    if ($logowebsite->getError() !== 4) {
                        unlink('gambar/setting/' . $logoLama);
                        $namalogo = $logowebsite->getRandomName();
                        $logowebsite->move('gambar/setting/', $namalogo);
                    } else {
                        $namalogo = $logoLama;
                    }

                    if ($favicon->getError() !== 4) {
                        unlink('gambar/setting/' . $faviconLama);
                        $namafavicon = $favicon->getRandomName();
                        $favicon->move('gambar/setting/', $namafavicon);
                    } else {
                        $namafavicon = $faviconLama;
                    }

                    $data = [
                        'namawebsite' => $namawebsite,
                        'logowebsite' => $namalogo,
                        'favicon' => $namafavicon,
                    ];

                    $this->ModelSetting->update($id, $data);

                    $json = [
                        'sukses' => 'Setting website berhasil diubah'
                    ];
                } else {
                    $json = [
                        'errors' => [
                            'namawebsite' => $validation->getError('namawebsite'),
                            'logowebsite' => $validation->getError('logowebsite'),
                            'favicon' => $validation->getError('favicon'),
                        ]
                    ];
                }
                echo json_encode($json);
            } else {
                return redirect()->to(site_url('/admin/setting/index'));
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ubahTentangKami($id)
    {
        if ($this->request->isAJAX()) {
            $tentangkami = $this->request->getVar('tentangkami');

            $cekData = $this->ModelSetting->find($id);

            // dd($cekData);
            if ($cekData) {
                $valid = $this->validate([
                    'tentangkami' => [
                        'label' => 'Tentang kami',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ]
                ]);

                $validation = \Config\Services::validation();

                if ($valid) {
                    $data = [
                        'tentangkami' => $tentangkami,
                    ];

                    $this->ModelSetting->update($id, $data);

                    $json = [
                        'sukses' => 'Tentang kami berhasil diubah'
                    ];
                } else {
                    $json = [
                        'errors' => [
                            'tentangkami' => $validation->getError('tentangkami'),
                        ]
                    ];
                }
                echo json_encode($json);
            } else {
                return redirect()->to(site_url('/admin/setting/index'));
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ubahSettingLokasi($id)
    {
        if ($this->request->isAJAX()) {
            $lokasigmap = $this->request->getVar('lokasigmap');
            $alamattoko = $this->request->getVar('alamattoko');
            $provinsi = $this->request->getVar('provinsi');
            $distrik = $this->request->getVar('distrik');

            $cekData = $this->ModelSetting->find($id);

            if ($cekData) {
                $valid = $this->validate([
                    'lokasigmap' => [
                        'label' => 'Lokasi Gmap',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                    'alamattoko' => [
                        'label' => 'Alamat toko',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                    'provinsi' => [
                        'label' => 'Provinsi',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                    'distrik' => [
                        'label' => 'Distrik',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                ]);

                $validation = \Config\Services::validation();

                if ($valid) {
                    $data = [
                        'lokasigmap' => $lokasigmap,
                        'alamattoko' => $alamattoko,
                        'provinsi' => $provinsi,
                        'distrik' => $distrik,
                    ];

                    $this->ModelSetting->update($id, $data);

                    $json = [
                        'sukses' => 'Setting lokasi berhasil diubah'
                    ];
                } else {
                    $json = [
                        'errors' => [
                            'lokasigmap' => $validation->getError('lokasigmap'),
                            'alamattoko' => $validation->getError('alamattoko'),
                            'provinsi' => $validation->getError('provinsi'),
                            'distrik' => $validation->getError('distrik'),
                        ]
                    ];
                }
                echo json_encode($json);
            } else {
                return redirect()->to(site_url('/admin/setting/index'));
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ubahKontak($id)
    {
        if ($this->request->isAJAX()) {
            $email = $this->request->getVar('email');
            $wa = $this->request->getVar('wa');
            $instagram = $this->request->getVar('instagram');

            $cekData = $this->ModelSetting->find($id);

            if ($cekData) {
                $valid = $this->validate([
                    'email' => [
                        'label' => 'Lokasi Gmap',
                        'rules' => 'required|valid_email',
                        'errors' => [
                            'valid_email' => '{field} tidak valid',
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                    'wa' => [
                        'label' => 'No. Whatsapp',
                        'rules' => 'required|numeric',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'numeric' => '{field} harus angka',
                        ]
                    ],
                    'instagram' => [
                        'label' => 'Instagram',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                ]);

                $validation = \Config\Services::validation();

                if ($valid) {
                    $data = [
                        'kontak' => $email . "#" . $wa . "#" . $instagram,
                    ];

                    $this->ModelSetting->update($id, $data);

                    $json = [
                        'sukses' => 'Setting kontak berhasil diubah'
                    ];
                } else {
                    $json = [
                        'errors' => [
                            'email' => $validation->getError('email'),
                            'wa' => $validation->getError('wa'),
                            'instagram' => $validation->getError('instagram'),
                        ]
                    ];
                }
                echo json_encode($json);
            } else {
                return redirect()->to(site_url('/admin/setting/index'));
            }
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function dataSupport()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $datasupport = $this->ModelSupport
                ->getWhere(['settingid' => $id])->getResultArray();
            $json = [
                'data' => view('admin/settingweb/datasupport', [
                    'datasupport' => $datasupport
                ])
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function supported($id)
    {
        if ($this->request->isAJAX()) {
            $supported = $this->request->getVar('supported');
            $gambar = $this->request->getFile('gambar');
            $linkwebsite = $this->request->getVar('linkwebsite');

            $valid = $this->validate([
                'supported' => [
                    'label' => 'Supported',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'gambar' => [
                    'label' => 'Logo',
                    'rules' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]',
                    'errors' => [
                        'uploaded' => '{field} tidak boleh kosong',
                        'max_size' => '{field} tidak boleh lebih dari 2 mb',
                        'is_image' => 'Yang anda upload bukan gambar',
                        'mime_in' => '{field} hanya bisa berformat jpg/jpeg/png',
                    ]
                ],
            ]);

            $validation = \Config\Services::validation();

            if ($valid) {
                $namagambar = $gambar->getRandomName();
                $gambar->move('gambar/setting/', $namagambar);

                $data = [
                    'supported' => $supported,
                    'linkwebsite' => $linkwebsite,
                    'gambar' => $namagambar,
                    'settingid' => $id,
                ];

                $this->ModelSupport->insert($data);

                $json = [
                    'sukses' => 'Data support berhasil disimpan'
                ];
            } else {
                $json = [
                    'errors' => [
                        'supported' => $validation->getError('supported'),
                        'gambar' => $validation->getError('gambar'),
                    ]
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function hapusSupport()
    {
        if ($this->request->isAJAX()) {
            $supportid = $this->request->getVar('supportid');

            $cekData = $this->ModelSupport->find($supportid);
            if ($cekData) {
                unlink('gambar/setting/' . $cekData['gambar']);
                $this->ModelSupport->delete($supportid);
                $json = [
                    'sukses' => "Data berhasil dihapus"
                ];
            } else {
                $json = [
                    'error' => 'Data support tidak ditemukan'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function editSupport()
    {
        if ($this->request->isAJAX()) {
            $supportid = $this->request->getVar('supportid');
            $cekData = $this->ModelSupport->find($supportid);
            if ($cekData) {
                $json = [
                    'data' => view('admin/settingweb/modaleditsupport', [
                        'support' => $cekData
                    ])
                ];
            } else {
                $json = [
                    'error' => 'Data support tidak ditemukan'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ubahSupport()
    {
        if ($this->request->isAJAX()) {
            $supported = $this->request->getVar('supported');
            $gambar = $this->request->getFile('gambar');
            $linkwebsite = $this->request->getVar('linkwebsite');
            $gambarLama = $this->request->getVar('gambarLama');
            $supportid = $this->request->getVar('supportid');
            $settingid = $this->request->getVar('settingid');

            $cekData = $this->ModelSupport->find($supportid);
            if ($cekData) {
                $valid = $this->validate([
                    'supported' => [
                        'label' => 'Supported',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                    'gambar' => [
                        'label' => 'Logo',
                        'rules' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]',
                        'errors' => [
                            'max_size' => '{field} tidak boleh lebih dari 2 mb',
                            'is_image' => 'Yang anda upload bukan gambar',
                            'mime_in' => '{field} hanya bisa berformat jpg/jpeg/png',
                        ]
                    ],
                ]);

                $validation = \Config\Services::validation();

                if ($valid) {
                    if ($gambar->getError() !== 4) {
                        unlink('gambar/setting/' . $gambarLama);
                        $namagambar = $gambar->getRandomName();
                        $gambar->move('gambar/setting/', $namagambar);
                    } else {
                        $namagambar = $gambarLama;
                    }

                    $data = [
                        'supported' => $supported,
                        'linkwebsite' => $linkwebsite,
                        'gambar' => $namagambar,
                        'settingid' => $settingid,
                    ];

                    $this->ModelSupport->update($supportid, $data);

                    $json = [
                        'sukses' => 'Data support berhasil diubah'
                    ];
                } else {
                    $json = [
                        'errors' => [
                            'supported' => $validation->getError('supported'),
                            'gambar' => $validation->getError('gambar'),
                        ]
                    ];
                }
            } else {
                $json = [
                    'kosong' => 'Data tidak ditemukan'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
