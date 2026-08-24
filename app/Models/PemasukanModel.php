<?php

namespace App\Models;

use CodeIgniter\Model;

class PemasukanModel extends Model
{
    protected $table = 'pemasukan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_transaksi', 'tanggal', 'id_kategori', 
        'deskripsi', 'jumlah', 'sumber', 'id_user'
    ];
    
    // NONAKTIFKAN TIMESTAMPS
    protected $useTimestamps = false;
    
    public function getWithKategori()
    {
        return $this->select('pemasukan.*, kategori_pemasukan.nama_kategori, kategori_pemasukan.icon')
                    ->join('kategori_pemasukan', 'kategori_pemasukan.id = pemasukan.id_kategori', 'left')
                    ->orderBy('pemasukan.tanggal', 'DESC')
                    ->findAll();
    }
    
    public function getTotalByPeriode($start_date, $end_date)
    {
        $result = $this->selectSum('jumlah')
                    ->where('tanggal >=', $start_date)
                    ->where('tanggal <=', $end_date)
                    ->first();
        
        return $result['jumlah'] ?? 0;
    }
}