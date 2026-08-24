<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'tbproduk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'kode_produk', 'nama_produk', 'deskripsi', 'id_jenis', 
        'harga_beli', 'harga_jual', 'stok', 
        'stok_minimal', 'satuan', 'keterangan', 'foto', 'status'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    // CEK DUPLIKAT SEBELUM INSERT
    public function cekDuplikat($kode_produk)
    {
        return $this->where('kode_produk', $kode_produk)->first();
    }
    
    public function getProdukById($id)
    {
        return $this->find($id);
    }
    
    public function getProdukTerlaris($start_date, $end_date, $limit = 5)
    {
        $db = \Config\Database::connect();
        
        $sql = "SELECT 
                    p.nama_produk,
                    COALESCE(SUM(d.qty), 0) as terjual,
                    COALESCE(SUM(d.subtotal), 0) as pendapatan
                FROM detail_transaksi d
                JOIN transaksi t ON t.id = d.id_transaksi
                JOIN tbproduk p ON p.id = d.id_produk
                WHERE t.status = 'selesai'
                AND DATE(t.tanggal) BETWEEN '$start_date' AND '$end_date'
                GROUP BY d.id_produk
                ORDER BY terjual DESC
                LIMIT $limit";
        
        return $db->query($sql)->getResultArray();
    }
    
    public function getAktif()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('nama_produk', 'ASC')
                    ->findAll();
    }
    
    public function search($keyword)
    {
        return $this->like('kode_produk', $keyword)
                    ->orLike('nama_produk', $keyword)
                    ->where('status', 'aktif')
                    ->findAll();
    }
    
   // Ambil produk yang stoknya di bawah atau sama dengan stok_minimal
    public function getStokMenipis()
    {
        return $this->select('tbproduk.*, tbjenis.nama_jenis')
                    ->join('tbjenis', 'tbjenis.id = tbproduk.id_jenis', 'left')
                    ->where('stok <= stok_minimal', null, false) // 'false' agar 'stok_minimal' dibaca sebagai nama kolom, bukan string
                    ->where('status', 'aktif')
                    ->orderBy('stok', 'ASC')
                    ->findAll();
    }

    // Hitung jumlah produk yang stoknya menipis
    public function countStokMenipis()
    {
        return $this->where('stok <= stok_minimal', null, false)
                    ->where('status', 'aktif')
                    ->countAllResults();
    }
    // Method baru untuk mengambil data produk beserta relasi ke jenis produk
    public function getProdukWithJenis()
    {
        return $this->select('tbproduk.*, tbjenis.nama_jenis, tbjenis.kode_jenis')
                    ->join('tbjenis', 'tbjenis.id = tbproduk.id_jenis', 'left')
                    ->orderBy('tbproduk.id', 'DESC')
                    ->findAll();
    }
}