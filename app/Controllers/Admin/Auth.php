<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        // Jika membuka /auth, otomatis dialihkan ke /auth/login
        return redirect()->to(base_url('auth/login'));
    }

    public function login()
    {
        // Tampilkan halaman view login
        return view('auth/login');
    }

    public function loginProcess()
    {
        // Tambahkan proses verifikasi login Anda di sini
    }

    public function logout()
    {
        // Hapus session login
        session()->destroy();

        // Mengarahkan kembali ke halaman login utama
        return redirect()->to(base_url('auth/login'))->with('success', 'Berhasil logout');
    }
}