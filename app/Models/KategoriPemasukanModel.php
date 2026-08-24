<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriPemasukanModel extends Model
{
    protected $table = 'kategori_pemasukan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kategori', 'icon'];
    protected $useTimestamps = true;
}