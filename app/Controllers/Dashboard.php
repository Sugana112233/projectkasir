<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\ProdukModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $transaksiModel;
    protected $produkModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->produkModel = new ProdukModel();
        $this->userModel = new UserModel();
        
        // Cek session kasir
        if (!session()->get('logged_in') || session()->get('level') != 'kasir') {
            redirect()->to('/kasir/auth/login')->send();
            exit();
        }
    }
    
    public function index()
    {
        $kasir_id = session()->get('user_id');
        $today = date('Y-m-d');
        
        // Statistik harian
        $transaksi_hari_ini = $this->transaksiModel
            ->where('id_kasir', $kasir_id)
            ->where('DATE(tanggal)', $today)
            ->countAllResults();
        
        $pendapatan_hari_ini = $this->transaksiModel
            ->selectSum('total')
            ->where('id_kasir', $kasir_id)
            ->where('DATE(tanggal)', $today)
            ->first();
        
        $pendapatan_hari_ini = $pendapatan_hari_ini['total'] ?? 0;
        
        // Total transaksi semua
        $total_transaksi = $this->transaksiModel
            ->where('id_kasir', $kasir_id)
            ->countAllResults();
        
        $total_pendapatan = $this->transaksiModel
            ->selectSum('total')
            ->where('id_kasir', $kasir_id)
            ->first();
        
        $total_pendapatan = $total_pendapatan['total'] ?? 0;
        
        // Transaksi terbaru (tanpa join pelanggan dulu)
        $transaksi_terbaru = $this->transaksiModel
            ->where('id_kasir', $kasir_id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->findAll();
        
        $data = [
            'title' => 'Dashboard Kasir',
            'user' => [
                'id' => session()->get('user_id'),
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'dashboard',
            'transaksi_hari_ini' => $transaksi_hari_ini,
            'pendapatan_hari_ini' => $pendapatan_hari_ini,
            'total_transaksi' => $total_transaksi,
            'total_pendapatan' => $total_pendapatan,
            'transaksi_terbaru' => $transaksi_terbaru
        ];
        
        return view('kasir/dashboard/index', $data);
    }
}