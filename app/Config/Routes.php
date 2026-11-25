<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultController('Beranda');

// Rute Publik
$routes->get('/', 'Beranda::index');
$routes->get('galeri', 'Galeri::index');
$routes->post('galeri/lihat/(:num)', 'Galeri::incrementView/$1');

// Rute Autentikasi (Tanpa Registrasi Admin Publik)
$routes->post('login', 'Auth::processLoginMahasiswa');
$routes->post('login-admin', 'Auth::processLoginAdmin');
$routes->post('register', 'Auth::processRegisterMahasiswa');
$routes->post('logout', 'Auth::logout');

// Rute Terproteksi: Bersama (Mahasiswa & Kurator)
$routes->group('dashboard', ['filter' => 'auth'], static function ($routes) {
    $routes->get('profil', 'Dashboard::profil');
    $routes->post('update-profil', 'Dashboard::updateProfil');
});

// Rute Terproteksi: Khusus Mahasiswa
$routes->group('dashboard', ['filter' => 'auth:mahasiswa'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('ajukan-karya', 'Dashboard::ajukanKarya');
    $routes->post('simpan-karya', 'Dashboard::simpanKarya');
    $routes->post('hapus-karya', 'Dashboard::hapusKarya');
});

// Rute Terproteksi: Khusus Admin / Kurator
$routes->group('dashboard', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('admin', 'Dashboard::admin');
    $routes->post('update-status-karya', 'Dashboard::updateStatusKarya');
    $routes->get('export-csv', 'Dashboard::exportCSV');
    $routes->post('tambah-kurator', 'Dashboard::tambahKurator');
});
