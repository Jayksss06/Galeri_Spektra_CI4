<?php
namespace App\Controllers;
use App\Models\KaryaModel;

class Galeri extends BaseController
{
    public function index()
    {
        $karyaModel = new KaryaModel();

        $search   = $this->request->getGet('search');
        $kategori = $this->request->getGet('kategori');
        $sort     = $this->request->getGet('sort') ?? 'terbaru';

        $data = [
            'title'        => 'Eksplorasi Karya - Galeri Spektra',
            'daftar_karya' => $karyaModel->getKaryaPublik($search, $kategori, $sort)
        ];

        echo view('layout/header', $data);
        echo view('galeri/index', $data); 
        echo view('layout/footer');
    }
}