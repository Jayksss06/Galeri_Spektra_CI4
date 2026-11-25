<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Memeriksa status autentikasi sesi dan otorisasi peran (RBAC).
     *
     * @param list<string>|null $arguments Daftar role yang diizinkan (mis. ['mahasiswa'] atau ['admin'])
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('/'))
                ->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman tersebut.')
                ->with('modal_open', 'loginSelectionModal');
        }

        if (! empty($arguments)) {
            $currentRole = (string) session()->get('role');
            if (! in_array($currentRole, $arguments, true)) {
                $targetUrl = $currentRole === 'admin'
                    ? base_url('dashboard/admin')
                    : base_url('dashboard');

                return redirect()->to($targetUrl)
                    ->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk membuka halaman tersebut.');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
