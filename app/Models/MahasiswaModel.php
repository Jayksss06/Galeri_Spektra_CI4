<?php
namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id_mahasiswa';
    protected $allowedFields    = ['nim', 'nama_lengkap', 'email_institusi', 'kata_sandi', 'id_prodi', 'bio_singkat', 'portofolio_link'];
    protected $useTimestamps    = false;
}