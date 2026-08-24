<?php 
    // Mengubah logo menjadi Base64 agar pasti muncul saat diprint/save PDF
    $pathLogo = FCPATH . 'assets/img/Logosu.jpeg';
    if (file_exists($pathLogo)) {
        $type = pathinfo($pathLogo, PATHINFO_EXTENSION);
        $data = file_get_contents($pathLogo);
        $base64Logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    } else {
        $base64Logo = base_url('assets/img/Logosu.jpeg');
    }

    // Penyesuaian Tanggal/Waktu Nota
    $tglStruk = '-';
    if (!empty($transaksi['tanggal'])) {
        $waktu = $transaksi['waktu'] ?? '00:00:00';
        $tglStruk = date('d/m/Y H:i:s', strtotime($transaksi['tanggal'] . ' ' . $waktu));
    } elseif (!empty($transaksi['created_at'])) {
        $tglStruk = date('d/m/Y H:i:s', strtotime($transaksi['created_at']));
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Nota - <?= $transaksi['kode_transaksi'] ?? '' ?></title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            color: #000;
            background: #fff;
        }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .d-block { display: block; }
        .text-muted { color: #555; }
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 3px; }
        .mb-2 { margin-bottom: 6px; }
        .my-2 { margin-top: 6px; margin-bottom: 6px; }
        .small { font-size: 11px; }
        .d-flex { display: flex; }
        .justify-content-between { justify-content: space-between; }
        
        .logo-img { 
            display: block !important; 
            margin: 0 auto 8px auto !important; 
            width: 65px !important; 
            height: 65px !important; 
            border-radius: 50% !important;
            object-fit: cover !important;
        }

        .struk-container {
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
        }

        @page { 
            margin: 0; 
            size: auto; 
        }
    </style>
</head>
<body>

<div class="struk-container">
    <div class="text-center mb-2">
        <img src="<?= $base64Logo ?>" alt="Logo" class="logo-img">
        <h6 class="fw-bold mb-0" style="font-size: 14px;">TB SARI UMA DUKUH</h6>
        <small class="d-block text-muted">Sistem Kasir Bangunan</small>
        <small class="d-block"><?= $tglStruk ?></small>
        <small class="d-block fw-bold">#<?= $transaksi['kode_transaksi'] ?? '' ?></small>
    </div>

    <hr style="border-top: 1px dashed #000;" class="my-2">

    <!-- Detail Item Barang -->
    <div id="strukItems">
        <?php if (!empty($detail)): ?>
            <?php foreach ($detail as $item): ?>
                <?php 
                    $qtyItem = $item['qty'] ?? $item['jumlah'] ?? 1;
                    $hargaItem = $item['harga'] ?? $item['harga_satuan'] ?? 0;
                    $subtotalItem = $item['subtotal'] ?? ($qtyItem * $hargaItem);
                ?>
                <div class="mb-1 small">
                    <div class="fw-bold"><?= $item['nama_produk'] ?? 'Barang' ?></div>
                    <div class="d-flex justify-content-between text-muted">
                        <span><?= $qtyItem ?> x Rp <?= number_format($hargaItem, 0, ',', '.') ?></span>
                        <span>Rp <?= number_format($subtotalItem, 0, ',', '.') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <hr style="border-top: 1px dashed #000;" class="my-2">

    <!-- Total Rincian Pembayaran -->
    <div class="d-flex justify-content-between small">
        <span>Total:</span>
        <span class="fw-bold">Rp <?= number_format($transaksi['total'] ?? $transaksi['total_harga'] ?? 0, 0, ',', '.') ?></span>
    </div>
    <div class="d-flex justify-content-between small">
        <span>Bayar:</span>
        <span>Rp <?= number_format($transaksi['bayar'] ?? $transaksi['total_bayar'] ?? 0, 0, ',', '.') ?></span>
    </div>
    <div class="d-flex justify-content-between small">
        <span>Kembali:</span>
        <span>Rp <?= number_format($transaksi['kembalian'] ?? $transaksi['kembali'] ?? 0, 0, ',', '.') ?></span>
    </div>

    <hr style="border-top: 1px dashed #000;" class="my-2">

    <div class="text-center small">
        <small>Terima Kasih Atas Kunjungan Anda!</small>
    </div>
</div>

<script>
    window.onload = function() {
        setTimeout(function() {
            window.focus();
            window.print();
        }, 300);
    };
</script>

</body>
</html>