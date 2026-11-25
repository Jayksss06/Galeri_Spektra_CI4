<?php

namespace App\Controllers;

use App\Models\KuratorModel;
use App\Models\MahasiswaModel;

class Auth extends BaseController
{
    public function processLoginMahasiswa()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Masukkan format email institusi dan kata sandi yang valid.')
                ->with('modal_open', 'loginMahasiswaModal');
        }

        $mhsModel = new MahasiswaModel();
        $email    = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $user = $mhsModel->where('email_institusi', $email)->first();

        if ($user && password_verify($password, $user['kata_sandi'])) {
            session()->regenerate();
            session()->set([
                'logged_in'    => true,
                'id'           => (int) $user['id_mahasiswa'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email'        => $user['email_institusi'],
                'id_prodi'     => (int) $user['id_prodi'],
                'role'         => 'mahasiswa',
            ]);

            return redirect()->to(base_url('dashboard'))
                ->with('pesan', 'Selamat datang kembali, ' . $user['nama_lengkap'] . '!');
        }

        return redirect()->back()->withInput()
            ->with('error', 'Login Mahasiswa gagal. Periksa kembali email institusi dan kata sandi Anda.')
            ->with('modal_open', 'loginMahasiswaModal');
    }

    public function processRegisterMahasiswa()
    {
        $rules = [
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal terdiri dari 3 karakter.',
                    'max_length' => 'Nama lengkap maksimal 150 karakter.',
                ],
            ],
            'identitas' => [
                'rules'  => 'required|alpha_numeric|min_length[5]|max_length[20]|is_unique[mahasiswa.nim]',
                'errors' => [
                    'required'      => 'NIM wajib diisi.',
                    'alpha_numeric' => 'NIM hanya boleh berisi huruf dan angka.',
                    'min_length'    => 'NIM minimal terdiri dari 5 karakter.',
                    'max_length'    => 'NIM maksimal 20 karakter.',
                    'is_unique'     => 'NIM ini sudah terdaftar di sistem kami.',
                ],
            ],
            'id_prodi' => [
                'rules'  => 'required|is_natural_no_zero|is_not_unique[program_studi.id_prodi]',
                'errors' => [
                    'required'           => 'Program Studi wajib dipilih.',
                    'is_natural_no_zero' => 'Pilihan Program Studi tidak valid.',
                    'is_not_unique'      => 'Program Studi tidak ditemukan di sistem.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|max_length[150]|is_unique[mahasiswa.email_institusi]',
                'errors' => [
                    'required'    => 'Email institusi wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'max_length'  => 'Email maksimal 150 karakter.',
                    'is_unique'   => 'Email ini sudah terdaftar.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[8]|max_length[72]',
                'errors' => [
                    'required'   => 'Kata sandi wajib diisi.',
                    'min_length' => 'Kata sandi minimal 8 karakter untuk keamanan akun.',
                    'max_length' => 'Kata sandi maksimal 72 karakter.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('modal_open', 'registerMahasiswaModal');
        }

        $mahasiswaModel = new MahasiswaModel();

        $mahasiswaModel->insert([
            'nama_lengkap'    => trim((string) $this->request->getPost('nama_lengkap')),
            'nim'             => trim((string) $this->request->getPost('identitas')),
            'id_prodi'        => (int) $this->request->getPost('id_prodi'),
            'email_institusi' => strtolower(trim((string) $this->request->getPost('email'))),
            'kata_sandi'      => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->back()
            ->with('pesan_sukses', 'Registrasi berhasil! Silakan masuk menggunakan akun baru Anda.')
            ->with('modal_open', 'loginMahasiswaModal');
    }

    public function processLoginAdmin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Masukkan format email kurator dan kata sandi yang valid.')
                ->with('modal_open', 'loginAdminModal');
        }

        $kuratorModel = new KuratorModel();
        $email        = trim((string) $this->request->getPost('email'));
        $password     = (string) $this->request->getPost('password');

        $user = $kuratorModel->where('email_institusi', $email)->first();

        if ($user && password_verify($password, $user['kata_sandi'])) {
            session()->regenerate();
            session()->set([
                'logged_in'    => true,
                'id'           => (int) $user['id_kurator'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email'        => $user['email_institusi'],
                'role'         => 'admin',
            ]);

            return redirect()->to(base_url('dashboard/admin'))
                ->with('pesan', 'Selamat datang di Panel Kurator, ' . $user['nama_lengkap'] . '.');
        }

        return redirect()->back()->withInput()
            ->with('error', 'Login Kurator gagal. Periksa kembali email dan kata sandi Anda.')
            ->with('modal_open', 'loginAdminModal');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('/'));
    }
}
