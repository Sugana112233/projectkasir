<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\ProdukModel;
use App\Models\KasirModel;
use App\Models\PengeluaranModel;
use App\Models\PemasukanModel;

class Laporan extends BaseController
{
    protected $transaksiModel;
    protected $produkModel;
    protected $kasirModel;
    protected $pengeluaranModel;
    protected $pemasukanModel;

    public function __construct()
    {
        $this->transaksiModel   = new TransaksiModel();
        $this->produkModel      = new ProdukModel();
        $this->kasirModel       = new KasirModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->pemasukanModel   = new PemasukanModel();

        if (!session()->get('logged_in') || session()->get('level') != 'admin') {
            redirect()->to('/auth/login')->send();
            exit();
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $total_transaksi = $this->transaksiModel->countAllResults();

        $total_pemasukan = $db->table('pemasukan')->selectSum('jumlah')->get()->getRow();
        $total_pemasukan = $total_pemasukan->jumlah ?? 0;

        $total_pengeluaran = $db->table('pengeluaran')->selectSum('jumlah')->get()->getRow();
        $total_pengeluaran = $total_pengeluaran->jumlah ?? 0;

        $saldo_bersih = $total_pemasukan - $total_pengeluaran;

        $data = [
            'title'             => 'Laporan',
            'page_title'        => 'Laporan',
            'user'              => [
                'nama'  => session()->get('nama'),
                'nik'   => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu'              => 'laporan',
            'breadcrumbs'       => [
                ['title' => 'Dashboard', 'url' => base_url('admin/dashboard')],
                ['title' => 'Laporan', 'active' => true]
            ],
            'total_transaksi'   => $total_transaksi,
            'total_pemasukan'   => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'saldo_bersih'      => $saldo_bersih
        ];

        return view('admin/laporan/index', $data);
    }

    public function keuangan()
    {
        $start_date = $this->request->getPost('start_date') ?? $this->request->getGet('start_date') ?? date('Y-m-01');
        $end_date   = $this->request->getPost('end_date') ?? $this->request->getGet('end_date') ?? date('Y-m-d');

        $pendapatan_harian   = $this->transaksiModel->getPendapatanHarian($start_date, $end_date) ?? [];
        $total_transaksi     = $this->transaksiModel->getTotalTransaksi($start_date, $end_date) ?? ['total_pendapatan' => 0, 'total_transaksi' => 0];
        $rata_rata_transaksi = $this->transaksiModel->getRataRataTransaksi($start_date, $end_date) ?? 0;
        $produk_terlaris     = $this->produkModel->getProdukTerlaris($start_date, $end_date) ?? [];
        $kasir_teraktif      = $this->kasirModel->getKasirTeraktif($start_date, $end_date) ?? [];

        // Total Penjualan
        $total_penjualan = $this->transaksiModel
            ->selectSum('total')
            ->where('DATE(tanggal) >=', $start_date)
            ->where('DATE(tanggal) <=', $end_date)
            ->where('status', 'selesai')
            ->first();
        $total_penjualan = $total_penjualan['total'] ?? 0;

        // Total Pemasukan Manual
        $total_pemasukan = $this->pemasukanModel
            ->selectSum('jumlah')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->first();
        $total_pemasukan = $total_pemasukan['jumlah'] ?? 0;

        // Total Pengeluaran
        $total_pengeluaran = $this->pengeluaranModel
            ->selectSum('jumlah')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->first();
        $total_pengeluaran = $total_pengeluaran['jumlah'] ?? 0;

        // Saldo Bersih
        $total_pendapatan_bersih = ($total_penjualan + $total_pemasukan) - $total_pengeluaran;

        // Data Chart
        $data_chart = $this->getChartData($start_date, $end_date);

        // Pengeluaran per Kategori (diperbaiki agar kompatibel dengan strict GROUP BY)
        $pengeluaran_per_kategori = $this->pengeluaranModel
            ->select('ANY_VALUE(kategori_pengeluaran.nama_kategori) as nama_kategori, SUM(pengeluaran.jumlah) as total')
            ->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.id_kategori')
            ->where('pengeluaran.tanggal >=', $start_date)
            ->where('pengeluaran.tanggal <=', $end_date)
            ->groupBy('pengeluaran.id_kategori')
            ->orderBy('total', 'DESC')
            ->findAll() ?? [];

        $data = [
            'title'                   => 'Laporan Keuangan',
            'page_title'              => 'Laporan Keuangan',
            'user'                    => [
                'nama'  => session()->get('nama'),
                'nik'   => session()->get('nik'),
                'level' => session()->get('level')
            ],
            'menu'                    => 'laporan', // Mengunci menu sidebar ke 'laporan'
            'start_date'              => $start_date,
            'end_date'                => $end_date,
            'pendapatan_harian'       => $pendapatan_harian,
            'total_transaksi'         => $total_transaksi,
            'rata_rata_transaksi'     => $rata_rata_transaksi,
            'produk_terlaris'         => $produk_terlaris,
            'kasir_teraktif'          => $kasir_teraktif,
            'total_penjualan'         => $total_penjualan,
            'total_pemasukan'         => $total_pemasukan,
            'total_pengeluaran'       => $total_pengeluaran,
            'total_pendapatan_bersih' => $total_pendapatan_bersih,
            'data_chart'              => json_encode($data_chart),
            'pengeluaran_per_kategori' => $pengeluaran_per_kategori
        ];

        return view('admin/laporan/keuangan', $data);
    }

    private function getChartData($start_date, $end_date)
    {
        $db = \Config\Database::connect();

        $sql = "SELECT 
                    DATE(tanggal) as tanggal,
                    COALESCE(SUM(CASE WHEN jenis = 'penjualan' THEN jumlah ELSE 0 END), 0) as penjualan,
                    COALESCE(SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END), 0) as pemasukan,
                    COALESCE(SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END), 0) as pengeluaran
                FROM (
                    SELECT tanggal, total as jumlah, 'penjualan' as jenis 
                    FROM transaksi 
                    WHERE status = 'selesai' AND DATE(tanggal) BETWEEN '$start_date' AND '$end_date'
                    UNION ALL
                    SELECT tanggal, jumlah, 'pemasukan' as jenis 
                    FROM pemasukan 
                    WHERE tanggal BETWEEN '$start_date' AND '$end_date'
                    UNION ALL
                    SELECT tanggal, jumlah, 'pengeluaran' as jenis 
                    FROM pengeluaran 
                    WHERE tanggal BETWEEN '$start_date' AND '$end_date'
                ) AS all_data
                GROUP BY DATE(tanggal)
                ORDER BY tanggal ASC";

        return $db->query($sql)->getResultArray();
    }

    public function cetak()
    {
        $jenis      = $this->request->getGet('jenis');
        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');

        switch ($jenis) {
            case 'transaksi':
                $data = $this->transaksiModel->getLaporanTransaksi($start_date, $end_date);
                $view = 'admin/laporan/cetak_transaksi';
                break;
            case 'keuangan':
                $data = $this->transaksiModel->getLaporanKeuangan($start_date, $end_date);
                $view = 'admin/laporan/cetak_keuangan';
                break;
            case 'produk':
                $data = $this->produkModel->getLaporanProduk($start_date, $end_date);
                $view = 'admin/laporan/cetak_produk';
                break;
            case 'pengeluaran':
                $data = [
                    'pengeluaran' => $this->pengeluaranModel->getWithKategori(),
                    'start_date'  => $start_date,
                    'end_date'    => $end_date,
                    'total'       => $this->pengeluaranModel->selectSum('jumlah')->where('tanggal >=', $start_date)->where('tanggal <=', $end_date)->first()
                ];
                $view = 'admin/laporan/cetak_pengeluaran';
                break;
            case 'pemasukan':
                $data = [
                    'pemasukan'  => $this->pemasukanModel->getWithKategori(),
                    'start_date' => $start_date,
                    'end_date'   => $end_date,
                    'total'      => $this->pemasukanModel->selectSum('jumlah')->where('tanggal >=', $start_date)->where('tanggal <=', $end_date)->first()
                ];
                $view = 'admin/laporan/cetak_pemasukan';
                break;
            default:
                return redirect()->back()->with('error', 'Jenis laporan tidak valid');
        }

        $data['start_date']    = $start_date;
        $data['end_date']      = $end_date;
        $data['jenis_laporan'] = $jenis;
        $data['user']          = [
            'nama'  => session()->get('nama'),
            'nik'   => session()->get('nik'),
            'level' => session()->get('level')
        ];

        return view($view, $data);
    }

    public function exportExcel()
    {
        $jenis      = $this->request->getGet('jenis');
        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');

        return redirect()->to(base_url("admin/laporan/cetak?jenis=$jenis&start_date=$start_date&end_date=$end_date"));
    }
}