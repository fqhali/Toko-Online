<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Dashboard Admin</h1>
        <p class="text-muted small mb-0">Ringkasan inventaris produk, transaksi invoice, dan aktivitas TokoOnline.</p>
    </div>
    <a href="<?= base_url('admin/barang/tambah') ?>" class="btn btn-primary btn-sm px-3">
        <i class="bi bi-plus-lg me-1"></i>Tambah Barang Baru
    </a>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                    <i class="bi bi-box-seam fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Produk</div>
                    <div class="fs-4 fw-bold"><?= esc($totalBarang) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-3">
                    <i class="bi bi-layers fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Stok Unit</div>
                    <div class="fs-4 fw-bold"><?= esc($totalStok) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                    <i class="bi bi-receipt fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Invoice</div>
                    <div class="fs-4 fw-bold"><?= esc($totalInvoice) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3">
                    <i class="bi bi-cash-stack fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Pendapatan</div>
                    <div class="fs-5 fw-bold text-success">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Invoice Terbaru -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-receipt-cutoff text-primary me-2"></i>Invoice Terbaru</h6>
                <a href="<?= base_url('admin/invoice') ?>" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Pemesan</th>
                            <th>Tanggal</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentInvoices)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada invoice tercatat.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentInvoices as $inv): ?>
                                <tr>
                                    <td class="ps-3 fw-semibold">#<?= esc($inv['id']) ?></td>
                                    <td><?= esc($inv['nama']) ?></td>
                                    <td class="text-muted"><?= esc($inv['tgl_pesan']) ?></td>
                                    <td class="text-end fw-semibold text-primary">
                                        Rp <?= number_format((int) $inv['total_bayar'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/invoice/' . (int) $inv['id']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Produk Terbaru -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-box-seam text-primary me-2"></i>Produk di Katalog</h6>
                <a href="<?= base_url('admin/barang') ?>" class="btn btn-outline-primary btn-sm">Kelola</a>
            </div>
            <ul class="list-group list-group-flush small">
                <?php foreach ($barangTerbaru as $item): ?>
                    <li class="list-group-item d-flex align-items-center justify-content-between py-2">
                        <div class="d-flex align-items-center gap-2 min-w-0">
                            <img
                                src="<?= base_url('uploads/' . esc($item['gambar'])) ?>"
                                alt="<?= esc($item['nama_brg']) ?>"
                                class="rounded object-fit-cover border flex-shrink-0"
                                style="width: 42px; height: 32px;"
                            >
                            <div class="text-truncate">
                                <div class="fw-semibold text-truncate"><?= esc($item['nama_brg']) ?></div>
                                <div class="text-muted">Rp <?= number_format((int) $item['harga'], 0, ',', '.') ?></div>
                            </div>
                        </div>
                        <span class="badge <?= (int) $item['stok'] > 5 ? 'text-bg-success' : 'text-bg-warning' ?> ms-2">
                            Stok: <?= esc($item['stok']) ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
