<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Invoice &amp; Pesanan</h1>
    <p class="text-muted small mb-0">Daftar seluruh transaksi pesanan yang masuk melalui checkout pelanggan.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-uppercase text-muted">
                <tr>
                    <th class="ps-4">ID Invoice</th>
                    <th>Nama Pemesan</th>
                    <th>Alamat Pengiriman</th>
                    <th>Tanggal Pesan</th>
                    <th>Batas Bayar</th>
                    <th class="text-center">Item</th>
                    <th class="text-end">Total Bayar</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($invoices)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">Belum ada transaksi invoice.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($invoices as $inv): ?>
                        <tr>
                            <td class="ps-4 fw-bold">#INV-<?= str_pad((string) $inv['id'], 5, '0', STR_PAD_LEFT) ?></td>
                            <td class="fw-medium"><?= esc($inv['nama']) ?></td>
                            <td class="small text-muted" style="max-width: 240px;"><?= esc($inv['alamat']) ?></td>
                            <td class="small text-nowrap"><?= esc($inv['tgl_pesan']) ?></td>
                            <td class="small text-danger text-nowrap"><?= esc($inv['batas_bayar']) ?></td>
                            <td class="text-center"><span class="badge text-bg-light border text-dark"><?= esc($inv['total_item']) ?></span></td>
                            <td class="text-end fw-semibold text-primary text-nowrap">
                                Rp <?= number_format((int) $inv['total_bayar'], 0, ',', '.') ?>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?= base_url('admin/invoice/' . (int) $inv['id']) ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
