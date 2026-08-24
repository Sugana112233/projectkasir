<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisProdukModel extends Model
{
    protected $table = 'tbjenis';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_jenis', 'nama_jenis', 'keterangan', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Get jenis produk aktif
     */
    public function getAktif()
    {
        return $this->where('status', 'aktif')
                   ->orderBy('nama_jenis', 'ASC')
                   ->findAll();
    }
    
    /**
     * Get jenis produk by ID
     */
    public function getJenisById($id)
    {
        return $this->find($id);
    }
    
    /**
     * Search jenis produk
     */
    public function search($keyword)
    {
        return $this->like('kode_jenis', $keyword)
                   ->orLike('nama_jenis', $keyword)
                   ->findAll();
    }
}