<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_transaksi', 'id_produk', 'kode_produk', 
        'nama_produk', 'harga', 'qty', 'subtotal'
    ];
    protected $useTimestamps = false;
}