<?php

namespace App\Controllers;

use App\Models\ProgramStudiModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Helpers yang dimuat otomatis pada seluruh controller turunan.
     *
     * @var list<string>
     */
    protected $helpers = ['form', 'url'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Merender halaman utuh (header + konten + footer) beserta daftar program studi dinamis untuk modal registrasi.
     */
    protected function renderPage(string $viewName, array $data = []): string
    {
        if (! isset($data['daftar_prodi'])) {
            $prodiModel           = new ProgramStudiModel();
            $data['daftar_prodi'] = $prodiModel->getDaftarProdi();
        }

        return view('layout/header', $data)
            . view($viewName, $data)
            . view('layout/footer', $data);
    }
}
