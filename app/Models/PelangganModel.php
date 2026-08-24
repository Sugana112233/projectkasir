<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_pelanggan', 'nama', 'no_telp', 'alamat'];
    protected $useTimestamps = true;
}