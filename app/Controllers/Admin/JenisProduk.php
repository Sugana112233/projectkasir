<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JenisProdukModel;

class JenisProduk extends BaseController
{
    protected $jenisModel;
    
    public function __construct()
    {
        $this->jenisModel = new JenisProdukModel();
    }
    
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }
        
        $data = [
            'title' => 'Data Jenis Produk',
            'user' => [
                'nama'  => session()->get('nama'),
                'nik'   => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu'  => 'jenis_produk',
            'jenis' => $this->jenisModel->orderBy('nama_jenis', 'ASC')->findAll()
        ];
        
        return view('admin/jenis/index', $data);
    }
    
    public function create()
    {
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }
        
        $data = [
            'title' => 'Tambah Jenis Produk',
            'user' => [
                'nama'  => session()->get('nama'),
                'nik'   => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu'       => 'jenis_produk',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/jenis/create', $data);
    }
    
    public function store()
    {
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }
        
        $rules = [
            'kode_jenis' => 'required|is_unique[tbjenis.kode_jenis]',
            'nama_jenis' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        
        $statusInput = $this->request->getPost('status');
        $statusFix   = ($statusInput == '1' || $statusInput == 'aktif' || $statusInput == 'on') ? 'aktif' : 'nonaktif';
        
        $this->jenisModel->save([
            'kode_jenis' => $this->request->getPost('kode_jenis'),
            'nama_jenis' => $this->request->getPost('nama_jenis'),
            'status'     => $statusFix
        ]);
        
        return redirect()->to('/admin/jenis-produk')->with('success', 'Jenis produk berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }
        
        $jenis = $this->jenisModel->find($id);
        if (is_object($jenis)) {
            $jenis = (array) $jenis;
        }
        
        if (!$jenis) {
            return redirect()->to('/admin/jenis-produk')->with('error', 'Data tidak ditemukan!');
        }
        
        $data = [
            'title' => 'Edit Jenis Produk',
            'user' => [
                'nama'  => session()->get('nama'),
                'nik'   => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu'       => 'jenis_produk',
            'jenis'      => $jenis,
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/jenis/edit', $data);
    }
    
    public function update($id = null)
    {
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }

        $statusInput = $this->request->getPost('status');
        $statusFix   = ($statusInput == '1' || $statusInput == 'aktif' || $statusInput == 'on') ? 'aktif' : 'nonaktif';

        $data = [
            'nama_jenis' => $this->request->getPost('nama_jenis'),
            'status'     => $statusFix
        ];

        $this->jenisModel->update($id, $data);

        return redirect()->to(base_url('admin/jenis-produk'))->with('success', 'Data jenis produk berhasil diubah');
    }
    
    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }
        
        $this->jenisModel->delete($id);
        
        return redirect()->to('/admin/jenis-produk')->with('success', 'Jenis produk berhasil dihapus!');
    }
    
    public function updateStatus($id = null, $status = null)
    {
        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }

        $statusFix = ($status === 'aktif') ? 'aktif' : 'nonaktif';

        $this->jenisModel->update($id, [
            'status' => $statusFix
        ]);

        return redirect()->to(base_url('admin/jenis-produk'))->with('success', 'Status berhasil diperbarui');
    }
}