<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url', 'session']);
    }
    
    // SELALU tampilkan login page pertama
    public function index()
    {
        if(session()->get('logged_in')) {
            return redirect()->to($this->getDashboardUrl());
        }
        
        return $this->loginView();
    }
    
    public function loginView()
    {
        $data = [
            'title' => 'Login - Kasir Toko Bangunan',
            'showRegisterLink' => true,
            'validation' => \Config\Services::validation()
        ];
        return view('auth/login', $data);
    }
    
    public function registerView()
    {
        $isFirstUser = $this->userModel->checkFirstUser();
        
        if (!$isFirstUser) {
            if (!session()->get('logged_in') || session()->get('level') != 'admin') {
                return redirect()->to('/auth/login')
                    ->with('error', 'Hanya Administrator yang dapat menambah pengguna baru! Silakan login terlebih dahulu.');
            }
        }
        
        $data = [
            'title' => 'Registrasi - Kasir Toko Bangunan',
            'isFirstUser' => $isFirstUser,
            'validation' => \Config\Services::validation()
        ];
        return view('auth/register', $data);
    }
    
    public function processRegister()
    {
        $isFirstUser = $this->userModel->checkFirstUser();
        
        if (!$isFirstUser) {
            if (!session()->get('logged_in') || session()->get('level') != 'admin') {
                return redirect()->to('/auth/login')
                    ->with('error', 'Akses ditolak! Hanya admin yang dapat menambah pengguna.');
            }
        }
        
        $rules = [
            'nik' => 'required|min_length[3]|is_unique[tblogin.nik]',
            'nama' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];
        
        if (!$isFirstUser) {
            $rules['level'] = 'required|in_list[admin,kasir]';
        }
        
        $messages = [
            'confirm_password' => [
                'required' => 'Konfirmasi password harus diisi',
                'matches' => 'Konfirmasi password tidak sama dengan password'
            ],
            'level' => [
                'required' => 'Pilih level pengguna',
                'in_list' => 'Level harus Admin atau Kasir'
            ]
        ];
        
        if(!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        
        $data = [
            'nik'      => $this->request->getPost('nik'),
            'username' => $this->request->getPost('nik'), // Menyamakan username dengan NIK jika terpisah
            'nama'     => $this->request->getPost('nama'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status'   => 'aktif'
        ];
        
        if ($isFirstUser) {
            $data['level'] = 'admin';
            $message = 'Registrasi berhasil! Akun admin pertama telah dibuat.';
        } else {
            $data['level'] = $this->request->getPost('level');
            $message = 'Pengguna baru berhasil ditambahkan!';
        }
        
        try {
            $this->userModel->save($data);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
        if ($isFirstUser) {
            $user = $this->userModel->getUserByNIK($data['nik']);
            
            if (!$user) {
                return redirect()->to('/auth/login')
                    ->with('error', 'Akun berhasil dibuat, tapi gagal login otomatis. Silakan login manual.');
            }
            
            $sessionData = [
                'id'        => $user['id'] ?? $user['id_user'],
                'id_user'   => $user['id'] ?? $user['id_user'],
                'nik'       => $user['nik'] ?? '',
                'username'  => $user['username'] ?? $user['nik'] ?? '',
                'nama'      => $user['nama'],
                'level'     => $user['level'],
                'logged_in' => true
            ];
            
            session()->set($sessionData);
            
            return redirect()->to('/admin/dashboard')
                ->with('success', $message . ' Selamat datang ' . $user['nama']);
        } else {
            return redirect()->to('/admin/dashboard')
                ->with('success', $message);
        }
    }
    
   public function processLogin()
{
    $rules = [
        'nik'      => 'required',
        'password' => 'required'
    ];
    
    if(!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }
    
    $input = trim($this->request->getPost('nik'));
    $password = $this->request->getPost('password');
    
    $db = \Config\Database::connect();
    
    // Cari user berdasarkan NIK ATAU Nama Lengkap
    $user = $db->table('tblogin')
               ->groupStart()
                   ->where('nik', $input)
                   ->orWhere('nama', $input)
               ->groupEnd()
               ->get()->getRowArray();
    
    if($user) {
        if(password_verify($password, $user['password'])) {
            if(isset($user['status']) && $user['status'] == 'nonaktif') {
                return redirect()->back()->with('error', 'Akun Anda dinonaktifkan!');
            }
            
            // Set session sesuai kolom database asli Anda
            $sessionData = [
                'id'        => $user['id'],
                'nik'       => $user['nik'],
                'nama'      => $user['nama'],
                'level'     => $user['level'],
                'logged_in' => true
            ];
            
            session()->set($sessionData);
            
            return redirect()->to($this->getDashboardUrl())
                ->with('success', 'Login berhasil! Selamat datang ' . $user['nama']);
        }
    }
    
    return redirect()->back()->with('error', 'NIK / Nama / Password salah!');
}
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth')->with('success', 'Logout berhasil!');
    }
    
    private function getDashboardUrl()
    {
        $level = session()->get('level');
        if($level == 'admin') {
            return '/admin/dashboard';
        } else {
            return \base_url('kasir');
        }
    }
}