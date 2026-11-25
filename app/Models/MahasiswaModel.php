<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table         = 'mahasiswa';
    protected $primaryKey    = 'id_mahasiswa';
    protected $allowedFields = [
        'nim',
        'nama_lengkap',
        'email_institusi',
        'kata_sandi',
        'id_prodi',
        'bio_singkat',
        'portofolio_link',
        'created_at',
    ];
    protected $useTimestamps = false;

    public function getProfilLengkap(int $idMahasiswa): ?array
    {
        return $this->select('mahasiswa.*, program_studi.nama_prodi')
            ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('mahasiswa.id_mahasiswa', $idMahasiswa)
            ->first();
    }
}
