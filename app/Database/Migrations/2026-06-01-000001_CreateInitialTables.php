<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateInitialTables extends Migration
{
    public function up(): void
    {
        $attributes = $this->db->DBDriver === 'MySQLi'
            ? ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']
            : [];

        // 1. Tabel program_studi
        $this->forge->addField([
            'id_prodi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('id_prodi', true);
        $this->forge->addUniqueKey('nama_prodi');
        $this->forge->createTable('program_studi', true, $attributes);

        // 2. Tabel mahasiswa
        $this->forge->addField([
            'id_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'email_institusi' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'kata_sandi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_prodi' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'bio_singkat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'portofolio_link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_mahasiswa', true);
        $this->forge->addUniqueKey('nim');
        $this->forge->addUniqueKey('email_institusi');
        $this->forge->addKey('id_prodi');
        $this->forge->addForeignKey('id_prodi', 'program_studi', 'id_prodi', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('mahasiswa', true, $attributes);

        // 3. Tabel kurator
        $this->forge->addField([
            'id_kurator' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nip_dosen' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'email_institusi' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'kata_sandi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'departemen' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'default'    => 'Kurasi Seni & Multimedia',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_kurator', true);
        $this->forge->addUniqueKey('nip_dosen');
        $this->forge->addUniqueKey('email_institusi');
        $this->forge->createTable('kurator', true, $attributes);

        // 4. Tabel karya
        $this->forge->addField([
            'id_karya' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'id_mahasiswa' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'judul_karya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'tipe_karya' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'jenis_karya' => [
                'type'       => 'ENUM',
                'constraint' => ['DIGITAL', 'FISIK'],
                'default'    => 'DIGITAL',
            ],
            'dimensi_karya' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'material_media' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'kebutuhan_display' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estimasi_biaya' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'file_rab' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tautan_karya' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tech_stack' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'jumlah_dilihat' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'status_kurasi' => [
                'type'       => 'ENUM',
                'constraint' => ['PENDING', 'ACCEPTED', 'REJECTED'],
                'default'    => 'PENDING',
            ],
            'id_kurator' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'tanggal_pengajuan' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'tanggal_tinjauan' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'catatan_kurator' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_karya', true);
        $this->forge->addKey('id_mahasiswa');
        $this->forge->addKey('id_kurator');
        $this->forge->addKey('status_kurasi');
        $this->forge->addForeignKey('id_mahasiswa', 'mahasiswa', 'id_mahasiswa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kurator', 'kurator', 'id_kurator', 'CASCADE', 'SET NULL');
        $this->forge->createTable('karya', true, $attributes);
    }

    public function down(): void
    {
        $this->forge->dropTable('karya', true);
        $this->forge->dropTable('mahasiswa', true);
        $this->forge->dropTable('kurator', true);
        $this->forge->dropTable('program_studi', true);
    }
}
