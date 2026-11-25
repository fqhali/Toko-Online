<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Detail Invoice #INV-<?= str_pad((string) $invoice['id'], 5, '0', STR_PAD_LEFT) ?></h1>
        <p class="text-muted small mb-0">Rincian informasi pembeli dan item pesanan.</p>
    </div>
    <a href="<?= base_url('admin/invoice') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Invoice
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row g-3 small">
            <div class="col-md-3">
                <div class="text-muted">Nama Pemesan</div>
                <div class="fw-semibold fs-6"><?= esc($invoice['nama']) ?></div>
            </div>
            <div class="col-md-5">
                <div class="text-muted">Alamat Pengiriman</div>
                <div class="fw-medium"><?= esc($invoice['alamat']) ?></div>
            </div>
            <div class="col-md-2">
                <div class="text-muted">Tanggal Pesan</div>
                <div class="fw-medium"><?= esc($invoice['tgl_pesan']) ?></div>
            </div>
            <div class="col-md-2">
                <div class="text-muted">Batas Pembayaran</div>
                <div class="fw-semibold text-danger"><?= esc($invoice['batas_bayar']) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0">Item Pesanan</h6>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light small text-uppercase text-muted">
                <tr>
                    <th class="ps-4">ID Barang</th>
                    <th>Nama Produk</th>
                    <th>Catatan / Pilihan</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-end pe-4">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $row): ?>
                    <tr>
                        <td class="ps-4 text-muted">#<?= esc($row['id_brg']) ?></td>
                        <td class="fw-medium"><?= esc($row['nama_brg']) ?></td>
                        <td class="small text-muted"><?= esc($row['pilihan'] ?: '-') ?></td>
                        <td class="text-center"><?= (int) $row['jumlah'] ?></td>
                        <td class="text-end">Rp <?= number_format((int) $row['harga'], 0, ',', '.') ?></td>
                        <td class="text-end pe-4 fw-semibold">
                            Rp <?= number_format((int) $row['harga'] * (int) $row['jumlah'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <th colspan="5" class="text-end">Grand Total</th>
                    <th class="text-end pe-4 text-primary fs-5">Rp <?= number_format($total, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
