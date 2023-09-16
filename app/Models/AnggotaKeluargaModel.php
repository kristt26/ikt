<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaKeluargaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'anggota_keluarga';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['keluarga_id', 'anggota_id'];

}