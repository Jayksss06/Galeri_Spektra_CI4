<?php

namespace App\Controllers;

use App\Models\KaryaModel;

class Beranda extends BaseController
{
    public function index()
    {
        $karyaModel = new KaryaModel();
        $karyaTerbaik = $karyaModel->where('status_kurasi', 'ACCEPTED')
            ->orderBy('tanggal_tinjauan', 'DESC')
            ->findAll(3);

        $data = [
            'title' => 'Beranda - Galeri Spektra',
        'karya_terbaik' => $karyaModel->getKaryaTerbaik(8)
        ];

        return view('layout/header', $data)
            . view('beranda/index', $data)
            . view('layout/footer');
    }
}
