<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KuratorSeeder extends Seeder
{
    public function run(): void
    {
        $totalKurator = $this->db->table('kurator')->countAllResults();

        if ($totalKurator === 0) {
            $this->db->table('kurator')->insert([
                'nip_dosen'       => '198805122015041001',
                'nama_lengkap'    => 'Kurator Utama Spektra',
                'email_institusi' => 'kurator@polimedia.ac.id',
                'kata_sandi'      => password_hash('SpektraPolimedia2026!', PASSWORD_BCRYPT),
                'departemen'      => 'Kurasi Seni & Multimedia',
            ]);
        }
    }
}
