<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Publik & Katalog (Fase 1)
$routes->get('/', 'Home::index');
$routes->get('produk/(:num)', 'Home::detail/$1');
$routes->get('about', 'Page::about');
$routes->get('contact', 'Page::contact');

// Keranjang Belanja (Fase 2)
$routes->get('keranjang', 'Keranjang::index');
$routes->get('keranjang/tambah/(:num)', 'Keranjang::tambah/$1');
$routes->post('keranjang/update', 'Keranjang::update');
$routes->post('keranjang/hapus/(:num)', 'Keranjang::hapus/$1');
$routes->post('keranjang/kosongkan', 'Keranjang::kosongkan');

// Checkout (Fase 2 + Filter Autentikasi Fase 4)
$routes->group('checkout', ['filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('/', 'Keranjang::checkout');
    $routes->post('proses', 'Keranjang::prosesCheckout');
    $routes->get('sukses/(:num)', 'Keranjang::sukses/$1');
});

// Autentikasi Pengguna (Fase 4)
$routes->group('', ['filter' => 'guest'], static function (RouteCollection $routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::prosesLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::prosesRegister');
});
$routes->get('logout', 'Auth::logout');

// Dashboard Admin, CRUD Barang & Invoice (Fase 3 + Filter Role Admin Fase 4)
$routes->group('admin', ['filter' => 'admin'], static function (RouteCollection $routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('barang', 'Admin\Barang::index');
    $routes->get('barang/tambah', 'Admin\Barang::tambah');
    $routes->post('barang/simpan', 'Admin\Barang::simpan');
    $routes->get('barang/edit/(:num)', 'Admin\Barang::edit/$1');
    $routes->post('barang/update/(:num)', 'Admin\Barang::update/$1');
    $routes->post('barang/hapus/(:num)', 'Admin\Barang::hapus/$1');
    $routes->get('invoice', 'Admin\Invoice::index');
    $routes->get('invoice/(:num)', 'Admin\Invoice::detail/$1');
});
