<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default Root (Mengarahkan ke Login)
$routes->get('/', 'Auth::loginView');

// ==========================================
// AUTHENTICATION
// ==========================================
$routes->group('auth', function($routes) {
    $routes->get('/', 'Auth::loginView');
    $routes->get('login', 'Auth::loginView');
    $routes->post('login', 'Auth::processLogin');
    $routes->get('logout', 'Auth::logout');
});

// ==========================================
// ADMIN
// ==========================================
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Kelola Data Kasir oleh Admin
    $routes->get('kasir', 'Admin\Kasir::index');
    $routes->get('kasir/create', 'Admin\Kasir::create');
    $routes->post('kasir/store', 'Admin\Kasir::store');
    $routes->get('kasir/edit/(:num)', 'Admin\Kasir::edit/$1');
    $routes->post('kasir/update/(:num)', 'Admin\Kasir::update/$1');
    $routes->get('kasir/delete/(:num)', 'Admin\Kasir::delete/$1');
    $routes->get('kasir/status/(:num)/(:any)', 'Admin\Kasir::status/$1/$2');
    
    // Produk
    $routes->get('produk', 'Admin\Produk::index');
    $routes->get('produk/create', 'Admin\Produk::create');
    $routes->post('produk/store', 'Admin\Produk::store');
    $routes->get('produk/edit/(:num)', 'Admin\Produk::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin\Produk::update/$1');
    $routes->get('produk/delete/(:num)', 'Admin\Produk::delete/$1');
    $routes->get('produk/updateStatus/(:num)/(:any)', 'Admin\Produk::updateStatus/$1/$2');
    
    // Jenis Produk
    $routes->get('jenis-produk', 'Admin\JenisProduk::index');
    $routes->get('jenis-produk/create', 'Admin\JenisProduk::create');
    $routes->post('jenis-produk/store', 'Admin\JenisProduk::store');
    $routes->get('jenis-produk/edit/(:num)', 'Admin\JenisProduk::edit/$1');
    $routes->post('jenis-produk/update/(:num)', 'Admin\JenisProduk::update/$1');
    $routes->get('jenis-produk/delete/(:num)', 'Admin\JenisProduk::delete/$1');
    $routes->get('jenis-produk/updateStatus/(:num)/(:segment)', 'Admin\JenisProduk::updateStatus/$1/$2');
    
    // Laporan
    $routes->get('laporan', 'Admin\Laporan::index');
    $routes->get('laporan/keuangan', 'Admin\Laporan::keuangan');
    $routes->post('laporan/keuangan', 'Admin\Laporan::keuangan');
    
    // Pengeluaran
    $routes->get('pengeluaran', 'Admin\Pengeluaran::index');
    $routes->get('pengeluaran/create', 'Admin\Pengeluaran::create');
    $routes->post('pengeluaran/store', 'Admin\Pengeluaran::store');
    $routes->get('pengeluaran/edit/(:num)', 'Admin\Pengeluaran::edit/$1');
    $routes->post('pengeluaran/update/(:num)', 'Admin\Pengeluaran::update/$1');
    $routes->get('pengeluaran/delete/(:num)', 'Admin\Pengeluaran::delete/$1');
    
    // Pemasukan
    $routes->get('pemasukan', 'Admin\Pemasukan::index');
    $routes->get('pemasukan/create', 'Admin\Pemasukan::create');
    $routes->post('pemasukan/store', 'Admin\Pemasukan::store');
    $routes->get('pemasukan/edit/(:num)', 'Admin\Pemasukan::edit/$1');
    $routes->post('pemasukan/update/(:num)', 'Admin\Pemasukan::update/$1');
    $routes->get('pemasukan/delete/(:num)', 'Admin\Pemasukan::delete/$1');

    // Pengaturan
    $routes->get('pengaturan', 'Admin\Pengaturan::index');
    $routes->post('pengaturan/updateProfil', 'Admin\Pengaturan::updateProfil');
});

// ==========================================
// ==========================================
// PANEL KASIR (Namespace Sub-folder Kasir)
// ==========================================
$routes->group('kasir', ['namespace' => 'App\Controllers\Kasir'], function($routes) {
    $routes->get('/', 'Kasir::index');
    $routes->get('dashboard', 'Kasir::dashboard');
    $routes->get('transaksi', 'Kasir::transaksi');
    $routes->post('transaksi/simpan', 'Kasir::simpan_transaksi');
    $routes->get('riwayat', 'Kasir::riwayat');
    $routes->get('detail_transaksi/(:any)', 'Kasir::detail_transaksi/$1');
   
    $routes->get('cetak/(:num)', 'Kasir::cetak/$1');
    
    // Route Edit Profil
    $routes->get('edit_profil', 'Kasir::edit_profil');
    $routes->post('update_profil', 'Kasir::update_profil');
});
// ==========================================
// API
// ==========================================
$routes->group('api', function($routes) {
    $routes->get('search-produk', 'Api\Produk::search');
});

// Override Error 404
$routes->set404Override(function() {
    return view('errors/html/error_404');
});