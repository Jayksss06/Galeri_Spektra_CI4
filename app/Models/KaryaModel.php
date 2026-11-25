<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryaModel extends Model
{
    public const KATEGORI_DIGITAL = [
        'Desain Grafis / Ilustrasi',
        'UI/UX Design',
        'Video / Film Pendek',
        'Animasi 2D/3D',
        'Pengembangan Game',
        'Fotografi Digital',
        'Karya Audio / Podcast',
    ];

    public const KATEGORI_FISIK = [
        'Instalasi Seni Ruang',
        'Maket / Prototipe Produk',
        'Lukisan / Media Kanvas',
        'Kriya / Kerajinan Tangan',
        'Fotografi Cetak Terbingkai',
        'Patung / 3D Art Manual',
        'Media Cetak / Buku / Zine',
    ];

    protected $table         = 'karya';
    protected $primaryKey    = 'id_karya';
    protected $allowedFields = [
        'id_mahasiswa',
        'judul_karya',
        'deskripsi',
        'tipe_karya',
        'file_path',
        'tech_stack',
        'jumlah_dilihat',
        'status_kurasi',
        'id_kurator',
        'tanggal_pengajuan',
        'tanggal_tinjauan',
        'jenis_karya',
        'dimensi_karya',
        'material_media',
        'kebutuhan_display',
        'estimasi_biaya',
        'file_rab',
        'catatan_kurator',
        'tautan_karya',
    ];
    protected $useTimestamps = false;

    public static function getKategoriByJenis(string $jenis): array
    {
        if ($jenis === 'FISIK') {
            return self::KATEGORI_FISIK;
        }
        if ($jenis === 'DIGITAL') {
            return self::KATEGORI_DIGITAL;
        }

        return [];
    }

    public static function getAllKategori(): array
    {
        return array_merge(self::KATEGORI_DIGITAL, self::KATEGORI_FISIK);
    }

    public function getKaryaTerbaru(): array
    {
        return $this->select('karya.*, mahasiswa.nama_lengkap as kreator, program_studi.nama_prodi as prodi, kurator.nama_lengkap as nama_kurator')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
            ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
            ->join('kurator', 'kurator.id_kurator = karya.id_kurator', 'left')
            ->orderBy('karya.tanggal_pengajuan', 'DESC')
            ->findAll();
    }

    public function getKaryaPublikPaginated(?string $search = null, ?string $kategori = null, string $sort = 'terbaru', int $perPage = 9): array
    {
        $this->select('karya.*, mahasiswa.nama_lengkap as kreator, program_studi.nama_prodi as prodi')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
            ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('karya.status_kurasi', 'ACCEPTED');

        if (! empty($search)) {
            $this->groupStart()
                ->like('karya.judul_karya', $search)
                ->orLike('karya.deskripsi', $search)
                ->orLike('mahasiswa.nama_lengkap', $search)
                ->groupEnd();
        }

        if (! empty($kategori)) {
            $this->where('karya.tipe_karya', $kategori);
        }

        if ($sort === 'terlama') {
            $this->orderBy('karya.tanggal_tinjauan', 'ASC')
                ->orderBy('karya.id_karya', 'ASC');
        } elseif ($sort === 'populer') {
            $this->orderBy('karya.jumlah_dilihat', 'DESC')
                ->orderBy('karya.tanggal_tinjauan', 'DESC');
        } else {
            $this->orderBy('karya.tanggal_tinjauan', 'DESC')
                ->orderBy('karya.id_karya', 'DESC');
        }

        return $this->paginate($perPage, 'galeri');
    }

    public function getKaryaTerbaik(int $limit = 8): array
    {
        return $this->select('karya.*, mahasiswa.nama_lengkap as kreator, program_studi.nama_prodi as prodi')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa = karya.id_mahasiswa')
            ->join('program_studi', 'program_studi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('karya.status_kurasi', 'ACCEPTED')
            ->orderBy('karya.tanggal_tinjauan', 'DESC')
            ->orderBy('karya.id_karya', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getDistribusiProdi(): array
    {
        $rows = $this->db->table('program_studi')
            ->select('program_studi.id_prodi, program_studi.nama_prodi, COUNT(karya.id_karya) as jumlah')
            ->join('mahasiswa', 'mahasiswa.id_prodi = program_studi.id_prodi', 'left')
            ->join('karya', 'karya.id_mahasiswa = mahasiswa.id_mahasiswa', 'left')
            ->groupBy('program_studi.id_prodi, program_studi.nama_prodi')
            ->orderBy('jumlah', 'DESC')
            ->orderBy('program_studi.nama_prodi', 'ASC')
            ->get()
            ->getResultArray();

        $totalKarya = array_sum(array_map(static fn ($r) => (int) $r['jumlah'], $rows));

        foreach ($rows as &$row) {
            $jumlah            = (int) $row['jumlah'];
            $row['jumlah']     = $jumlah;
            $row['persentase'] = $totalKarya > 0 ? round(($jumlah / $totalKarya) * 100, 1) : 0.0;
        }
        unset($row);

        return [
            'total_karya' => $totalKarya,
            'items'       => $rows,
        ];
    }

    public function incrementJumlahDilihat(int $idKarya): ?int
    {
        $karya = $this->where('id_karya', $idKarya)
            ->where('status_kurasi', 'ACCEPTED')
            ->first();

        if (! $karya) {
            return null;
        }

        $this->db->table($this->table)
            ->where('id_karya', $idKarya)
            ->set('jumlah_dilihat', 'jumlah_dilihat + 1', false)
            ->update();

        $updated = $this->select('jumlah_dilihat')->find($idKarya);

        return isset($updated['jumlah_dilihat']) ? (int) $updated['jumlah_dilihat'] : null;
    }
}
