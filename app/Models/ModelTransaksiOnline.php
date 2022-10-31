<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiOnline extends Model
{
    protected $table            = 'tbl_transaksionline';
    protected $primaryKey       = 'transonlineid';
    protected $allowedFields    = [
        'transonlineid', 'tgltransaksi', 'pembeliid', 'alamat', 'noresi', 'totalberat', 'provinsi', 'distrik', 'tipe', 'kodepos', 'ekspedisi', 'paket', 'ongkir', 'totalpembelian', 'statuspembayaran', 'statuspembelian', 'totalbayar', 'notelp', 'estimasi', 'payment_type', 'snapToken', 'pdf_url', 'order_id'
    ];

    public function transonlineid($tgl)
    {
        $tglsekarang = $tgl;
        $data = $this->query("SELECT max(transonlineid) as transaksiid FROM tbl_transaksionline WHERE DATE_FORMAT(tgltransaksi, '%Y-%m-%d') = '$tglsekarang'");
        $cek = $data;
        if ($cek->getNumRows() == 0) {
            $transonlineid = date('dmy', strtotime($tglsekarang)) . '0001';
        } else {
            $hasil = $data->getRowArray();
            $data = $hasil['transaksiid'];
            $lastnourut = substr($data, -4);
            $nextnourut = intval($lastnourut) + 1;
            $transonlineid = date('dmy', strtotime($tglsekarang)) . sprintf('%04s', $nextnourut);
        }
        return $transonlineid;
    }

    public function daftarTransaksi($pembeliid)
    {
        return $this->table('tbl_transaksionline')->select('transonlineid, order_id, tgltransaksi, estimasi, statuspembayaran, statuspembelian, totalbayar, snapToken')
            ->where('pembeliid', $pembeliid)->orderBy('tgltransaksi', 'DESC');
    }

    public function dataTransaksiPembeli($pembeliid, $transonlineid)
    {
        return $this->table('tbl_transaksionline')->where('transonlineid', $transonlineid)
            ->where('pembeliid', $pembeliid);
    }

    public function cektransonlineid($pembeliid, $id)
    {
        return $this->table('tbl_transaksionline')->where('pembeliid', $pembeliid)
            ->where('sha1(transonlineid)', $id);
    }
}
