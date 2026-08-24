<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

class Kasir extends BaseController
{
    protected $produkModel;
    protected $transaksiModel;
    protected $detailTransaksiModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->transaksiModel = new TransaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // Mengambil data produk untuk halaman kasir
        $tabelProduk = $db->tableExists('tbproduk') ? 'tbproduk' : 'produk';
        $produk = $db->table($tabelProduk)->get()->getResultArray();

        // Mengambil total transaksi hari ini
        $tabelTransaksi = $db->tableExists('tbtransaksi') ? 'tbtransaksi' : 'transaksi';
        
        $totalHariIni = $db->table($tabelTransaksi)
                           ->selectSum('total', 'total_pendapatan')
                           ->where('tanggal', date('Y-m-d'))
                           ->get()
                           ->getRowArray();

        $data = [
            'title'          => 'Dashboard Kasir',
            'menu'           => 'kasir',
            'produk'         => $produk,
            'total_hari_ini' => $totalHariIni['total_pendapatan'] ?? 0
        ];

        return view('kasir/index', $data);
    }

    public function dashboard()
    {
        return $this->index();
    }

    public function transaksi()
    {
        $data = [
            'title'  => 'Transaksi Kasir',
            'menu'   => 'transaksi',
            'user'   => session()->get('user') ?? ['nama' => session()->get('nama') ?? 'Kasir'],
            'produk' => $this->produkModel->where('stok >', 0)->findAll(),
        ];

        return view('kasir/transaksi', $data);
    }

    public function simpan_transaksi()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak.']);
        }

        $items   = $this->request->getPost('items');
        $total   = $this->request->getPost('total');
        $bayar   = $this->request->getPost('bayar');
        $kembali = $this->request->getPost('kembali');

        if (empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Keranjang kosong.']);
        }

        $db = \Config\Database::connect();
        $db->transOff();
        $db->transBegin();

        $kodeTransaksi = 'TRX-' . date('YmdHis');

        // 1. Simpan Transaksi Utama
        $simpanTransaksi = $db->table('tbtransaksi')->insert([
            'kode_transaksi' => $kodeTransaksi,
            'tanggal'        => date('Y-m-d'),
            'waktu'          => date('H:i:s'),
            'total'          => (float) $total,
            'bayar'          => (float) $bayar,
            'kembalian'      => (float) $kembali,
            'id_kasir'       => session()->get('id_user') ?? session()->get('id') ?? 1,
            'status'         => 'selesai'
        ]);

        if (!$simpanTransaksi) {
            $error = $db->error();
            $db->transRollback();
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal Simpan Transaksi: ' . $error['message']
            ]);
        }

        $transaksiId = $db->insertID();

        // 2. Simpan Detail Transaksi & Update Stok
        foreach ($items as $item) {
            $idProduk = (int) $item['id'];
            $qty      = (int) $item['qty'];
            $harga    = (float) $item['harga'];

            $tabelDetail = $db->tableExists('tbdetailtransaksi') ? 'tbdetailtransaksi' : 'detail_transaksi';
            
            $dataDetail = [
                'qty'      => $qty,
                'harga'    => $harga,
                'subtotal' => $harga * $qty
            ];

            if ($db->fieldExists('id_transaksi', $tabelDetail)) {
                $dataDetail['id_transaksi'] = $transaksiId;
            } else {
                $dataDetail['transaksi_id'] = $transaksiId;
            }

            if ($db->fieldExists('id_produk', $tabelDetail)) {
                $dataDetail['id_produk'] = $idProduk;
            } else {
                $dataDetail['produk_id'] = $idProduk;
            }

            $simpanDetail = $db->table($tabelDetail)->insert($dataDetail);

            if (!$simpanDetail) {
                $error = $db->error();
                $db->transRollback();
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal Simpan Detail: ' . $error['message']
                ]);
            }

            // Update Stok di tbproduk
            $updateStok = $db->query("UPDATE tbproduk SET stok = stok - ? WHERE id = ?", [$qty, $idProduk]);
            if (!$updateStok) {
                $error = $db->error();
                $db->transRollback();
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal Update Stok: ' . $error['message']
                ]);
            }
        }

        $db->transCommit();

        return $this->response->setJSON([
            'status'         => 'success',
            'message'        => 'Transaksi berhasil disimpan!',
            'kode_transaksi' => $kodeTransaksi,
            'transaksi_id'   => $transaksiId
        ]);
    }

    public function riwayat()
    {
        $db = \Config\Database::connect();
        $tabelTransaksi = $db->tableExists('tbtransaksi') ? 'tbtransaksi' : 'transaksi';

        $riwayat = $db->table($tabelTransaksi)
                      ->orderBy('id', 'DESC')
                      ->get()
                      ->getResultArray();

        $data = [
            'title'   => 'Riwayat Transaksi',
            'menu'    => 'riwayat',
            'riwayat' => $riwayat
        ];

        return view('kasir/riwayat', $data);
    }
public function cetak($id = null)
{
    // Validasi ID dipindah ke paling atas
    if (!$id) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $db = \Config\Database::connect();
    
    // Dynamic Table Checking
    $tabelTransaksi = $db->tableExists('tbtransaksi') ? 'tbtransaksi' : 'transaksi';
    $tabelDetail    = $db->tableExists('tbdetailtransaksi') ? 'tbdetailtransaksi' : 'detail_transaksi';
    $tabelProduk    = $db->tableExists('tbproduk') ? 'tbproduk' : 'produk';

    // 1. Ambil Data Utama Transaksi
    $transaksi = $db->table($tabelTransaksi)
                    ->where('id', $id)
                    ->get()
                    ->getRowArray();

    if (!$transaksi) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // 2. Tentukan nama kolom FK (Foreign Key)
    $fkTransaksi = $db->fieldExists('id_transaksi', $tabelDetail) ? 'id_transaksi' : 'transaksi_id';
    $fkProduk    = $db->fieldExists('id_produk', $tabelDetail) ? 'id_produk' : 'produk_id';

    // 3. Ambil Detail Barang & Nama Produk
    $detail = $db->table($tabelDetail . ' d')
                ->select('d.*, p.nama_produk')
                ->join($tabelProduk . ' p', 'p.id = d.' . $fkProduk, 'left')
                ->where('d.' . $fkTransaksi, $id)
                ->get()
                ->getResultArray();

    $data = [
        'transaksi' => $transaksi,
        'detail'    => $detail
    ];

    return view('kasir/cetak_nota', $data);
}

    // Displays the edit profile form
    public function edit_profil()
    {
        $session = session();
        $id_user = $session->get('id_user') ?? $session->get('id');

        if (!$id_user) {
            return redirect()->to(base_url('auth/login'));
        }

        $db = \Config\Database::connect();
        $user = $db->table('tblogin')->where('id', $id_user)->get()->getRowArray();

        return view('kasir/edit_profil', [
            'title' => 'Edit Profil',
            'menu'  => 'profil',
            'user'  => $user
        ]);
    }

    // Method POST untuk menyimpan perubahan profil
    public function update_profil()
    {
        $session = session();
        $id_user = $session->get('id') ?? $session->get('id_user');

        if (!$id_user) {
            return redirect()->to(base_url('auth'));
        }

        $db = \Config\Database::connect();

        // Di form Anda, label "Username" sebenarnya diisi NIK
        $nik  = trim($this->request->getPost('username') ?? $this->request->getPost('nik'));
        $nama = trim($this->request->getPost('nama'));
        $password = $this->request->getPost('password');

        $data = [
            'nik'  => $nik,
            'nama' => $nama,
        ];

        // Hanya hash password jika diisi dan bukan placeholder titik/bintang
        if (!empty($password) && !str_contains($password, '•') && !str_contains($password, '*')) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            // Update database berdasarkan ID (Primary Key)
            $db->table('tblogin')->where('id', $id_user)->update($data);

            // Update Session secara langsung
            $session->set('nik', $nik);
            $session->set('nama', $nama);

            return redirect()->to(base_url('kasir/edit_profil'))->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->to(base_url('kasir/edit_profil'))->with('error', 'Gagal update database: ' . $e->getMessage());
        }
    }

    public function detail_transaksi($id)
    {
        $db = \Config\Database::connect();
        
        $transaksi = $db->table('tbtransaksi')->where('id', $id)->get()->getRowArray();
        
        $detail = $db->table('tbdetailtransaksi')
                     ->select('tbdetailtransaksi.*, tbproduk.nama_produk')
                     ->join('tbproduk', 'tbproduk.id = tbdetailtransaksi.id_produk', 'left')
                     ->where('id_transaksi', $id)
                     ->get()->getResultArray();

        return $this->response->setJSON([
            'status'    => 'success',
            'transaksi' => $transaksi,
            'detail'    => $detail
        ]);
    }
}