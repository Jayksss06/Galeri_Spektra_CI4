<?php

namespace App\Controllers;

use App\Models\KaryaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Galeri extends BaseController
{
    public function index(): string
    {
        $karyaModel = new KaryaModel();

        $search   = trim((string) $this->request->getGet('search'));
        $kategori = trim((string) $this->request->getGet('kategori'));
        $sort     = (string) ($this->request->getGet('sort') ?? 'terbaru');

        if (! in_array($sort, ['terbaru', 'terlama', 'populer'], true)) {
            $sort = 'terbaru';
        }

        if ($kategori !== '' && ! in_array($kategori, KaryaModel::getAllKategori(), true)) {
            $kategori = '';
        }

        $daftarKarya = $karyaModel->getKaryaPublikPaginated(
            $search !== '' ? $search : null,
            $kategori !== '' ? $kategori : null,
            $sort,
            9
        );

        $data = [
            'title'            => 'Eksplorasi Karya - Galeri Spektra Polimedia',
            'daftar_karya'     => $daftarKarya,
            'pager'            => $karyaModel->pager,
            'kategori_digital' => KaryaModel::KATEGORI_DIGITAL,
            'kategori_fisik'   => KaryaModel::KATEGORI_FISIK,
            'filter_search'    => $search,
            'filter_kategori'  => $kategori,
            'filter_sort'      => $sort,
        ];

        return $this->renderPage('galeri/index', $data);
    }

    public function incrementView(int $idKarya): ResponseInterface
    {
        $karyaModel  = new KaryaModel();
        $viewedKarya = session()->get('viewed_karya') ?? [];

        if (! in_array($idKarya, $viewedKarya, true)) {
            $newViews = $karyaModel->incrementJumlahDilihat($idKarya);
            if ($newViews === null) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Karya tidak ditemukan.',
                ]);
            }

            $viewedKarya[] = $idKarya;
            session()->set('viewed_karya', $viewedKarya);

            return $this->response->setJSON([
                'success' => true,
                'views'   => $newViews,
            ]);
        }

        $existing = $karyaModel->select('jumlah_dilihat')
            ->where('id_karya', $idKarya)
            ->where('status_kurasi', 'ACCEPTED')
            ->first();

        if (! $existing) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Karya tidak ditemukan.',
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'views'   => (int) $existing['jumlah_dilihat'],
        ]);
    }
}
