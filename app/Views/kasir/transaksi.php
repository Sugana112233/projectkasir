<?= $this->extend('kasir/layout') ?>

<?= $this->section('content') ?>
<?php 
    // Mengubah logo menjadi Base64 agar selalu muncul (termasuk saat cetak struk)
    $pathLogo = FCPATH . 'assets/img/Logosu.jpeg';
    if (file_exists($pathLogo)) {
        $type = pathinfo($pathLogo, PATHINFO_EXTENSION);
        $data = file_get_contents($pathLogo);
        $base64Logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    } else {
        $base64Logo = base_url('assets/img/Logosu.jpeg');
    }
?>
<style>
    .theme-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .theme-card-header {
        background-color: #1a1a1a;
        color: #ffffff;
        border-radius: 7px 7px 0 0 !important;
        padding: 12px 16px;
    }
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        transition: all 0.2s ease;
        background-color: #ffffff;
    }
    .product-card:hover {
        border-color: #000000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .btn-monochrome {
        background-color: #212529;
        color: #ffffff;
        border: none;
        font-weight: 500;
    }
    .btn-monochrome:hover {
        background-color: #000000;
        color: #ffffff;
    }
    .badge-stock {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #dee2e6;
    }
    .price-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #000000;
    }
    .total-box {
        background-color: #f8f9fa;
        border: 1px dashed #000000;
        border-radius: 6px;
    }
    
    @media print {
        body * { 
            visibility: hidden !important; 
        }
        body, html {
            background: #fff !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }
        .modal, .modal-backdrop {
            position: static !important;
        }

        #strukPrint, #strukPrint * { 
            visibility: visible !important; 
        }
        #strukPrint {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 5px !important;
            box-shadow: none !important;
            border: none !important;
        }

        .modal-header, .modal-footer, .btn-close { 
            display: none !important; 
        }
    }
</style>

<div class="row g-3">
    <!-- Katalog & Scan Barcode -->
    <div class="col-md-7">
        <div class="card theme-card h-100">
            <div class="theme-card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="fas fa-barcode me-2"></i>Katalog / Scan Barcode</span>
                <div class="input-group input-group-sm w-50">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchProduk" class="form-control border-start-0" placeholder="Scan barcode / ketik nama..." autofocus autocomplete="off">
                </div>
            </div>
            <div class="card-body p-3" style="max-height: 540px; overflow-y: auto;">
                <div class="row g-2" id="productList">
                    <?php if (!empty($produk)): ?>
                        <?php foreach ($produk as $p): ?>
                            <div class="col-md-4 product-item">
                                <div class="card product-card p-2 text-center h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="fw-bold text-dark text-truncate mb-1" title="<?= $p['nama_produk'] ?>">
                                            <?= $p['nama_produk'] ?>
                                        </div>
                                        <small class="text-muted d-block mb-1">Kode: <?= $p['kode_produk'] ?? $p['id'] ?></small>
                                        <span class="badge badge-stock mb-2">Stok: <?= $p['stok'] ?></span>
                                    </div>
                                    <div>
                                        <div class="price-text mb-2">
                                            Rp <?= number_format($p['harga_jual'], 0, ',', '.') ?>
                                        </div>
                                        <button class="btn btn-sm btn-monochrome w-100 add-to-cart" 
                                                data-id="<?= $p['id'] ?>" 
                                                data-kode="<?= $p['kode_produk'] ?? $p['id'] ?>" 
                                                data-nama="<?= $p['nama_produk'] ?>" 
                                                data-harga="<?= $p['harga_jual'] ?>" 
                                                data-stok="<?= $p['stok'] ?>">
                                            <i class="fas fa-plus me-1"></i> Pilih
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada data produk tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Belanja & Pembayaran -->
    <div class="col-md-5">
        <div class="card theme-card">
            <div class="theme-card-header fw-bold">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 230px; overflow-y: auto;">
                    <table class="table table-sm align-middle mb-0" id="cartTable">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-3">Item</th>
                                <th style="width: 75px;" class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th style="width: 35px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="emptyCart">
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-receipt me-1"></i> Keranjang masih kosong
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top p-3">
                <div class="total-box p-3 mb-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-uppercase text-secondary" style="letter-spacing: 0.5px;">Total Bayar</span>
                    <span class="fw-bold fs-4 text-dark" id="totalHarga" data-value="0">Rp 0</span>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark mb-1">Nominal Tunai (Rp)</label>
                    <input type="text" id="nominalBayar" class="form-control form-control-lg border-dark" placeholder="Masukkan jumlah uang..." autocomplete="off">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold text-secondary">Kembalian:</span>
                    <span class="fw-bold fs-6 text-dark" id="nominalKembali">Rp 0</span>
                </div>

                <button class="btn btn-monochrome w-100 py-2 fw-bold" id="btnProses" disabled>
                    <i class="fas fa-check-circle me-1"></i> Selesaikan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Struk Pembayaran -->
<div class="modal fade" id="modalStruk" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Struk Pembayaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"></button>
            </div>
            <div class="modal-body p-3">
                <div class="struk-wrapper" id="strukPrint">
                    <div class="text-center mb-2">
                        <!-- Menggunakan string Base64 logo -->
                        <img src="<?= $base64Logo ?>" 
                             alt="Logo" 
                            style="max-width: 65px; height: 65px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto 8px auto;">

                        <h6 class="fw-bold mb-0">TB SARI UMA DUKUH</h6>
                        <small class="d-block text-muted">Sistem Kasir Bangunan</small>
                        <small class="d-block" id="strukTanggal"></small>
                        <small class="d-block fw-bold" id="strukKode"></small>
                    </div>

                    <hr style="border-top: 1px dashed #000;" class="my-2">
                    <div id="strukItems"></div>
                    <hr style="border-top: 1px dashed #000;" class="my-2">
                    <div class="d-flex justify-content-between small">
                        <span>Total:</span>
                        <span class="fw-bold" id="strukTotal"></span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span>Bayar:</span>
                        <span id="strukBayar"></span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span>Kembali:</span>
                        <span id="strukKembali"></span>
                    </div>
                    <hr style="border-top: 1px dashed #000;" class="my-2">
                    <div class="text-center small">
                        <small>Terima Kasih Atas Kunjungan Anda!</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-secondary w-100 mb-1" onclick="cetakStrukKhusus()">
                    <i class="fas fa-print me-1"></i> Cetak Struk
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark w-100" data-bs-dismiss="modal" onclick="resetForm()">
                    Transaksi Baru
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];
let allProducts = <?= json_encode($produk ?? []) ?>;

document.addEventListener('DOMContentLoaded', function() {
    let searchInput = document.getElementById('searchProduk');
    searchInput.focus();

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let query = this.value.trim().toLowerCase();
            if (query === '') return;

            let matched = allProducts.find(p => 
                (p.kode_produk && p.kode_produk.toLowerCase() === query) || 
                p.nama_produk.toLowerCase() === query ||
                p.id.toString() === query
            );

            if (matched) {
                addToCart(matched.id, matched.nama_produk, matched.harga_jual, matched.stok);
                this.value = '';
            }
        }
    });

    searchInput.addEventListener('keyup', function(e) {
        if (e.key !== 'Enter') {
            let val = this.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                let text = item.innerText.toLowerCase();
                item.style.display = text.includes(val) ? 'block' : 'none';
            });
        }
    });

    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            addToCart(this.dataset.id, this.dataset.nama, parseFloat(this.dataset.harga), parseInt(this.dataset.stok));
        });
    });

    document.getElementById('nominalBayar').addEventListener('input', function() {
        let rawVal = this.value.replace(/\D/g, '');
        if (rawVal) {
            this.value = parseInt(rawVal, 10).toLocaleString('id-ID');
        } else {
            this.value = '';
        }
        calculateChange();
    });

    document.getElementById('btnProses').addEventListener('click', function() {
        let total = parseFloat(document.getElementById('totalHarga').dataset.value || 0);
        let bayarStr = document.getElementById('nominalBayar').value.replace(/\./g, '');
        let bayar = parseFloat(bayarStr || 0);
        let kembali = bayar - total;

        if (cart.length === 0 || bayar < total) return;

        let formData = new FormData();
        cart.forEach((item, index) => {
            formData.append(`items[${index}][id]`, item.id);
            formData.append(`items[${index}][qty]`, item.qty);
            formData.append(`items[${index}][harga]`, item.harga);
        });
        formData.append('total', total);
        formData.append('bayar', bayar);
        formData.append('kembali', kembali);

        fetch('<?= base_url('kasir/transaksi/simpan') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showModalStruk(data.kode_transaksi, total, bayar, kembali);
            } else {
                alert('Gagal menyimpan transaksi: ' + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan koneksi server.');
        });
    });
});

function addToCart(id, nama, harga, stok) {
    let exist = cart.find(i => i.id == id);
    if (exist) {
        if (exist.qty < stok) {
            exist.qty++;
        } else {
            alert('Stok produk telah mencapai batas maksimum!');
        }
    } else {
        cart.push({ id, nama, harga, qty: 1, stok });
    }
    renderCart();
}

function renderCart() {
    let tbody = document.querySelector('#cartTable tbody');
    tbody.innerHTML = '';

    if (cart.length === 0) {
        tbody.innerHTML = `
            <tr id="emptyCart">
                <td colspan="4" class="text-center py-4 text-muted">
                    <i class="fas fa-receipt me-1"></i> Keranjang masih kosong
                </td>
            </tr>`;
        document.getElementById('totalHarga').innerText = 'Rp 0';
        document.getElementById('totalHarga').dataset.value = 0;
        calculateChange();
        return;
    }

    let total = 0;
    cart.forEach((item, index) => {
        let subtotal = item.harga * item.qty;
        total += subtotal;

        let tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="ps-3"><div class="fw-bold text-dark text-truncate" style="max-width: 130px;">${item.nama}</div></td>
            <td>
                <input type="number" class="form-control form-control-sm text-center p-1 border-secondary" value="${item.qty}" min="1" max="${item.stok}" onchange="updateQty(${index}, this.value)">
            </td>
            <td class="text-end fw-bold text-dark">Rp ${subtotal.toLocaleString('id-ID')}</td>
            <td class="text-center">
                <button class="btn btn-sm text-danger p-0" onclick="removeItem(${index})" title="Hapus"><i class="fas fa-times-circle"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById('totalHarga').innerText = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalHarga').dataset.value = total;
    calculateChange();
}

function updateQty(index, qty) {
    qty = parseInt(qty);
    if (qty > cart[index].stok) {
        alert('Stok tidak mencukupi!');
        qty = cart[index].stok;
    }
    if (qty <= 0 || isNaN(qty)) qty = 1;
    cart[index].qty = qty;
    renderCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

function calculateChange() {
    let total = parseFloat(document.getElementById('totalHarga').dataset.value || 0);
    let bayarInput = document.getElementById('nominalBayar').value.replace(/\./g, '');
    let bayar = parseFloat(bayarInput || 0);
    let kembali = bayar - total;

    let btn = document.getElementById('btnProses');
    let elemKembali = document.getElementById('nominalKembali');

    if (cart.length > 0 && bayar >= total && total > 0) {
        btn.disabled = false;
        elemKembali.innerText = 'Rp ' + kembali.toLocaleString('id-ID');
        elemKembali.className = 'fw-bold fs-6 text-dark';
    } else {
        btn.disabled = true;
        if (cart.length > 0 && bayar > 0 && bayar < total) {
            elemKembali.innerText = 'Kurang Rp ' + Math.abs(kembali).toLocaleString('id-ID');
            elemKembali.className = 'fw-bold fs-6 text-secondary';
        } else {
            elemKembali.innerText = 'Rp 0';
            elemKembali.className = 'fw-bold fs-6 text-dark';
        }
    }
}

function showModalStruk(kode, total, bayar, kembali) {
    document.getElementById('strukKode').innerText = '#' + kode;
    document.getElementById('strukTanggal').innerText = new Date().toLocaleString('id-ID');
    
    let itemsHtml = '';
    cart.forEach(item => {
        itemsHtml += `
            <div class="mb-1 small">
                <div class="fw-bold">${item.nama}</div>
                <div class="d-flex justify-content-between text-muted">
                    <span>${item.qty} x Rp ${item.harga.toLocaleString('id-ID')}</span>
                    <span>Rp ${(item.qty * item.harga).toLocaleString('id-ID')}</span>
                </div>
            </div>`;
    });
    document.getElementById('strukItems').innerHTML = itemsHtml;
    document.getElementById('strukTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('strukBayar').innerText = 'Rp ' + bayar.toLocaleString('id-ID');
    document.getElementById('strukKembali').innerText = 'Rp ' + kembali.toLocaleString('id-ID');

    let modal = new bootstrap.Modal(document.getElementById('modalStruk'));
    modal.show();
}

function cetakStrukKhusus() {
    let isiStruk = document.getElementById('strukPrint').innerHTML;

    let iframe = document.createElement('iframe');
    iframe.style.position = 'fixed';
    iframe.style.right = '0';
    iframe.style.bottom = '0';
    iframe.style.width = '0px';
    iframe.style.height = '0px';
    iframe.style.border = 'none';
    document.body.appendChild(iframe);

    let doc = iframe.contentWindow.document;
    doc.open();
    doc.write(`
        <!DOCTYPE html>
        <html>
            <head>
                <title>Cetak Struk</title>
                <style>
                    * { box-sizing: border-box; }
                    body {
                        font-family: 'Courier New', Courier, monospace;
                        font-size: 12px;
                        margin: 0;
                        padding: 10px;
                        color: #000;
                    }
                    .text-center { text-align: center; }
                    .fw-bold { font-weight: bold; }
                    .d-block { display: block; }
                    .mx-auto { margin-left: auto; margin-right: auto; }
                    .text-muted { color: #555; }
                    .mb-0 { margin-bottom: 0; }
                    .mb-1 { margin-bottom: 3px; }
                    .mb-2 { margin-bottom: 6px; }
                    .my-2 { margin-top: 6px; margin-bottom: 6px; }
                    .small { font-size: 11px; }
                    .d-flex { display: flex; }
                    .justify-content-between { justify-content: space-between; }
                    
                    img { 
                    display: block !important; 
                    margin: 0 auto 8px auto !important; 
                    max-width: 65px !important; 
                    height: 65px !important; 
                    border-radius: 50% !important;
                    object-fit: cover !important;
                }
                    @page { margin: 0; size: auto; }
                </style>
            </head>
            <body>
                <div style="width: 100%; max-width: 280px; margin: 0 auto;">
                    ${isiStruk}
                </div>
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.focus();
                            window.print();
                        }, 200);
                    };
                <\/script>
            </body>
        </html>
    `);
    doc.close();

    setTimeout(function() {
        document.body.removeChild(iframe);
    }, 1500);
}

function resetForm() {
    cart = [];
    document.getElementById('nominalBayar').value = '';
    renderCart();
    document.getElementById('searchProduk').focus();
}
</script>
<?= $this->endSection() ?>