<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tblogin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nik', 'nama', 'password', 'level', 'status'];
    
    // NONAKTIFKAN TIMESTAMPS - ini yang bikin error
    protected $useTimestamps = false;
    
    protected $validationRules = [
        'nik' => 'required|min_length[3]|is_unique[tblogin.nik]',
        'nama' => 'required|min_length[3]',
        'password' => 'required|min_length[6]',
        'level' => 'required|in_list[admin,kasir]'
    ];
    
    protected $validationMessages = [
        'nik' => [
            'required' => 'NIK harus diisi',
            'min_length' => 'NIK minimal 3 karakter',
            'is_unique' => 'NIK sudah terdaftar'
        ],
        'nama' => [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama minimal 3 karakter'
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter'
        ],
        'level' => [
            'required' => 'Pilih level pengguna',
            'in_list' => 'Level harus Admin atau Kasir'
        ]
    ];
    
    // Cek apakah sudah ada user terdaftar
    public function checkFirstUser()
    {
        return $this->countAllResults() == 0;
    }
    
    // Mendapatkan user berdasarkan NIK
    public function getUserByNIK($nik)
    {
        return $this->where('nik', $nik)->first();
    }
    
    // Get all users (untuk admin nanti)
    public function getAllUsers()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
    
    // Get user by ID
    public function getUserById($id)
    {
        return $this->find($id);
    }
    
    // Update user status
    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
    
    // Delete user
    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    
    // Check if user exists
    public function userExists($id)
    {
        return $this->find($id) !== null;
    }
    // Tambahkan method ini di UserModel

public function countKasirAktif()
{
    return $this->where('level', 'kasir')
                ->where('status', 'aktif')
                ->countAllResults();
}

public function countTotalKasir()
{
    return $this->where('level', 'kasir')
                ->countAllResults();
}
}