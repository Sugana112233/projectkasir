<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengeluaranModel;
use App\Models\KategoriPengeluaranModel;

class Pengeluaran extends BaseController
{
    protected $pengeluaranModel;
    protected $kategoriModel;
    
    public function __construct()
    {
        $this->pengeluaranModel = new PengeluaranModel();
        $this->kategoriModel = new KategoriPengeluaranModel();
        
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            redirect()->to('/auth/login')->send();
            exit();
        }
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Pengeluaran',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'pengeluaran',
            'pengeluaran' => $this->pengeluaranModel->getWithKategori()
        ];
        
        return view('admin/pengeluaran/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Pengeluaran',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'pengeluaran',
            'kategori' => $this->kategoriModel->findAll()
        ];
        
        return view('admin/pengeluaran/create', $data);
    }
    
   public function store()
{
    if (!session()->get('logged_in') || session()->get('level') != 'admin') {
        return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
    }
    
    $rules = [
        'tanggal' => 'required',
        'deskripsi' => 'required',
        'jumlah' => 'required|numeric'
    ];
    
    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }
    
    $id_kategori = $this->request->getPost('id_kategori');
    
    // JIKA KATEGORI BARU (custom)
    if ($id_kategori == 'custom') {
        $kategori_baru = trim($this->request->getPost('kategori_baru'));
        if (!empty($kategori_baru)) {
            // CEK APAKAH KATEGORI SUDAH ADA
            $cek = $this->kategoriModel->where('nama_kategori', $kategori_baru)->first();
            if ($cek) {
                $id_kategori = $cek['id']; // Pakai yang sudah ada
            } else {
                // Simpan kategori baru
                $kategoriData = [
                    'nama_kategori' => $kategori_baru,
                    'icon' => 'fa-tag'
                ];
                $id_kategori = $this->kategoriModel->insert($kategoriData);
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Nama kategori harus diisi!');
        }
    }
    
    $user_id = session()->get('user_id');
    if (empty($user_id)) {
        $user_id = 1;
    }
    
    $kode = 'KLT' . date('Ymd') . rand(100, 999);
    
    $this->pengeluaranModel->save([
        'kode_transaksi' => $kode,
        'tanggal' => $this->request->getPost('tanggal'),
        'id_kategori' => $id_kategori,
        'deskripsi' => $this->request->getPost('deskripsi'),
        'jumlah' => $this->request->getPost('jumlah'),
        'id_user' => $user_id
    ]);
    
    return redirect()->to('/admin/pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan!');
}
    
    public function edit($id)
    {
        $pengeluaran = $this->pengeluaranModel->find($id);
        
        if (!$pengeluaran) {
            return redirect()->to('/admin/pengeluaran')->with('error', 'Data tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Pengeluaran',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'pengeluaran',
            'pengeluaran' => $pengeluaran,
            'kategori' => $this->kategoriModel->findAll()
        ];
        
        return view('admin/pengeluaran/edit', $data);
    }
    
   public function update($id)
{
    $this->pengeluaranModel->update($id, [
        'tanggal' => $this->request->getPost('tanggal'),
        'id_kategori' => $this->request->getPost('id_kategori'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'jumlah' => $this->request->getPost('jumlah')
    ]);
    
    return redirect()->to('/admin/pengeluaran')->with('success', 'Pengeluaran berhasil diupdate!');
}
    
    public function delete($id)
    {
        $this->pengeluaranModel->delete($id);
        return redirect()->to('/admin/pengeluaran')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}