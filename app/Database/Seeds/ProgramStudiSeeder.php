<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $daftarProdi = [
            ['id_prodi' => 1, 'nama_prodi' => 'Teknologi Rekayasa Multimedia'],
            ['id_prodi' => 2, 'nama_prodi' => 'Desain Grafis'],
            ['id_prodi' => 3, 'nama_prodi' => 'Fotografi'],
            ['id_prodi' => 4, 'nama_prodi' => 'Animasi'],
            ['id_prodi' => 5, 'nama_prodi' => 'Penerbitan'],
        ];

        foreach ($daftarProdi as $prodi) {
            $exists = $this->db->table('program_studi')
                ->where('nama_prodi', $prodi['nama_prodi'])
                ->countAllResults();

            if ($exists === 0) {
                $this->db->table('program_studi')->insert($prodi);
            }
        }
    }
}
