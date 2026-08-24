<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranModel extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_transaksi', 'tanggal', 'id_kategori', 
        'deskripsi', 'jumlah', 'bukti', 'id_user'
    ];
    
    // NONAKTIFKAN TIMESTAMPS (karena tabel tidak punya created_at & updated_at)
    protected $useTimestamps = false;
    
    public function getWithKategori()
    {
        return $this->select('pengeluaran.*, kategori_pengeluaran.nama_kategori, kategori_pengeluaran.icon')
                    ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.id_kategori', 'left')
                    ->orderBy('pengeluaran.tanggal', 'DESC')
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