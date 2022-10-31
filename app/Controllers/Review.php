<?php

namespace App\Controllers;

use App\Models\ModelDetailTransaksiOnline;
use App\Models\ModelGambarReview;
use App\Models\ModelProduk;
use App\Models\ModelPembeli;
use App\Models\ModelReview;
use App\Models\ModelTransaksiOnline;

class Review extends BaseController
{
    protected $ModelProduk;
    protected $ModelDetailTransaksiOnline;
    protected $ModelTransaksiOnline;
    protected $ModelPembeli;
    protected $ModelReview;
    protected $ModelGambarReview;

    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelDetailTransaksiOnline = new ModelDetailTransaksiOnline();
        $this->ModelTransaksiOnline = new ModelTransaksiOnline();
        $this->ModelPembeli = new ModelPembeli();
        $this->ModelReview = new ModelReview();
        $this->ModelGambarReview = new ModelGambarReview();
    }

    public function review($transonlineid)
    {
        $pembeliid = session()->get("LoggedUserData")['userid'];
        $cekData = $this->ModelTransaksiOnline
            ->getWhere([
                'transonlineid' => $transonlineid,
                'pembeliid' => $pembeliid,
                'statuspembelian' => 'diterima',
                'statuspembayaran' => 'settlement',
            ])->getNumRows();
        if ($cekData > 0) {
            $detailTransaksi = $this->ModelDetailTransaksiOnline->select('tbl_detail_transaksionline.produkid, gambarutama, namaproduk, tbl_detail_transaksionline.id')
                ->join('tbl_transaksionline', 'tbl_transaksionline.transonlineid=tbl_detail_transaksionline.transonlineid')
                ->join('tbl_produk', 'tbl_detail_transaksionline.produkid=tbl_produk.produkid')
                ->getWhere([
                    'tbl_transaksionline.transonlineid' => $transonlineid,
                    'tbl_transaksionline.pembeliid' => $pembeliid
                ])
                ->getResultArray();
            return view('view_review', [
                'title' => 'Review Produk',
                'detail' => $detailTransaksi
            ]);
        } else {
            return redirect()->to(site_url('/daftar-transaksi'));
        }
    }

    public function modalReview()
    {
        if ($this->request->isAJAX()) {
            $pembeliid = session()->get('LoggedUserData')['userid'];
            $detailtransid = $this->request->getVar('detailtransid');

            $cekReview = $this->ModelReview->select('reviewid, produkid, review, ranting')
                ->join('tbl_detail_transaksionline', 'tbl_detail_transaksionline.id=tbl_review.detailtransid')
                ->join('tbl_transaksionline', 'tbl_transaksionline.transonlineid=tbl_detail_transaksionline.transonlineid')
                ->getWhere([
                    'tbl_review.detailtransid' => $detailtransid,
                    'tbl_transaksionline.pembeliid' => $pembeliid
                ])->getRowArray();
            if ($cekReview) {
                $data = [
                    'formaction' => site_url('/review/ubahReview'),
                    'formtype' => 'ubah',
                    'detailtransid' => $detailtransid,
                    'reviewid' => $cekReview['reviewid'],
                    'namaproduk' => $this->ModelProduk->find($cekReview['produkid'])['namaproduk'],
                    'review' => $cekReview['review'],
                    'ranting' => $cekReview['ranting'],
                ];
            } else {
                $data = [
                    'formaction' => site_url('/review/simpanReview'),
                    'formtype' => 'simpan',
                    'reviewid' => null,
                    'detailtransid' => $detailtransid,
                    'namaproduk' => $this->ModelDetailTransaksiOnline
                        ->select('namaproduk')
                        ->join('tbl_produk', 'tbl_detail_transaksionline.produkid=tbl_produk.produkid')
                        ->where('tbl_detail_transaksionline.id', $detailtransid)
                        ->get()->getRowArray()['namaproduk'],
                    'review' => null,
                    'ranting' => null,
                ];
            }
            $json = [
                'data' => view('modalreviewproduk', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function simpanReview()
    {
        if ($this->request->isAJAX()) {
            $detailtransid = $this->request->getVar('detailtransid');
            $review = $this->request->getVar('review');
            $ranting = $this->request->getVar('ranting');
            // $gambar = $this->request->getFile('gambar');
            $gambar = $this->request->getFileMultiple('gambar');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'review' => [
                    'label' => 'Deskripsi Review',
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'max_length' => '{field} tidak boleh lebih dari 255 karakter'
                    ]
                ],
                'ranting' => [
                    'label' => 'Ranting',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'gambar' => [
                    'label' => 'Upload gambar',
                    'rules' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/png,image/jpg]',
                    'errors' => [
                        'max_size' => '{field} tidak boleh lebih dari 2 mb',
                        'is_image' => '{field} harus dalam bentuk gambar',
                        'mime_in' => '{field} harus dalam bentuk jpg/png',
                    ]
                ],
            ]);

            if ($valid) {
                if (count($gambar) > 5) {
                    $json = [
                        'errors' => '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        Upload gambar tidak boleh lebih dari 5 file.
                    </div>'
                    ];
                } else {
                    // if ($gambar->getError() == 4) {
                    //     $namagambar = null;
                    // } else {
                    //     $namagambar = $gambar->getRandomName();
                    //     $gambar->move('gambar/review/', $namagambar);
                    // }
                    $simpan = [
                        'detailtransid' => $detailtransid,
                        'review' => $review,
                        'ranting' => $ranting,
                        'tanggal' => date('Y-m-d H:i:s')
                    ];
                    $this->ModelReview->insert($simpan);
                    $reviewid = $this->ModelReview->getInsertID();

                    // apakah gambar tidak kosong
                    if ($gambar[0] != "") {
                        $daftarGambar = [];
                        foreach ($gambar as $key => $file) {
                            if ($file->isValid() && !$file->hasMoved()) {
                                $namagambar = $file->getRandomName();
                                $file->move('gambar/review/', $namagambar);

                                $daftarGambar[] = [
                                    'reviewid' => $reviewid,
                                    'gambar' => $namagambar
                                ];
                            }
                        }
                        $this->ModelGambarReview->insertBatch($daftarGambar);
                        // membuat explode
                        // $daftargambar = explode('#', rtrim($fileGambar, "#"));
                    }

                    $json = [
                        'sukses' => 'Reveiw anda berhasil dikirim',
                    ];
                }
            } else {
                $json = [
                    'errors' => '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        ' . $validation->listErrors() . '.
                    </div>'
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function ubahReview()
    {
        if ($this->request->isAJAX()) {
            $reviewid = $this->request->getVar('reviewid');
            $detailtransid = $this->request->getVar('detailtransid');
            $review = $this->request->getVar('review');
            $ranting = $this->request->getVar('ranting');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'review' => [
                    'label' => 'Deskripsi Review',
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'max_length' => '{field} tidak boleh lebih dari 255 karakter'
                    ]
                ],
                'ranting' => [
                    'label' => 'Ranting',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if ($valid) {
                $ubah = [
                    'detailtransid' => $detailtransid,
                    'review' => $review,
                    'ranting' => $ranting,
                    'tanggal' => date('Y-m-d H:i:s')
                ];
                $this->ModelReview->update($reviewid, $ubah);

                $json = [
                    'sukses' => 'Reveiw anda berhasil diubah'
                ];
            } else {
                $json = [
                    'errors' => '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        ' . $validation->listErrors() . '.
                    </div>'
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function dataGambar()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('datagambar', [
                    'reviewid' => $this->request->getVar('reviewid')
                ])
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function tambahGambar()
    {
        if ($this->request->isAJAX()) {
            $reviewid = $this->request->getVar('reviewid');
            $gambar = $this->request->getFileMultiple('gambar');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Gambar',
                    'rules' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/png,image/jpg]',
                    'errors' => [
                        'uploaded' => '{field} tidak boleh kosong',
                        'max_size' => '{field} tidak boleh lebih dari 2 mb',
                        'is_image' => 'Yg anda input bukan gambar',
                        'mime_in' => '{field} harus jpg/png',
                    ]
                ]
            ]);

            if ($valid) {
                $totalGambarReview = $this->ModelGambarReview->where('reviewid', $reviewid)->get()->getNumRows();
                $totalGambar = intval(count($gambar) + $totalGambarReview);
                if ($totalGambar > 5) {
                    $json = [
                        'errorJml' => '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        Max 5 gambar dalam 1 review.
                    </div>'
                    ];
                } else {
                    $daftargambar = [];
                    foreach ($gambar as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            $namagambar = $file->getRandomName();
                            $file->move('gambar/review/', $namagambar);

                            $daftargambar[] = [
                                'reviewid' => $reviewid,
                                'gambar' => $namagambar
                            ];
                        }
                    }

                    $this->ModelGambarReview->insertBatch($daftargambar);

                    $json = [
                        'sukses' => 'Gambar berhasil ditambahkan'
                    ];
                }
            } else {
                $json = [
                    'errors' => [
                        'gambar' => $validation->getError('gambar')
                    ]
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function hapusGambar()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cariGambar = $this->ModelGambarReview->find($id);
            if ($cariGambar) {
                unlink('gambar/review/' . $cariGambar['gambar']);
                $this->ModelGambarReview->delete($id);
                $json = [
                    'sukses' => 'Gambar berhasil dihapus'
                ];
            } else {
                $json = [
                    'error' => 'Gambar tidak ditemukan'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
