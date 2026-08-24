<?php

namespace App\Models;

use CodeIgniter\Model;

class KasirModel extends Model
{
    protected $table = 'tblogin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nik', 'nama', 'password', 'level', 'status'];
    protected $useTimestamps = true;
    
    public function getKasirTeraktif($start_date, $end_date, $limit = 5)
    {
        $db = \Config\Database::connect();
        
        $sql = "SELECT 
                    k.nama,
                    COALESCE(COUNT(t.id), 0) as transaksi,
                    COALESCE(SUM(t.total), 0) as pendapatan
                FROM tblogin k
                LEFT JOIN transaksi t ON t.id_kasir = k.id 
                    AND t.status = 'selesai'
                    AND DATE(t.tanggal) BETWEEN '$start_date' AND '$end_date'
                WHERE k.level = 'kasir'
                GROUP BY k.id
                ORDER BY transaksi DESC
                LIMIT $limit";
        
        return $db->query($sql)->getResultArray();
    }
}