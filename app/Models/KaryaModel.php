<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryaModel extends Model
{
    protected $table            = 'karya';
    protected $primaryKey       = 'id_karya';
    protected $allowedFields    = ['id_mahasiswa', 'judul_karya', 'deskripsi', 'tipe_karya', 'file_path', 'tech_stack', 'status_kurasi', 'id_kurator', 'tanggal_pengajuan', 'tanggal_tinjauan', 'jenis_karya', 'dimensi_karya', 'material_media', 'kebutuhan_display', 'estimasi_biaya', 'file_rab', 'catatan_kurator', 'tautan_karya'];
    protected $useTimestamps    = false;

    public function getKaryaTerbaru()
    {
        return $this->select('karya.*, mahasiswa.nama_lengkap as kreator, program_studi.nama_prodi as prodi')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
            ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
            ->orderBy('karya.tanggal_pengajuan', 'DESC')
            ->findAll();
    }

    public function getKaryaPublik($search = null, $kategori = null, $sort = 'terbaru')
    {
        $builder = $this->select('karya.*, mahasiswa.nama_lengkap as kreator, program_studi.nama_prodi as prodi')
                        ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
                        ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
                        ->where('karya.status_kurasi', 'ACCEPTED');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('karya.judul_karya', $search)
                    ->orLike('mahasiswa.nama_lengkap', $search)
                    ->groupEnd();
        }

        if (!empty($kategori)) {
            $builder->where('karya.tipe_karya', $kategori);
        }

        if ($sort === 'terlama') {
            $builder->orderBy('karya.tanggal_tinjauan', 'ASC');
        } else {
            $builder->orderBy('karya.tanggal_tinjauan', 'DESC'); 
        }

        return $builder->findAll();
    }

    public function getKaryaTerbaik($limit = 3)
    {
        return $this->select('karya.*, mahasiswa.nama_lengkap as kreator, program_studi.nama_prodi as prodi')
                    ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
                    ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
                    ->where('karya.status_kurasi', 'ACCEPTED')
                    ->orderBy('karya.tanggal_tinjauan', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

}
