<?= $this->extend('kasir/layout') ?>

<?= $this->section('content') ?>
<style>
    .card-monochrome {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }
    .table-custom { margin-bottom: 0; }
    .table-custom thead { background-color: #18181b; color: #ffffff; }
    .table-custom thead th {
        border: none; padding: 8px 12px; font-weight: 600; font-size: 0.75rem;
        letter-spacing: 0.03em; text-transform: uppercase;
    }
    .table-custom tbody tr:hover { background-color: #f4f4f5; }
    .table-custom td {
        padding: 8px 12px; vertical-align: middle; color: #27272a;
        font-size: 0.825rem; border-bottom: 1px solid #f4f4f5;
    }
    .badge-status {
        background-color: #18181b; color: #ffffff; padding: 4px 10px;
        border-radius: 12px; font-size: 0.7rem; font-weight: 600;
    }
    .btn-dark-custom {
        background-color: #18181b; color: #ffffff; border: 1px solid #18181b;
        border-radius: 6px; padding: 4px 10px; font-size: 0.75rem; font-weight: 500;
        text-decoration: none; display: inline-block;
    }
    .btn-dark-custom:hover { background-color: #3f3f46; color: #ffffff; }
    .btn-outline-dark-custom {
        background-color: transparent; color: #18181b; border: 1px solid #e2e8f0;
        border-radius: 6px; padding: 4px 8px; font-size: 0.75rem; font-weight: 500;
    }
    .form-control-compact { border-radius: 6px; border: 1px solid #e2e8f0; padding: 4px 8px; font-size: 0.8rem; }
    .page-link-custom { color: #18181b; border: 1px solid #e2e8f0; margin: 0 2px; border-radius: 4px !important; font-size: 0.75rem; padding: 4px 8px; }
    .page-item.active .page-link-custom { background-color: #18181b; border-color: #18181b; color: #ffffff; }
</style>

<div class="container-fluid px-3 py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold m-0" style="color: #09090b; font-size: 1.1rem;">Riwayat Transaksi</h5>
    </div>

    <!-- Filter & Pencarian -->
    <div class="card card-monochrome mb-2 p-2">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" id="searchKeyword" class="form-control form-control-compact" placeholder="🔍 Cari kode nota..." onkeyup="filterTable()">
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted" style="font-size: 0.75rem;">Dari:</span>
                    <input type="date" id="startDate" class="form-control form-control-compact border-start-0" onchange="filterTable()">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted" style="font-size: 0.75rem;">Sampai:</span>
                    <input type="date" id="endDate" class="form-control form-control-compact border-start-0" onchange="filterTable()">
                </div>
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-outline-dark-custom w-100" onclick="resetFilter()">
                    <i class="fas fa-undo me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="card card-monochrome overflow-hidden">
        <div class="table-responsive">
            <table class="table table-custom align-middle" id="historyTable">
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal & Waktu</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th width="90" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (!empty($riwayat)) : ?>
                        <?php $no = 1; foreach ($riwayat as $row) : ?>
                            <?php 
                                $tglRaw = isset($row['tanggal']) ? date('Y-m-d', strtotime($row['tanggal'])) : '';
                                $tglFormatted = isset($row['tanggal']) ? date('d/m/Y', strtotime($row['tanggal'])) : '-';
                                $waktuFormatted = isset($row['waktu']) ? date('H:i', strtotime($row['waktu'])) : '-';
                                $kode = $row['kode_transaksi'] ?? $row['id'];
                            ?>
                            <tr class="data-row" data-kode="<?= strtolower($kode) ?>" data-tanggal="<?= $tglRaw ?>">
                                <td class="row-number"><?= $no++ ?></td>
                                <td><span class="fw-bold text-dark">#<?= $kode ?></span></td>
                                <td>
                                    <i class="far fa-clock me-1 text-muted"></i>
                                    <?= $tglFormatted ?> <span class="fw-bold text-dark ms-1"><?= $waktuFormatted ?></span>
                                </td>
                                <td class="fw-bold" style="color: #09090b;">
                                    Rp <?= number_format($row['total'] ?? $row['bayar'] ?? 0, 0, ',', '.') ?>
                                </td>
                                <td><span class="badge badge-status"><?= ucfirst($row['status'] ?? 'Selesai') ?></span></td>
                                <td class="text-center">
                                    <!-- Mengarahkan ke route cetak di controller kasir -->
                                    <a href="<?= base_url('kasir/cetak/' . $row['id']) ?>" target="_blank" class="btn btn-dark-custom">
                                        <i class="fas fa-print me-1"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr id="emptyRow">
                            <td colspan="6" class="text-center py-4 text-muted small">
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination -->
        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top" style="border-color: #f4f4f5 !important;">
            <div class="text-muted" id="pageInfo" style="font-size: 0.75rem;">
                Menampilkan 0 data
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0" id="paginationNav"></ul>
            </nav>
        </div>
    </div>
</div>

<script>
    // Pagination & Search Logic
    let currentPage = 1;
    const rowsPerPage = 5;
    let filteredRows = [];

    document.addEventListener("DOMContentLoaded", function () {
        initTable();
    });

    function initTable() {
        const rows = Array.from(document.querySelectorAll("#tableBody .data-row"));
        filteredRows = rows;
        renderPagination();
    }

    function filterTable() {
        const searchInput = document.getElementById("searchKeyword").value.toLowerCase();
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;
        const allRows = Array.from(document.querySelectorAll("#tableBody .data-row"));

        filteredRows = allRows.filter(row => {
            const kode = row.getAttribute("data-kode");
            const tanggal = row.getAttribute("data-tanggal");

            const matchSearch = kode.includes(searchInput);
            let matchDate = true;

            if (startDate && tanggal < startDate) matchDate = false;
            if (endDate && tanggal > endDate) matchDate = false;

            return matchSearch && matchDate;
        });

        currentPage = 1;
        renderPagination();
    }

    function renderPagination() {
        const allRows = document.querySelectorAll("#tableBody .data-row");
        allRows.forEach(row => row.style.display = "none");

        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageRows = filteredRows.slice(start, end);

        pageRows.forEach((row, index) => {
            row.style.display = "";
            row.querySelector(".row-number").innerText = start + index + 1;
        });

        const pageInfo = document.getElementById("pageInfo");
        if (totalRows > 0) {
            pageInfo.innerText = `${start + 1}-${Math.min(end, totalRows)} dari ${totalRows} data`;
        } else {
            pageInfo.innerText = "Tidak ada data.";
        }

        const nav = document.getElementById("paginationNav");
        nav.innerHTML = "";

        if (totalPages <= 1) return;

        const prevLi = document.createElement("li");
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link page-link-custom" href="javascript:void(0)" onclick="changePage(${currentPage - 1})">‹</a>`;
        nav.appendChild(prevLi);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link page-link-custom" href="javascript:void(0)" onclick="changePage(${i})">${i}</a>`;
            nav.appendChild(li);
        }

        const nextLi = document.createElement("li");
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link page-link-custom" href="javascript:void(0)" onclick="changePage(${currentPage + 1})">›</a>`;
        nav.appendChild(nextLi);
    }

    function changePage(page) {
        currentPage = page;
        renderPagination();
    }

    function resetFilter() {
        document.getElementById("searchKeyword").value = "";
        document.getElementById("startDate").value = "";
        document.getElementById("endDate").value = "";
        filterTable();
    }
</script>
<?= $this->endSection() ?>