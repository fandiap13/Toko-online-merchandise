<?php

namespace Config;

use App\Filters\FilterJWT;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterAdmin' => \App\Filters\FilterAdmin::class,
        'filterPembeli' => \App\Filters\FilterPembeli::class,
        'otentikasi' => FilterJWT::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            'filterPembeli' => [
                'except' => [
                    'login', 'loginWithGoogle',
                    'register',
                    'loginWithGoogle/*', 'login/*', '/',
                    'home',
                    'home/hargaukuranproduk',
                    'detailproduk/*',
                    'daftar-produk',
                    'registrasi'
                ]
            ],
            'filterAdmin' => [
                'except' => [
                    'login', 'loginWithGoogle',
                    'register',
                    'loginWithGoogle/*', 'login/*', '/',
                    'home',
                    'home/hargaukuranproduk',
                    'detailproduk/*',
                    'daftar-produk',
                    'registrasi'
                ]
            ],
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
            'filterPembeli' => [
                'except' => [
                    '/',
                    'home', 'home/*',
                    'transaksi', 'transaksi/*',
                    'rajaongkir', 'rajaongkir/*',
                    'payment', 'payment/*',
                    'keranjang',
                    'detailproduk/*',
                    'daftar-transaksi',
                    'detail-transaksi/*',
                    'cetak-transaksi/*',
                    'review/*',
                    'keluar',
                    'daftar-produk',
                    'profiluser', 'profiluser/*'
                ]
            ],
            'filterAdmin' => [
                'except' => [
                    '/',
                    'home',
                    'rajaongkir', 'rajaongkir/*',
                    'home/hargaukuranproduk',
                    'detailproduk/*',
                    'admin', 'admin/*',
                    'keluar',
                    'daftar-produk',
                ]
            ],
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    // public $filters = [
    //     'otentikasi' => [
    //         'before' => [
    //             'api/produk', 'api/produk/*',
    //             'api/kategori', 'api/kategori/*',
    //             'api/satuan', 'api/satuan/*',
    //             'api/transaksi', 'api/transaksi/*',
    //             'api/pembeli', 'api/pembeli/*',
    //         ]
    //     ]
    // ];
}
