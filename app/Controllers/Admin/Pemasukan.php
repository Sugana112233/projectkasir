<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemasukanModel;
use App\Models\KategoriPemasukanModel;

class Pemasukan extends BaseController
{
    protected $pemasukanModel;
    protected $kategoriModel;
    
    public function __construct()
    {
        $this->pemasukanModel = new PemasukanModel();
        $this->kategoriModel = new KategoriPemasukanModel();
        
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            redirect()->to('/auth/login')->send();
            exit();
        }
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Pemasukan',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'pemasukan',
            'pemasukan' => $this->pemasukanModel->getWithKategori(),
            'kategori' => $this->kategoriModel->findAll()
        ];
        
        return view('admin/pemasukan/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Pemasukan',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'pemasukan',
            'kategori' => $this->kategoriModel->findAll()
        ];
        
        return view('admin/pemasukan/create', $data);
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
    
    $kode = 'PMS' . date('Ymd') . rand(100, 999);
    
    $this->pemasukanModel->save([
        'kode_transaksi' => $kode,
        'tanggal' => $this->request->getPost('tanggal'),
        'id_kategori' => $id_kategori,
        'deskripsi' => $this->request->getPost('deskripsi'),
        'jumlah' => $this->request->getPost('jumlah'),
        'sumber' => $this->request->getPost('sumber'),
        'id_user' => $user_id
    ]);
    
    return redirect()->to('/admin/pemasukan')->with('success', 'Pemasukan berhasil ditambahkan!');
}
    public function edit($id)
    {
        $pemasukan = $this->pemasukanModel->find($id);
        
        if (!$pemasukan) {
            return redirect()->to('/admin/pemasukan')->with('error', 'Data tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Pemasukan',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'pemasukan',
            'pemasukan' => $pemasukan,
            'kategori' => $this->kategoriModel->findAll()
        ];
        
        return view('admin/pemasukan/edit', $data);
    }
    
    public function update($id)
    {
        $this->pemasukanModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'sumber' => $this->request->getPost('sumber')
        ]);
        
        return redirect()->to('/admin/pemasukan')->with('success', 'Pemasukan berhasil diupdate!');
    }
    
    public function delete($id)
    {
        $this->pemasukanModel->delete($id);
        return redirect()->to('/admin/pemasukan')->with('success', 'Pemasukan berhasil dihapus!');
    }
}