<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SyncExistingSchemaAndData extends Migration
{
    public function up(): void
    {
        // 1. Ubah karya.tipe_karya dari ENUM sempit menjadi VARCHAR(100) agar mendukung seluruh sub-kategori
        $this->forge->modifyColumn('karya', [
            'tipe_karya' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        // 2. Tambahkan kolom jumlah_dilihat pada karya jika belum ada
        if (! $this->db->fieldExists('jumlah_dilihat', 'karya')) {
            $this->forge->addColumn('karya', [
                'jumlah_dilihat' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'default'    => 0,
                    'after'      => 'tech_stack',
                ],
            ]);
        }

        // 3. Tambahkan kolom created_at pada mahasiswa jika belum ada
        if (! $this->db->fieldExists('created_at', 'mahasiswa')) {
            $this->forge->addColumn('mahasiswa', [
                'created_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ],
            ]);
        }

        // 4. Tambahkan kolom departemen & created_at pada kurator jika belum ada
        if (! $this->db->fieldExists('departemen', 'kurator')) {
            $this->forge->addColumn('kurator', [
                'departemen' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                    'default'    => 'Kurasi Seni & Multimedia',
                ],
            ]);
        }

        if (! $this->db->fieldExists('created_at', 'kurator')) {
            $this->forge->addColumn('kurator', [
                'created_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ],
            ]);
        }

        // 5. Normalisasi data lama: perbaiki tipe_karya kosong akibat bug ENUM sebelumnya
        $this->db->table('karya')
            ->where('tipe_karya', 'Digital Artwork')
            ->set('tipe_karya', 'Desain Grafis / Ilustrasi')
            ->update();

        $this->db->table('karya')
            ->where('tipe_karya', '')
            ->where('jenis_karya', 'FISIK')
            ->set('tipe_karya', 'Instalasi Seni Ruang')
            ->update();

        $this->db->table('karya')
            ->where('tipe_karya', '')
            ->set('tipe_karya', 'Desain Grafis / Ilustrasi')
            ->update();

        // 6. Konversi URL absolut localhost pada file_path dan file_rab menjadi path relatif portabel
        $rows = $this->db->table('karya')->select('id_karya, file_path, file_rab')->get()->getResultArray();
        foreach ($rows as $row) {
            $updates = [];

            if (! empty($row['file_path']) && preg_match('#^https?://[^/]+/(?:galeri_spektra/public/)?(uploads/.+)$#i', $row['file_path'], $m)) {
                $updates['file_path'] = $m[1];
            }

            if (! empty($row['file_rab']) && preg_match('#^https?://[^/]+/(?:galeri_spektra/public/)?(uploads/.+)$#i', $row['file_rab'], $m)) {
                $updates['file_rab'] = $m[1];
            }

            if (! empty($updates)) {
                $this->db->table('karya')->where('id_karya', $row['id_karya'])->update($updates);
            }
        }
    }

    public function down(): void
    {
        if ($this->db->fieldExists('jumlah_dilihat', 'karya')) {
            $this->forge->dropColumn('karya', 'jumlah_dilihat');
        }
        if ($this->db->fieldExists('created_at', 'mahasiswa')) {
            $this->forge->dropColumn('mahasiswa', 'created_at');
        }
        if ($this->db->fieldExists('departemen', 'kurator')) {
            $this->forge->dropColumn('kurator', 'departemen');
        }
        if ($this->db->fieldExists('created_at', 'kurator')) {
            $this->forge->dropColumn('kurator', 'created_at');
        }
    }
}
