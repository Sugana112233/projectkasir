<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ProdukModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $produkModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->produkModel = new ProdukModel();
    }
    
    public function index()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        // Hitung statistik berdasarkan data aktual
        $totalKasir = $this->userModel->where('level', 'kasir')->countAllResults();
        $totalKasirAktif = $this->userModel->where('level', 'kasir')->where('status', 'aktif')->countAllResults();
        $totalProduk = $this->produkModel->countAll() ?? 0;
        
        // Data untuk view
        $data = [
            'title' => 'Dashboard Admin - Kasir Bangunan',
            'active_menu' => 'dashboard',
            'user' => [
                'nama' => session()->get('nama') ?? 'Administrator',
                'nik' => session()->get('nik') ?? '-',
                'level' => session()->get('level') ?? 'admin'
            ],
            'total_produk' => $totalProduk,
            'total_kasir_aktif' => $totalKasirAktif,
            'total_kasir' => $totalKasir
        ];
        
        return view('admin/dashboard', $data);
    }
}