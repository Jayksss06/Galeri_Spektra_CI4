<?php

namespace App\Controllers;

use App\Models\KaryaModel;
use App\Models\KuratorModel;
use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $karyaModel  = new KaryaModel();
        $idMahasiswa = (int) session()->get('id');

        $data = [
            'title'   => 'Dasbor Mahasiswa - Galeri Spektra',
            'riwayat' => $karyaModel->where('id_mahasiswa', $idMahasiswa)
                ->orderBy('tanggal_pengajuan', 'DESC')
                ->findAll(),
            'statistik' => [
                'total'     => $karyaModel->where('id_mahasiswa', $idMahasiswa)->countAllResults(),
                'disetujui' => $karyaModel->where('id_mahasiswa', $idMahasiswa)->where('status_kurasi', 'ACCEPTED')->countAllResults(),
                'review'    => $karyaModel->where('id_mahasiswa', $idMahasiswa)->where('status_kurasi', 'PENDING')->countAllResults(),
                'ditolak'   => $karyaModel->where('id_mahasiswa', $idMahasiswa)->where('status_kurasi', 'REJECTED')->countAllResults(),
            ],
        ];

        return $this->renderPage('dashboard/mahasiswa', $data);
    }

    public function ajukanKarya(): string
    {
        $data = [
            'title'            => 'Ajukan Karya - Galeri Spektra',
            'kategori_digital' => KaryaModel::KATEGORI_DIGITAL,
            'kategori_fisik'   => KaryaModel::KATEGORI_FISIK,
        ];

        return $this->renderPage('dashboard/ajukan_karya', $data);
    }

    public function admin(): string
    {
        $karyaModel = new KaryaModel();

        $data = [
            'title'            => 'Dasbor Kurator - Galeri Spektra',
            'daftar_karya'     => $karyaModel->getKaryaTerbaru(),
            'total_pending'    => $karyaModel->where('status_kurasi', 'PENDING')->countAllResults(),
            'total_published'  => $karyaModel->where('status_kurasi', 'ACCEPTED')->countAllResults(),
            'total_rejected'   => $karyaModel->where('status_kurasi', 'REJECTED')->countAllResults(),
            'distribusi_prodi' => $karyaModel->getDistribusiProdi(),
        ];

        return $this->renderPage('dashboard/admin', $data);
    }

    public function profil()
    {
        $role = (string) session()->get('role');
        $id   = (int) session()->get('id');

        if ($role === 'admin') {
            $kuratorModel = new KuratorModel();
            $akun         = $kuratorModel->find($id);
        } else {
            $mhsModel = new MahasiswaModel();
            $akun     = $mhsModel->getProfilLengkap($id);
        }

        if (! $akun) {
            session()->destroy();

            return redirect()->to(base_url('/'))
                ->with('error', 'Data sesi akun tidak ditemukan. Silakan masuk kembali.');
        }

        $prodiModel = new ProgramStudiModel();

        $data = [
            'title'        => 'Profil Akun - Galeri Spektra',
            'akun'         => $akun,
            'daftar_prodi' => $prodiModel->getDaftarProdi(),
        ];

        return $this->renderPage('dashboard/profil', $data);
    }

    public function updateProfil()
    {
        $role = (string) session()->get('role');
        $id   = (int) session()->get('id');

        if ($role === 'mahasiswa') {
            $model     = new MahasiswaModel();
            $pk        = 'id_mahasiswa';
            $table     = 'mahasiswa';
            $idCol     = 'nim';
            $userExist = $model->find($id);
        } else {
            $model     = new KuratorModel();
            $pk        = 'id_kurator';
            $table     = 'kurator';
            $idCol     = 'nip_dosen';
            $userExist = $model->find($id);
        }

        if (! $userExist) {
            return redirect()->to(base_url('/'));
        }

        $rules = [
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                ],
            ],
            'email' => [
                'rules'  => "required|valid_email|max_length[150]|is_unique[{$table}.email_institusi,{$pk},{$id}]",
                'errors' => [
                    'required'    => 'Alamat email wajib diisi.',
                    'valid_email' => 'Format alamat email tidak valid.',
                    'is_unique'   => 'Alamat email tersebut sudah digunakan oleh akun lain.',
                ],
            ],
            'identitas' => [
                'rules'  => "required|alpha_numeric|min_length[5]|max_length[20]|is_unique[{$table}.{$idCol},{$pk},{$id}]",
                'errors' => [
                    'required'      => strtoupper($idCol === 'nim' ? 'NIM' : 'NIP') . ' wajib diisi.',
                    'alpha_numeric' => 'Nomor identitas hanya boleh berisi huruf dan angka.',
                    'is_unique'     => 'Nomor identitas tersebut sudah terdaftar pada akun lain.',
                ],
            ],
        ];

        if ($role === 'mahasiswa') {
            $rules['id_prodi']        = 'required|is_natural_no_zero|is_not_unique[program_studi.id_prodi]';
            $rules['bio_singkat']     = 'permit_empty|max_length[1000]';
            $rules['portofolio_link'] = 'permit_empty|valid_url_strict[https,http]|max_length[255]';
        } else {
            $rules['departemen'] = 'required|min_length[3]|max_length[150]';
        }

        $passLama = (string) $this->request->getPost('password_lama');
        $passBaru = (string) $this->request->getPost('password_baru');
        $konfPass = (string) $this->request->getPost('konfirmasi_password');

        if ($passBaru !== '' || $konfPass !== '') {
            $rules['password_lama'] = [
                'rules'  => 'required',
                'errors' => ['required' => 'Kata sandi saat ini wajib diisi untuk mengganti kata sandi.'],
            ];
            $rules['password_baru'] = [
                'rules'  => 'required|min_length[8]|max_length[72]',
                'errors' => [
                    'required'   => 'Kata sandi baru wajib diisi.',
                    'min_length' => 'Kata sandi baru minimal 8 karakter.',
                ],
            ];
            $rules['konfirmasi_password'] = [
                'rules'  => 'required|matches[password_baru]',
                'errors' => [
                    'required' => 'Konfirmasi kata sandi wajib diisi.',
                    'matches'  => 'Konfirmasi kata sandi baru tidak cocok.',
                ],
            ];
        }

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('dashboard/profil'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        if ($passBaru !== '' && ! password_verify($passLama, $userExist['kata_sandi'])) {
            return redirect()->to(base_url('dashboard/profil'))
                ->withInput()
                ->with('error', 'Kata sandi saat ini tidak sesuai.');
        }

        $namaBaru  = trim((string) $this->request->getPost('nama_lengkap'));
        $emailBaru = strtolower(trim((string) $this->request->getPost('email')));
        $identitas = trim((string) $this->request->getPost('identitas'));

        $dataUpdate = [
            'nama_lengkap'    => $namaBaru,
            'email_institusi' => $emailBaru,
            $idCol            => $identitas,
        ];

        if ($role === 'mahasiswa') {
            $idProdi                       = (int) $this->request->getPost('id_prodi');
            $portofolio                    = trim((string) $this->request->getPost('portofolio_link'));
            $bio                           = trim((string) $this->request->getPost('bio_singkat'));
            $dataUpdate['id_prodi']        = $idProdi;
            $dataUpdate['bio_singkat']     = $bio !== '' ? $bio : null;
            $dataUpdate['portofolio_link'] = $portofolio !== '' ? $portofolio : null;
        } else {
            $dataUpdate['departemen'] = trim((string) $this->request->getPost('departemen'));
        }

        if ($passBaru !== '') {
            $dataUpdate['kata_sandi'] = password_hash($passBaru, PASSWORD_BCRYPT);
        }

        $model->update($id, $dataUpdate);

        $sessionUpdate = [
            'nama_lengkap' => $namaBaru,
            'email'        => $emailBaru,
        ];
        if ($role === 'mahasiswa') {
            $sessionUpdate['id_prodi'] = (int) $dataUpdate['id_prodi'];
        }
        session()->set($sessionUpdate);

        return redirect()->to(base_url('dashboard/profil'))
            ->with('pesan', 'Profil akun Anda berhasil diperbarui.');
    }

    public function simpanKarya()
    {
        $jenisKarya       = (string) $this->request->getPost('jenis_karya');
        $kategoriDiizinkan = KaryaModel::getKategoriByJenis($jenisKarya);
        $inListKategori    = implode(',', $kategoriDiizinkan);

        $rules = [
            'judul_karya' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Judul karya wajib diisi.',
                    'min_length' => 'Judul karya minimal 3 karakter.',
                ],
            ],
            'deskripsi' => [
                'rules'  => 'required|min_length[15]|max_length[5000]',
                'errors' => [
                    'required'   => 'Deskripsi karya wajib diisi.',
                    'min_length' => 'Deskripsi karya minimal 15 karakter agar kurator memahami konsep Anda.',
                ],
            ],
            'jenis_karya' => [
                'rules'  => 'required|in_list[DIGITAL,FISIK]',
                'errors' => [
                    'required' => 'Jenis karya wajib dipilih.',
                    'in_list'  => 'Pilihan jenis karya tidak valid.',
                ],
            ],
            'tipe_karya' => [
                'rules'  => $inListKategori !== '' ? "required|in_list[{$inListKategori}]" : 'required',
                'errors' => [
                    'required' => 'Kategori spesifik karya wajib dipilih.',
                    'in_list'  => 'Kategori karya tidak sesuai dengan jenis karya yang dipilih.',
                ],
            ],
            'pakta_integritas' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Anda wajib menyetujui Pakta Integritas HKI.'],
            ],
            'izin_publikasi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Anda wajib menyetujui Izin Publikasi Dokumentasi.'],
            ],
            'file_karya' => [
                'rules'  => 'uploaded[file_karya]|max_size[file_karya,5120]|is_image[file_karya]|mime_in[file_karya,image/jpg,image/jpeg,image/png]|ext_in[file_karya,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'Poster / cuplikan visual karya wajib diunggah.',
                    'max_size' => 'Ukuran file poster maksimal 5 MB.',
                    'is_image' => 'File poster harus berupa gambar yang valid.',
                    'mime_in'  => 'Format gambar hanya mendukung JPG/JPEG atau PNG.',
                    'ext_in'   => 'Ekstensi file gambar harus .jpg, .jpeg, atau .png.',
                ],
            ],
        ];

        if ($jenisKarya === 'DIGITAL') {
            $rules['tautan_karya'] = [
                'rules'  => 'required|valid_url_strict[https,http]|max_length[255]',
                'errors' => [
                    'required'         => 'Tautan eksternal karya digital wajib diisi.',
                    'valid_url_strict' => 'Tautan karya harus berupa URL valid yang diawali http:// atau https://.',
                ],
            ];
        } elseif ($jenisKarya === 'FISIK') {
            $rules['dimensi_karya']     = 'required|max_length[100]';
            $rules['material_media']    = 'required|max_length[255]';
            $rules['kebutuhan_display'] = 'required|max_length[2000]';
            $rules['estimasi_biaya']    = 'permit_empty|max_length[100]';

            $fileRab = $this->request->getFile('file_rab');
            if ($fileRab && $fileRab->getError() !== UPLOAD_ERR_NO_FILE) {
                $rules['file_rab'] = [
                    'rules'  => 'max_size[file_rab,10240]|ext_in[file_rab,pdf,xls,xlsx]|mime_in[file_rab,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/octet-stream]',
                    'errors' => [
                        'max_size' => 'Ukuran berkas RAB maksimal 10 MB.',
                        'ext_in'   => 'Berkas RAB hanya mendukung format .pdf, .xls, atau .xlsx.',
                        'mime_in'  => 'Tipe berkas RAB tidak valid (gunakan PDF atau Excel).',
                    ],
                ];
            }
        }

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imgDir = FCPATH . 'uploads/img';
        $rabDir = FCPATH . 'uploads/rab';
        if (! is_dir($imgDir)) {
            mkdir($imgDir, 0755, true);
        }
        if (! is_dir($rabDir)) {
            mkdir($rabDir, 0755, true);
        }

        $fileGambar   = $this->request->getFile('file_karya');
        $namaFileBaru = $fileGambar->getRandomName();
        $fileGambar->move($imgDir, $namaFileBaru);
        $relativeImgPath = 'uploads/img/' . $namaFileBaru;

        $relativeRabPath = null;
        if ($jenisKarya === 'FISIK') {
            $fileRab = $this->request->getFile('file_rab');
            if ($fileRab && $fileRab->isValid() && ! $fileRab->hasMoved()) {
                $namaUnikRab = $fileRab->getRandomName();
                $fileRab->move($rabDir, $namaUnikRab);
                $relativeRabPath = 'uploads/rab/' . $namaUnikRab;
            }
        }

        $karyaModel = new KaryaModel();
        $estimasi   = trim((string) $this->request->getPost('estimasi_biaya'));

        $karyaModel->insert([
            'id_mahasiswa'      => (int) session()->get('id'),
            'judul_karya'       => trim((string) $this->request->getPost('judul_karya')),
            'deskripsi'         => trim((string) $this->request->getPost('deskripsi')),
            'tipe_karya'        => trim((string) $this->request->getPost('tipe_karya')),
            'jenis_karya'       => $jenisKarya,
            'file_path'         => $relativeImgPath,
            'dimensi_karya'     => $jenisKarya === 'FISIK' ? trim((string) $this->request->getPost('dimensi_karya')) : null,
            'material_media'    => $jenisKarya === 'FISIK' ? trim((string) $this->request->getPost('material_media')) : null,
            'kebutuhan_display' => $jenisKarya === 'FISIK' ? trim((string) $this->request->getPost('kebutuhan_display')) : null,
            'estimasi_biaya'    => ($jenisKarya === 'FISIK' && $estimasi !== '') ? $estimasi : null,
            'file_rab'          => $relativeRabPath,
            'tautan_karya'      => $jenisKarya === 'DIGITAL' ? trim((string) $this->request->getPost('tautan_karya')) : null,
            'status_kurasi'     => 'PENDING',
        ]);

        return redirect()->to(base_url('dashboard'))
            ->with('pesan', 'Karya berhasil diajukan dan sedang menunggu tinjauan Kurator!');
    }

    public function updateStatusKarya()
    {
        $statusBaru = (string) $this->request->getPost('status_kurasi');

        $rules = [
            'id_karya'      => 'required|is_natural_no_zero',
            'status_kurasi' => 'required|in_list[ACCEPTED,REJECTED]',
        ];

        if ($statusBaru === 'REJECTED') {
            $rules['catatan_kurator'] = [
                'rules'  => 'required|min_length[5]|max_length[2000]',
                'errors' => [
                    'required'   => 'Alasan penolakan wajib diisi agar mahasiswa menerima evaluasi yang jelas.',
                    'min_length' => 'Catatan penolakan minimal 5 karakter.',
                ],
            ];
        } else {
            $rules['catatan_kurator'] = 'permit_empty|max_length[2000]';
        }

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('dashboard/admin'))
                ->with('errors', $this->validator->getErrors());
        }

        $idKarya    = (int) $this->request->getPost('id_karya');
        $feedback   = trim((string) $this->request->getPost('catatan_kurator'));
        $karyaModel = new KaryaModel();

        $karya = $karyaModel->find($idKarya);
        if (! $karya) {
            return redirect()->to(base_url('dashboard/admin'))
                ->with('error', 'Data karya tidak ditemukan.');
        }

        $karyaModel->update($idKarya, [
            'status_kurasi'    => $statusBaru,
            'catatan_kurator'  => $feedback !== '' ? $feedback : null,
            'id_kurator'       => (int) session()->get('id'),
            'tanggal_tinjauan' => date('Y-m-d H:i:s'),
        ]);

        $pesan = $statusBaru === 'ACCEPTED'
            ? 'Karya "' . $karya['judul_karya'] . '" berhasil disetujui dan dipublikasikan ke Galeri!'
            : 'Karya "' . $karya['judul_karya'] . '" telah ditolak beserta catatan evaluasi kurator.';

        return redirect()->to(base_url('dashboard/admin'))
            ->with('pesan', $pesan);
    }

    public function hapusKarya()
    {
        $idKarya    = (int) $this->request->getPost('id_karya');
        $karyaModel = new KaryaModel();
        $karya      = $karyaModel->find($idKarya);

        if (! $karya || (int) $karya['id_mahasiswa'] !== (int) session()->get('id')) {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Karya tidak ditemukan atau Anda tidak berhak menghapus pengajuan ini.');
        }

        if ($karya['status_kurasi'] !== 'PENDING') {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Karya yang sudah selesai dikurasi tidak dapat dibatalkan.');
        }

        $karyaModel->delete($idKarya);

        // Bersihkan berkas fisik terkait apabila tidak direferensikan oleh entri lain
        $this->hapusBerkasLokalAman($karya['file_path'] ?? null, 'uploads/img/', $karyaModel, 'file_path');
        $this->hapusBerkasLokalAman($karya['file_rab'] ?? null, 'uploads/rab/', $karyaModel, 'file_rab');

        return redirect()->to(base_url('dashboard'))
            ->with('pesan', 'Pengajuan karya berhasil dibatalkan dan dihapus.');
    }

    public function tambahKurator()
    {
        $rules = [
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => ['required' => 'Nama lengkap kurator wajib diisi.'],
            ],
            'nip_dosen' => [
                'rules'  => 'required|alpha_numeric|min_length[5]|max_length[20]|is_unique[kurator.nip_dosen]',
                'errors' => [
                    'required'  => 'NIP / ID Kurator wajib diisi.',
                    'is_unique' => 'NIP / ID Kurator ini sudah terdaftar.',
                ],
            ],
            'email_institusi' => [
                'rules'  => 'required|valid_email|max_length[150]|is_unique[kurator.email_institusi]',
                'errors' => [
                    'required'    => 'Email institusi wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email ini sudah terdaftar sebagai kurator.',
                ],
            ],
            'departemen' => 'required|min_length[3]|max_length[150]',
            'password'   => [
                'rules'  => 'required|min_length[8]|max_length[72]',
                'errors' => [
                    'required'   => 'Kata sandi awal wajib diisi.',
                    'min_length' => 'Kata sandi minimal 8 karakter.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('dashboard/admin'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $kuratorModel = new KuratorModel();
        $kuratorModel->insert([
            'nama_lengkap'    => trim((string) $this->request->getPost('nama_lengkap')),
            'nip_dosen'       => trim((string) $this->request->getPost('nip_dosen')),
            'email_institusi' => strtolower(trim((string) $this->request->getPost('email_institusi'))),
            'departemen'      => trim((string) $this->request->getPost('departemen')),
            'kata_sandi'      => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to(base_url('dashboard/admin'))
            ->with('pesan', 'Akun Kurator baru berhasil ditambahkan.');
    }

    public function exportCSV()
    {
        $karyaModel = new KaryaModel();

        $dataKarya = $karyaModel->select('karya.judul_karya, mahasiswa.nama_lengkap as kreator, mahasiswa.nim, program_studi.nama_prodi as prodi, karya.jenis_karya, karya.tipe_karya, karya.tanggal_pengajuan, karya.status_kurasi, karya.tanggal_tinjauan, kurator.nama_lengkap as kurator_peninjau, karya.catatan_kurator')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
            ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
            ->join('kurator', 'kurator.id_kurator = karya.id_kurator', 'left')
            ->orderBy('karya.tanggal_pengajuan', 'DESC')
            ->findAll();

        $filename = 'Laporan_Karya_Spektra_' . date('Y-m-d_H-i') . '.csv';

        $stream = fopen('php://temp', 'r+');
        // UTF-8 BOM agar Microsoft Excel membaca karakter dengan akurat
        fwrite($stream, "\xEF\xBB\xBF");

        fputcsv($stream, [
            'Judul Karya',
            'Kreator',
            'NIM',
            'Program Studi',
            'Jenis Karya',
            'Kategori',
            'Tanggal Pengajuan',
            'Status Kurasi',
            'Tanggal Tinjauan',
            'Kurator Peninjau',
            'Catatan Kurator',
        ]);

        foreach ($dataKarya as $row) {
            fputcsv($stream, [
                sanitize_csv_cell($row['judul_karya']),
                sanitize_csv_cell($row['kreator']),
                sanitize_csv_cell($row['nim']),
                sanitize_csv_cell($row['prodi'] ?? 'Polimedia'),
                sanitize_csv_cell($row['jenis_karya']),
                sanitize_csv_cell($row['tipe_karya']),
                sanitize_csv_cell($row['tanggal_pengajuan']),
                sanitize_csv_cell($row['status_kurasi']),
                sanitize_csv_cell($row['tanggal_tinjauan'] ?? '-'),
                sanitize_csv_cell($row['kurator_peninjau'] ?? '-'),
                sanitize_csv_cell($row['catatan_kurator'] ?? '-'),
            ]);
        }

        rewind($stream);
        $csvContent = stream_get_contents($stream);
        fclose($stream);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csvContent);
    }

    private function hapusBerkasLokalAman(?string $storedPath, string $expectedSubdir, KaryaModel $model, string $column): void
    {
        if (empty($storedPath)) {
            return;
        }

        $stillUsed = $model->where($column, $storedPath)->countAllResults();
        if ($stillUsed > 0) {
            return;
        }

        $basename = basename(parse_url($storedPath, PHP_URL_PATH) ?: $storedPath);
        if ($basename === '' || $basename === 'index.html' || $basename === '.htaccess') {
            return;
        }

        $fullPath = FCPATH . rtrim($expectedSubdir, '/') . DIRECTORY_SEPARATOR . $basename;
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
