<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriPengeluaranModel extends Model
{
    protected $table = 'kategori_pengeluaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kategori', 'icon'];
    protected $useTimestamps = true;
}