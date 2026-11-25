<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramStudiModel extends Model
{
    protected $table         = 'program_studi';
    protected $primaryKey    = 'id_prodi';
    protected $allowedFields = ['nama_prodi'];
    protected $useTimestamps = false;

    public function getDaftarProdi(): array
    {
        return $this->orderBy('id_prodi', 'ASC')->findAll();
    }
}
