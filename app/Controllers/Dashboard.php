<?php

namespace App\Controllers;

use App\Models\KaryaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'mahasiswa') return redirect()->to('/');

        $karyaModel = new KaryaModel();
        $idMahasiswa = session()->get('id');

        $data['riwayat'] = $karyaModel->where('id_mahasiswa', $idMahasiswa)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();

        $data['statistik'] = [
            'total'     => $karyaModel->where('id_mahasiswa', $idMahasiswa)->countAllResults(),
            'disetujui' => $karyaModel->where('id_mahasiswa', $idMahasiswa)->where('status_kurasi', 'ACCEPTED')->countAllResults(),
            'review'    => $karyaModel->where('id_mahasiswa', $idMahasiswa)->where('status_kurasi', 'PENDING')->countAllResults(),
        ];

        $data['title'] = 'Dasbor Mahasiswa';
        echo view('layout/header', $data);
        echo view('dashboard/mahasiswa', $data);
        echo view('layout/footer');
    }

    public function ajukanKarya()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $data = ['title' => 'Ajukan Karya'];
        echo view('layout/header', $data);
        echo view('dashboard/ajukan_karya', $data);
        echo view('layout/footer');
    }

    public function admin()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') return redirect()->to('/');

        $karyaModel = new \App\Models\KaryaModel();

        $data['daftar_karya'] = $karyaModel->getKaryaTerbaru();

        $data['total_pending']   = $karyaModel->where('status_kurasi', 'PENDING')->countAllResults();
        $data['total_published'] = $karyaModel->where('status_kurasi', 'ACCEPTED')->countAllResults();

        $data['title'] = 'Dasbor Kurator';

        echo view('layout/header', $data);
        echo view('dashboard/admin', $data);
        echo view('layout/footer');
    }

    public function profil()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Profil Akun - Galeri Spektra'
        ];

        echo view('layout/header', $data);
        echo view('dashboard/profil', $data);
        echo view('layout/footer');
    }

    public function updateProfil()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $role      = session()->get('role');
        $id        = session()->get('id'); 
        $namaBaru  = $this->request->getPost('nama_lengkap');
        $emailBaru = $this->request->getPost('email');
        $passBaru  = $this->request->getPost('password_baru');
        $konfPass  = $this->request->getPost('konfirmasi_password');

        if (!empty($passBaru)) {
            if ($passBaru !== $konfPass) {
                session()->setFlashdata('error', 'Konfirmasi kata sandi baru tidak cocok.');
                return redirect()->to(base_url('dashboard/profil'));
            }
        }

        $dataUpdate = [
            'nama_lengkap'    => $namaBaru,
            'email_institusi' => $emailBaru
        ];

        if (!empty($passBaru)) {
            $dataUpdate['kata_sandi'] = password_hash($passBaru, PASSWORD_BCRYPT);
        }

        if ($role === 'mahasiswa') {
            $model = new \App\Models\MahasiswaModel();
            $model->where('id_mahasiswa', $id)->set($dataUpdate)->update();
        } else {
            $model = new \App\Models\KuratorModel();
            $model->where('id_kurator', $id)->set($dataUpdate)->update();
        }

        session()->set([
            'nama_lengkap' => $namaBaru,
            'email'        => $emailBaru
        ]);

        session()->setFlashdata('pesan', 'Profil dan kata sandi Anda berhasil diperbarui.');
        return redirect()->to(base_url('dashboard/profil'));
    }

    public function simpanKarya()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $karyaModel = new KaryaModel();
        $fileGambar = $this->request->getFile('file_karya');

        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {

            $namaFileBaru = $fileGambar->getRandomName();
            $fileGambar->move(ROOTPATH . 'public/uploads/img/', $namaFileBaru);
            $filePath = base_url('uploads/img/' . $namaFileBaru);

            $jenisKarya = $this->request->getPost('jenis_karya');

            $namaFileRab = null;
            if ($jenisKarya === 'FISIK') {
                $fileRab = $this->request->getFile('file_rab');

                if ($fileRab && $fileRab->isValid() && !$fileRab->hasMoved()) {
                    $namaUnikRab = $fileRab->getRandomName();
                    $fileRab->move(ROOTPATH . 'public/uploads/rab/', $namaUnikRab);
                    $namaFileRab = base_url('uploads/rab/' . $namaUnikRab);
                }
            }

            $dataKarya = [
                'id_mahasiswa'      => session()->get('id'),
                'judul_karya'       => $this->request->getPost('judul_karya'),
                'deskripsi'         => $this->request->getPost('deskripsi'),
                'tipe_karya'        => $this->request->getPost('tipe_karya'),
                'jenis_karya'       => $jenisKarya,
                'file_path'         => $filePath,

                'dimensi_karya'     => $jenisKarya === 'FISIK' ? $this->request->getPost('dimensi_karya') : null,
                'material_media'    => $jenisKarya === 'FISIK' ? $this->request->getPost('material_media') : null,
                'kebutuhan_display' => $jenisKarya === 'FISIK' ? $this->request->getPost('kebutuhan_display') : null,
                'estimasi_biaya'    => $jenisKarya === 'FISIK' ? $this->request->getPost('estimasi_biaya') : null,
                'file_rab'          => $namaFileRab,

                'tautan_karya'      => $jenisKarya === 'DIGITAL' ? $this->request->getPost('tautan_karya') : null,

                'status_kurasi'     => 'PENDING'
            ];

            $karyaModel->save($dataKarya);

            session()->setFlashdata('pesan', 'Karya dan proposal pengadaan fisik berhasil diajukan!');
            return redirect()->to(base_url('dashboard'));
        }

        return redirect()->back();
    }

    public function updateStatusKarya()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $idKarya = $this->request->getPost('id_karya');
        $statusBaru = $this->request->getPost('status_kurasi');
        $feedback = $this->request->getPost('catatan_kurator');

        $karyaModel = new \App\Models\KaryaModel();

        $karyaModel->update($idKarya, [
            'status_kurasi'    => $statusBaru,
            'catatan_kurator'  => !empty($feedback) ? $feedback : null,
            'id_kurator'       => session()->get('id'),
            'tanggal_tinjauan' => date('Y-m-d H:i:s')
        ]);

        $pesan = $statusBaru === 'ACCEPTED' ? 'Karya fisik/digital disetujui untuk dipamerkan!' : 'Karya ditolak dengan catatan umpan balik.';
        session()->setFlashdata('pesan', $pesan);

        return redirect()->to(base_url('dashboard/admin'));
    }

    public function hapusKarya()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'mahasiswa') return redirect()->to('/');

        $idKarya = $this->request->getPost('id_karya');
        $karyaModel = new \App\Models\KaryaModel();

        $karya = $karyaModel->find($idKarya);
        if ($karya && $karya['id_mahasiswa'] === session()->get('id')) {
            $karyaModel->delete($idKarya);
            session()->setFlashdata('pesan', 'Pengajuan karya berhasil dibatalkan/dihapus.');
        }

        return redirect()->to(base_url('dashboard'));
    }

    public function exportCSV()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $karyaModel = new \App\Models\KaryaModel();

        $builder = $karyaModel->select('karya.judul_karya, mahasiswa.nama_lengkap as kreator, program_studi.nama_prodi as prodi, karya.tipe_karya, karya.tanggal_pengajuan, karya.status_kurasi')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
            ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
            ->orderBy('karya.tanggal_pengajuan', 'DESC');

        $dataKarya = $builder->get()->getResultArray();

        $filename = 'Laporan_Karya_Spektra_' . date('Y-m-d_H-i') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

        $header = ["Judul Karya", "Kreator", "Program Studi", "Kategori", "Tanggal Pengajuan", "Status Kurasi"];
        fputcsv($file, $header);

        foreach ($dataKarya as $row) {
            fputcsv($file, [
                $row['judul_karya'],
                $row['kreator'],
                $row['prodi'] ?? 'Polimedia',
                $row['tipe_karya'],
                $row['tanggal_pengajuan'],
                $row['status_kurasi']
            ]);
        }

        fclose($file);
        exit; 
    }
}
