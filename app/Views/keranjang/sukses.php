<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-success text-white p-4 text-center">
                    <i class="bi bi-check-circle-fill display-4"></i>
                    <h1 class="h3 fw-bold mt-2 mb-1">Pesanan Berhasil Dibuat!</h1>
                    <p class="mb-0 opacity-75">Terima kasih telah berbelanja di TokoOnline. Detail invoice Anda tersimpan di sistem.</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4 small">
                        <div class="col-sm-6">
                            <div class="text-muted">Nomor Invoice</div>
                            <div class="fw-bold fs-6">#INV-<?= str_pad((string) $invoice['id'], 5, '0', STR_PAD_LEFT) ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted">Nama Penerima</div>
                            <div class="fw-semibold"><?= esc($invoice['nama']) ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted">Tanggal Pesan</div>
                            <div class="fw-medium"><?= esc($invoice['tgl_pesan']) ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted">Batas Pembayaran</div>
                            <div class="fw-semibold text-danger"><?= esc($invoice['batas_bayar']) ?></div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted">Alamat Pengiriman</div>
                            <div class="fw-medium"><?= esc($invoice['alamat']) ?></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pesanan as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-medium"><?= esc($item['nama_brg']) ?></div>
                                            <?php if (! empty($item['pilihan'])): ?>
                                                <div class="small text-muted"><?= esc($item['pilihan']) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= (int) $item['jumlah'] ?></td>
                                        <td class="text-end">Rp <?= number_format((int) $item['harga'], 0, ',', '.') ?></td>
                                        <td class="text-end fw-semibold">
                                            Rp <?= number_format((int) $item['harga'] * (int) $item['jumlah'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <th colspan="3" class="text-end">Total Pembayaran</th>
                                    <th class="text-end text-primary fs-6">Rp <?= number_format($total, 0, ',', '.') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-center mt-4">
                        <a href="<?= base_url('/') ?>" class="btn btn-primary px-4">
                            <i class="bi bi-bag me-2"></i>Kembali Belanja di Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
