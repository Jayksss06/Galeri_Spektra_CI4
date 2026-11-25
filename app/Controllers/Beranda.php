<?php

namespace App\Controllers;

use App\Models\KaryaModel;

class Beranda extends BaseController
{
    public function index(): string
    {
        $karyaModel = new KaryaModel();

        $data = [
            'title'         => 'Beranda - Galeri Spektra Polimedia',
            'karya_terbaik' => $karyaModel->getKaryaTerbaik(8),
        ];

        return $this->renderPage('beranda/index', $data);
    }
}
