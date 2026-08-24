<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\JenisModel;
use App\Models\JenisProdukModel;

class Produk extends BaseController
{
    protected $produkModel;
    protected $jenisModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->jenisModel  = new JenisProdukModel();
    }

   public function index()
    {
        $data = [
            'title'        => 'Data Produk',
            'produk'       => $this->produkModel->getProdukWithJenis(),
            'totalProduk'  => $this->produkModel->countAllResults(),
            'produkAktif'  => $this->produkModel->where('status', 'aktif')->countAllResults(),
            'stokMinimal'  => $this->produkModel->countStokMenipis(), // Menggunakan method baru
            'totalJenis'   => $this->jenisModel->countAllResults(),
            'user'         => session()->get('user')
        ];

        return view('admin/produk/index', $data);
    }
    public function create()
    {
        // 1. Ambil produk dengan ID terbesar untuk generate kode
        $lastProduct = $this->produkModel->orderBy('id', 'DESC')->first();

        if ($lastProduct && !empty($lastProduct['kode_produk'])) {
            // Ambil angka saja dari string PRD002 -> 2
            $angka = (int) preg_replace('/[^0-9]/', '', $lastProduct['kode_produk']);
            $noUrut = $angka + 1;
        } else {
            $noUrut = 1;
        }

        // Format: PRD001, PRD002, PRD003, dst
        $kodeOtomatis = 'PRD' . sprintf("%03d", $noUrut);

        $data = [
            'title'      => 'Tambah Produk',
            'kodeProduk' => $kodeOtomatis,
            'jenis'      => $this->jenisModel->findAll(),
            'user'       => session()->get('user')
        ];

        return view('admin/produk/create', $data);
    }

    public function store()
    {
        // 2. Olah upload foto jika ada
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/produk', $namaFoto);
        }

        // 3. Bersihkan harga dari format titik (Rp 65.000 -> 65000)
        $hargaBeli = str_replace('.', '', $this->request->getPost('harga_beli'));
        $hargaJual = str_replace('.', '', $this->request->getPost('harga_jual'));

        // 4. Susun array data baru (PASTIKAN menggunakan insert, BUKAN save/update dengan ID lama)
        $dataInsert = [
            'kode_produk'  => $this->request->getPost('kode_produk'),
            'id_jenis'     => $this->request->getPost('id_jenis'),
            'nama_produk'  => $this->request->getPost('nama_produk'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'harga_beli'   => $hargaBeli,
            'harga_jual'   => $hargaJual,
            'stok'         => $this->request->getPost('stok'),
            'stok_minimal' => $this->request->getPost('stok_minimal') ?? 5,
            'satuan'       => $this->request->getPost('satuan'),
            'keterangan'   => $this->request->getPost('keterangan'),
            'foto'         => $namaFoto,
            'status'       => $this->request->getPost('status') == '1' ? 'aktif' : 'nonaktif',
        ];

        // Murni INSERT baris baru ke tabel
        $this->produkModel->insert($dataInsert);

        return redirect()->to(base_url('admin/produk'))
                         ->with('success', 'Produk "' . $dataInsert['nama_produk'] . '" berhasil ditambahkan!');
    }

    
    public function edit($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan!');
        }
        
        $data = [
            'title' => 'Edit Produk',
            'user' => [
                'nama' => session()->get('nama'),
                'nik' => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu' => 'produk',
            'produk' => $produk,
            'jenis' => $this->jenisModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/produk/edit', $data);
    }
    
    public function update($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan!');
        }
        
        $rules = [
            'kode_produk' => "required|is_unique[tbproduk.kode_produk,id,{$id}]",
            'nama_produk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $harga_beli = str_replace('.', '', $this->request->getPost('harga_beli'));
        $harga_jual = str_replace('.', '', $this->request->getPost('harga_jual'));
        
        $fotoName = $produk['foto'];
        $file = $this->request->getFile('foto');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($produk['foto'] && file_exists('uploads/produk/' . $produk['foto'])) {
                unlink('uploads/produk/' . $produk['foto']);
            }
            $fotoName = $produk['kode_produk'] . '_' . time() . '.' . $file->getExtension();
            $file->move('uploads/produk', $fotoName);
        }
        
        $this->produkModel->update($id, [
            'kode_produk'  => $this->request->getPost('kode_produk'),
            'nama_produk'  => $this->request->getPost('nama_produk'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'id_jenis'     => $this->request->getPost('id_jenis'),
            'harga_beli'   => $harga_beli,
            'harga_jual'   => $harga_jual,
            'stok'         => $this->request->getPost('stok'),
            'stok_minimal' => $this->request->getPost('stok_minimal') ?? 5,
            'satuan'       => $this->request->getPost('satuan'),
            'keterangan'   => $this->request->getPost('keterangan'),
            'foto'         => $fotoName,
            'status'       => $this->request->getPost('status') ? 'aktif' : 'nonaktif'
        ]);
        
        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil diupdate!');
    }
    
    public function delete($id)
    {
        $produk = $this->produkModel->find($id);
        if ($produk && $produk['foto'] && file_exists('uploads/produk/' . $produk['foto'])) {
            unlink('uploads/produk/' . $produk['foto']);
        }
        
        $this->produkModel->delete($id);
        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil dihapus!');
    }
    
    public function updateStatus($id, $status)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan!');
        }
        
        $this->produkModel->update($id, ['status' => $status]);
        
        $statusText = $status == 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/admin/produk')->with('success', "Produk berhasil {$statusText}!");
    }
}