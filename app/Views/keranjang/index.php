<div class="container py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Keranjang Belanja</h1>
            <p class="text-muted small mb-0">Periksa kembali item pilihan Anda sebelum melanjutkan ke checkout.</p>
        </div>
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Lanjut Belanja
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('info')): ?>
        <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i><?= esc(session()->getFlashdata('info')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-cart-x display-4 text-muted"></i>
                <h5 class="mt-3 fw-semibold">Keranjang Belanja Masih Kosong</h5>
                <p class="text-muted mb-3">Yuk jelajahi katalog kami dan tambahkan produk favorit Anda.</p>
                <a href="<?= base_url('/') ?>" class="btn btn-primary px-4">
                    <i class="bi bi-grid-fill me-2"></i>Lihat Katalog Produk
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light small text-uppercase text-muted">
                                <tr>
                                    <th class="ps-4">Produk</th>
                                    <th>Harga</th>
                                    <th style="width: 150px;">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <img
                                                    src="<?= base_url('uploads/' . esc($item['gambar'])) ?>"
                                                    alt="<?= esc($item['nama_brg']) ?>"
                                                    class="rounded-2 object-fit-cover border"
                                                    style="width: 64px; height: 48px;"
                                                >
                                                <div>
                                                    <a href="<?= base_url('produk/' . (int) $item['id_brg']) ?>" class="fw-semibold text-dark text-decoration-none">
                                                        <?= esc($item['nama_brg']) ?>
                                                    </a>
                                                    <div class="small text-muted">
                                                        <?= esc($item['kategori']) ?> &middot; Stok: <?= esc($item['stok']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-nowrap">
                                            Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                        </td>
                                        <td>
                                            <form action="<?= base_url('keranjang/update') ?>" method="post" class="d-flex align-items-center gap-1">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id_brg" value="<?= (int) $item['id_brg'] ?>">
                                                <input
                                                    type="number"
                                                    name="qty"
                                                    value="<?= (int) $item['qty'] ?>"
                                                    min="1"
                                                    max="<?= (int) $item['stok'] ?>"
                                                    class="form-control form-control-sm text-center"
                                                    style="width: 68px;"
                                                    aria-label="Jumlah"
                                                >
                                                <button type="submit" class="btn btn-outline-primary btn-sm" title="Perbarui jumlah">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end fw-semibold text-primary text-nowrap">
                                            Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-center pe-3">
                                            <form action="<?= base_url('keranjang/hapus/' . (int) $item['id_brg']) ?>" method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus item">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
                        <form action="<?= base_url('keranjang/kosongkan') ?>" method="post" onsubmit="return confirm('Kosongkan seluruh keranjang belanja?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash3 me-1"></i>Kosongkan Keranjang
                            </button>
                        </form>
                        <span class="small text-muted">Total jenis produk: <strong><?= count($items) ?></strong></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>
                        <div class="d-flex justify-content-between mb-2 small text-muted">
                            <span>Total Item</span>
                            <span><?= array_sum(array_column($items, 'qty')) ?> pcs</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small text-muted">
                            <span>Biaya Pengiriman</span>
                            <span class="text-success fw-medium">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-semibold">Total Pembayaran</span>
                            <span class="fs-5 fw-bold text-primary">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <a href="<?= base_url('checkout') ?>" class="btn btn-primary w-100 fw-semibold py-2">
                            <i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout
                        </a>

                        <?php if (! session()->get('isLoggedIn')): ?>
                            <div class="small text-muted text-center mt-2">
                                <i class="bi bi-shield-lock me-1"></i>Anda akan diminta login sebelum menyelesaikan checkout.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
