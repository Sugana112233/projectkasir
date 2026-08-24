<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_nota', 'tanggal', 'id_kasir', 'id_pelanggan', 
        'total', 'bayar', 'kembali', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;
    protected $dateFormat = 'datetime';
    
    /**
     * Get pendapatan harian berdasarkan periode
     */
    public function getPendapatanHarian($start_date, $end_date)
    {
        return $this->db->table('transaksi t')
            ->select('DATE(t.tanggal) as tanggal, COALESCE(SUM(t.total), 0) as total, COUNT(t.id) as total_transaksi')
            ->where('DATE(t.tanggal) >=', $start_date)
            ->where('DATE(t.tanggal) <=', $end_date)
            ->where('t.status', 'selesai')
            ->groupBy('DATE(t.tanggal)')
            ->orderBy('DATE(t.tanggal)', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get total transaksi dan pendapatan
     */
    public function getTotalTransaksi($start_date, $end_date)
    {
        $result = $this->select('COUNT(*) as total_transaksi, COALESCE(SUM(total), 0) as total_pendapatan')
                    ->where('status', 'selesai')
                    ->where('DATE(tanggal) >=', $start_date)
                    ->where('DATE(tanggal) <=', $end_date)
                    ->first();
        
        return $result ?? ['total_transaksi' => 0, 'total_pendapatan' => 0];
    }
    
    /**
     * Get rata-rata transaksi per hari
     */
    public function getRataRataTransaksi($start_date, $end_date)
    {
        $total = $this->select('COALESCE(SUM(total), 0) as total')
                    ->where('status', 'selesai')
                    ->where('DATE(tanggal) >=', $start_date)
                    ->where('DATE(tanggal) <=', $end_date)
                    ->first();
        
        $total = $total['total'] ?? 0;
        
        $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1;
        $days = max(1, $days);
        
        return $total / $days;
    }
    
    /**
     * Get laporan transaksi untuk cetak
     */
    public function getLaporanTransaksi($start_date, $end_date)
    {
        return $this->select('transaksi.*, tblogin.nama as kasir')
                    ->join('tblogin', 'tblogin.id = transaksi.id_kasir', 'left')
                    ->where('status', 'selesai')
                    ->where('DATE(tanggal) >=', $start_date)
                    ->where('DATE(tanggal) <=', $end_date)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }
    
    /**
     * Get laporan keuangan lengkap untuk cetak/tampil
     */
    public function getLaporanKeuangan($start_date, $end_date)
    {
        $db = \Config\Database::connect();
        
        $sql = "SELECT 
                    DATE(t.tanggal) as tanggal,
                    COUNT(t.id) as jumlah_transaksi,
                    COALESCE(SUM(t.total), 0) as total_penjualan,
                    COALESCE((
                        SELECT SUM(pms.jumlah) 
                        FROM pemasukan pms 
                        WHERE DATE(pms.tanggal) = DATE(t.tanggal)
                    ), 0) as total_pemasukan,
                    COALESCE((
                        SELECT SUM(pgl.jumlah) 
                        FROM pengeluaran pgl 
                        WHERE DATE(pgl.tanggal) = DATE(t.tanggal)
                    ), 0) as total_pengeluaran
                FROM transaksi t
                WHERE t.status = 'selesai' 
                AND DATE(t.tanggal) BETWEEN '$start_date' AND '$end_date'
                GROUP BY DATE(t.tanggal)
                ORDER BY DATE(t.tanggal) ASC";
        
        return $db->query($sql)->getResultArray();
    }
}