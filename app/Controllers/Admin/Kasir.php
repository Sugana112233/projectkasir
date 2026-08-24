<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Kasir extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        // Ambil semua data kasir
        $dataKasir = $this->userModel->where('level', 'kasir')->orderBy('id', 'DESC')->findAll();
        
        $data = [
            'title' => 'Data Kasir',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'kasir',
            'kasir' => $dataKasir
        ];
        
        return view('admin/kasir/index', $data);
    }
    
    public function create()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        $data = [
            'title' => 'Tambah Kasir Baru',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'kasir',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/kasir/create', $data);
    }
    
    public function store()
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        // Validasi input
        $rules = [
            'nik' => 'required|min_length[3]|is_unique[tblogin.nik]',
            'nama' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];
        
        $messages = [
            'confirm_password' => [
                'required' => 'Konfirmasi password harus diisi',
                'matches' => 'Konfirmasi password tidak sama dengan password'
            ]
        ];
        
        if(!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        
        // Data untuk disimpan
        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'level' => 'kasir',
            'status' => $this->request->getPost('status') ? 'aktif' : 'nonaktif'
        ];
        
        // Simpan ke database
        $this->userModel->save($data);
        
        return redirect()->to('/admin/kasir')
            ->with('success', 'Kasir berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        $kasir = $this->userModel->find($id);
        
        if (!$kasir || $kasir['level'] != 'kasir') {
            return redirect()->to('/admin/kasir')
                ->with('error', 'Data kasir tidak ditemukan!');
        }
        
        $data = [
            'title' => 'Edit Data Kasir',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'kasir',
            'kasir' => $kasir,
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/kasir/edit', $data);
    }
    
    public function update($id)
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        // Cek apakah kasir ada
        $kasir = $this->userModel->find($id);
        if (!$kasir || $kasir['level'] != 'kasir') {
            return redirect()->to('/admin/kasir')
                ->with('error', 'Data kasir tidak ditemukan!');
        }
        
        // Validasi input
        $rules = [
            'nik' => "required|min_length[3]|is_unique[tblogin.nik,id,{$id}]",
            'nama' => 'required|min_length[3]'
        ];
        
        // Jika password diisi, validasi password
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }
        
        if(!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        
        // Data untuk diupdate
        $data = [
            'id' => $id,
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'status' => $this->request->getPost('status') ? 'aktif' : 'nonaktif'
        ];
        
        // Jika password diisi, update password
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        
        // Update ke database
        $this->userModel->save($data);
        
        return redirect()->to('/admin/kasir')
            ->with('success', 'Data kasir berhasil diperbarui!');
    }
    
    public function delete($id)
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        // Cek apakah kasir ada
        $kasir = $this->userModel->find($id);
        if (!$kasir || $kasir['level'] != 'kasir') {
            return redirect()->to('/admin/kasir')
                ->with('error', 'Data kasir tidak ditemukan!');
        }
        
        // Hapus kasir
        $this->userModel->delete($id);
        
        return redirect()->to('/admin/kasir')
            ->with('success', 'Kasir berhasil dihapus!');
    }
    
    public function status($id, $status)
    {
        // Cek session
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login sebagai admin!');
        }
        
        // Cek apakah kasir ada
        $kasir = $this->userModel->find($id);
        if (!$kasir || $kasir['level'] != 'kasir') {
            return redirect()->to('/admin/kasir')
                ->with('error', 'Data kasir tidak ditemukan!');
        }
        
        // Update status
        $data = [
            'id' => $id,
            'status' => $status
        ];
        
        $this->userModel->save($data);
        
        $statusText = $status == 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/admin/kasir')
            ->with('success', "Kasir berhasil {$statusText}!");
    }
}