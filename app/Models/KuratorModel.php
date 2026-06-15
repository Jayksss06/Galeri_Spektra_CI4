<?php

namespace App\Models;

use CodeIgniter\Model;

class KuratorModel extends Model
{
    protected $table            = 'kurator';
    protected $primaryKey       = 'id_kurator';
    protected $allowedFields    = ['nip_dosen', 'nama_lengkap', 'email_institusi', 'kata_sandi'];
    protected $useTimestamps    = false;
}
