<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">Katalog</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('keranjang') ?>" class="text-decoration-none">Keranjang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <h1 class="h3 fw-bold mb-4">Checkout &amp; Pembayaran</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <ul class="mb-0 small">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-truck me-2 text-primary"></i>Informasi Pengiriman</h5>
                    <form action="<?= base_url('checkout/proses') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium">Nama Lengkap Penerima</label>
                            <input
                                type="text"
                                class="form-control"
                                id="nama"
                                name="nama"
                                value="<?= esc(old('nama', session()->get('nama') ?? '')) ?>"
                                placeholder="Masukkan nama lengkap Anda"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-medium">Alamat Pengiriman Lengkap</label>
                            <textarea
                                class="form-control"
                                id="alamat"
                                name="alamat"
                                rows="3"
                                placeholder="Nama jalan, nomor rumah, kecamatan, kota, kode pos"
                                required
                            ><?= esc(old('alamat', '')) ?></textarea>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="jasa_pengiriman" class="form-label fw-medium">Jasa Pengiriman</label>
                                <select class="form-select" id="jasa_pengiriman" name="jasa_pengiriman" required>
                                    <?php $kurirOld = old('jasa_pengiriman', 'JNE Reguler'); ?>
                                    <option value="JNE Reguler" <?= $kurirOld === 'JNE Reguler' ? 'selected' : '' ?>>JNE Reguler</option>
                                    <option value="J&T Express" <?= $kurirOld === 'J&T Express' ? 'selected' : '' ?>>J&amp;T Express</option>
                                    <option value="SiCepat REG" <?= $kurirOld === 'SiCepat REG' ? 'selected' : '' ?>>SiCepat REG</option>
                                    <option value="Pos Indonesia" <?= $kurirOld === 'Pos Indonesia' ? 'selected' : '' ?>>Pos Indonesia</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="metode_pembayaran" class="form-label fw-medium">Metode Pembayaran</label>
                                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                    <?php $bayarOld = old('metode_pembayaran', 'Transfer Bank BCA'); ?>
                                    <option value="Transfer Bank BCA" <?= $bayarOld === 'Transfer Bank BCA' ? 'selected' : '' ?>>Transfer Bank BCA</option>
                                    <option value="Transfer Bank BNI" <?= $bayarOld === 'Transfer Bank BNI' ? 'selected' : '' ?>>Transfer Bank BNI</option>
                                    <option value="Transfer Bank BRI" <?= $bayarOld === 'Transfer Bank BRI' ? 'selected' : '' ?>>Transfer Bank BRI</option>
                                    <option value="Transfer Bank Mandiri" <?= $bayarOld === 'Transfer Bank Mandiri' ? 'selected' : '' ?>>Transfer Bank Mandiri</option>
                                    <option value="QRIS / E-Wallet" <?= $bayarOld === 'QRIS / E-Wallet' ? 'selected' : '' ?>>QRIS / E-Wallet</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                <i class="bi bi-check2-circle me-2"></i>Buat Pesanan Sekarang
                            </button>
                            <a href="<?= base_url('keranjang') ?>" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-receipt me-2 text-primary"></i>Ringkasan Pesanan</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <?php foreach ($items as $item): ?>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-medium"><?= esc($item['nama_brg']) ?></div>
                                    <small class="text-muted">
                                        <?= (int) $item['qty'] ?> &times; Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                    </small>
                                </div>
                                <span class="fw-semibold text-nowrap">
                                    Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="fw-bold">Total Bayar</span>
                        <span class="fs-5 fw-bold text-primary">Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
