<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultController('Beranda');


$routes->get('/', 'Beranda::index');
$routes->get('galeri', 'Galeri::index');


$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/admin', 'Dashboard::admin');
$routes->get('/dashboard/profil', 'Dashboard::profil');
$routes->get('/dashboard/ajukan-karya', 'Dashboard::ajukanKarya');

$routes->post('/dashboard/update-profil', 'Dashboard::updateProfil');
$routes->post('/dashboard/update-status-karya', 'Dashboard::updateStatusKarya');
$routes->post('/dashboard/simpan-karya', 'Dashboard::simpanKarya');
$routes->post('/dashboard/hapus-karya', 'Dashboard::hapusKarya');
$routes->get('/dashboard/export-csv', 'Dashboard::exportCSV');


$routes->post('login', 'Auth::processLoginMahasiswa');
$routes->post('login-admin', 'Auth::processLoginAdmin');
$routes->post('register', 'Auth::processRegisterMahasiswa');
$routes->post('register-admin', 'Auth::processRegisterAdmin');
$routes->get('logout', 'Auth::logout');
