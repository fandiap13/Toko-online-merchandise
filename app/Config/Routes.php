<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
// $routes->setTranslateURIDashes(false);
$routes->setTranslateURIDashes(true);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Admin\Dashboard::index');
$routes->get('/', 'Home::index');

$routes->get('/loginWithGoogle', 'Login::loginWithGoogle');
$routes->get('/registrasi', 'Login::registrasi');

$routes->get('/detailproduk/(:any)', 'Home::detailproduk/$1');
$routes->get('/keranjang', 'Transaksi::keranjang');
$routes->get('/daftar-transaksi', 'Transaksi::daftar_transaksi');
$routes->get('/detail-transaksi/(:any)', 'Transaksi::detail_transaksi/$1');
$routes->get('/cetak-transaksi/(:any)', 'Transaksi::cetak_transaksi/$1');
$routes->get('/keluar', 'Login::keluar');
$routes->get('/daftar-produk', 'Home::daftar_produk');
$routes->get('/review/(:any)', 'Review::review/$1');


// api
// $routes->resource('ProdukController');
// $routes->resource('KategoriController');
// $routes->resource('SatuanController');
// $routes->resource('TransaksiController');
// $routes->resource('PembeliController');
// $routes->resource('Otentikasi');

// $routes->get('/api/kategori', 'Api\KategoriController::index');

// $routes->post('/otentikasi_login', 'Api\Otentikasi::index');

// $routes->get('/api/satuan', 'Api\SatuanController::index');

// $routes->get('/api/produk', 'Api\ProdukController::index');
// $routes->get('/api/produk/(:any)', 'Api\ProdukController::show/$1');

// $routes->get('/api/transaksi', 'Api\TransaksiController::index');
// $routes->get('/api/transaksi/(:any)', 'Api\TransaksiController::show/$1');

// $routes->get('/api/pembeli/(:any)', 'Api\PembeliController::show/$1');
// $routes->put('/api/pembeli/(:any)', 'Api\PembeliController::update/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
