<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\KuratorModel;

class Auth extends BaseController
{

    public function processLoginMahasiswa()
    {
        $mhsModel = new MahasiswaModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $mhsModel->where('email_institusi', $email)->first();

        if ($user && password_verify($password, $user['kata_sandi'])) {
            session()->set([
                'logged_in'    => true,
                'id'           => $user['id_mahasiswa'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email'        => $user['email_institusi'],
                'id_prodi'     => $user['id_prodi'],
                'role'         => 'mahasiswa'
            ]);
            return redirect()->to(base_url('dashboard'));
        }

        session()->setFlashdata('error', 'Login Mahasiswa Gagal. Periksa kredensial Anda.');
        return redirect()->back();
    }

    public function processRegisterMahasiswa()
    {
        $rules = [
            'identitas' => [
                'rules'  => 'required|is_unique[mahasiswa.nim]',
                'errors' => [
                    'required'  => 'NIM wajib diisi.',
                    'is_unique' => 'NIM ini sudah terdaftar di sistem kami.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[mahasiswa.email_institusi]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email ini sudah terdaftar.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('modal_open', 'registerMahasiswaModal');
        }

        $mahasiswaModel = new MahasiswaModel();

        $data = [
            'nama_lengkap'    => $this->request->getPost('nama_lengkap'),
            'nim'             => $this->request->getPost('identitas'),
            'id_prodi'        => $this->request->getPost('id_prodi'),
            'email_institusi' => $this->request->getPost('email'),
            'kata_sandi'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT)
        ];

        $mahasiswaModel->insert($data);

        return redirect()->back()->with('pesan_sukses', 'Registrasi berhasil. Silakan masuk.')
            ->with('modal_open', 'loginMahasiswaModal');
    }


    public function processLoginAdmin()
    {
        $kuratorModel = new KuratorModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $kuratorModel->where('email_institusi', $email)->first();

        if ($user && password_verify($password, $user['kata_sandi'])) {
            session()->set([
                'logged_in'    => true,
                'id'           => $user['id_kurator'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email'        => $user['email_institusi'],
                'role'         => 'admin'
            ]);
            return redirect()->to(base_url('dashboard/admin'));
        }

        session()->setFlashdata('error', 'Login Kurator Gagal. Periksa kredensial Anda.');
        return redirect()->back();
    }

    public function processRegisterAdmin()
    {
        $rules = [
            'identitas' => [
                'rules'  => 'required|is_unique[kurator.nip_dosen]',
                'errors' => [
                    'required'  => 'NIP / ID Pengelola wajib diisi.',
                    'is_unique' => 'NIP / ID Pengelola ini sudah terdaftar di sistem.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[kurator.email_institusi]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email ini sudah terdaftar.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('modal_open', 'registerAdminModal');
        }

        $kuratorModel = new KuratorModel();

        $data = [
            'nama_lengkap'    => $this->request->getPost('nama_lengkap'),
            'nip_dosen'       => $this->request->getPost('identitas'),
            'email_institusi' => $this->request->getPost('email'),
            'kata_sandi'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT)
        ];

        $kuratorModel->insert($data);

        return redirect()->back()->with('pesan_sukses', 'Registrasi Pengelola berhasil. Silakan masuk.')
            ->with('modal_open', 'loginAdminModal');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
