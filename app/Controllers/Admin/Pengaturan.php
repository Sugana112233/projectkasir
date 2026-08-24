<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengaturan extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            redirect()->to('/auth/login')->send();
            exit();
        }
    }
    
    public function index()
    {
        $data = [
            'title' => 'Pengaturan',
            'page_title' => 'Pengaturan',
            'user' => [
                'id' => session()->get('user_id'),
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'pengaturan'
        ];
        
        return view('admin/pengaturan/index', $data);
    }
    
    public function updateProfil()
    {
        $id = session()->get('user_id');
        $nama = $this->request->getPost('nama');
        
        if (!empty($nama)) {
            $this->userModel->update($id, ['nama' => $nama]);
            session()->set('nama', $nama);
            return redirect()->to('/admin/pengaturan')->with('success', 'Profil berhasil diupdate!');
        }
        
        return redirect()->to('/admin/pengaturan')->with('error', 'Nama tidak boleh kosong!');
    }
}