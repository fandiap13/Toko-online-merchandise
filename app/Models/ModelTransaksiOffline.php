<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiOffline extends Model
{
    protected $table            = 'tbl_transaksioffline';
    protected $primaryKey       = 'transofflineid';
    protected $allowedFields    = [
        'transofflineid', 'tgltransaksi', 'jamtransaksi', 'namapembeli', 'totalbayar', 'dibayar', 'kembalian', 'kasir'
    ];

    public function transofflineid($tgl)
    {
        $tglsekarang = $tgl;

        $cek = $this->table('tbl_transaksioffline')->select('max(transofflineid) as transaksiid')->where('tgltransaksi', $tglsekarang)->get()->getNumRows();
        if ($cek == 0) {
            $transofflineid = date('dmy', strtotime($tglsekarang)) . '0001';
        } else {
            $hasil = $this->table('tbl_transaksioffline')->select('max(transofflineid) as transaksiid')->where('tgltransaksi', $tglsekarang)->get()->getRowArray();
            $data = $hasil['transaksiid'];
            $lastnourut = substr($data, -4);
            $nextnourut = intval($lastnourut) + 1;
            $transofflineid = date('dmy', strtotime($tglsekarang)) . sprintf('%04s', $nextnourut);
        }
        return $transofflineid;
    }

    public function cektransoffineid($id)
    {
        return $this->table('tbl_transaksioffline')
            ->where('sha1(transofflineid)', $id);
    }
}
