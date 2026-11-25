<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none">Katalog</a></li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('/?kategori=' . urlencode($produk['kategori'])) ?>" class="text-decoration-none">
                    <?= esc($produk['kategori']) ?>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($produk['nama_brg']) ?></li>
        </ol>
    </nav>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('info')): ?>
        <div class="alert alert-info alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i><?= esc(session()->getFlashdata('info')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="row g-0 align-items-center">
            <div class="col-md-5 bg-light-subtle p-4 text-center">
                <img
                    src="<?= base_url('uploads/' . esc($produk['gambar'])) ?>"
                    alt="<?= esc($produk['nama_brg']) ?>"
                    class="img-fluid rounded-3 shadow-sm"
                >
            </div>
            <div class="col-md-7">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge text-bg-primary mb-2"><?= esc($produk['kategori']) ?></span>
                    <h1 class="h3 fw-bold text-dark mb-2"><?= esc($produk['nama_brg']) ?></h1>
                    <div class="fs-3 fw-bold text-primary mb-3">
                        Rp <?= number_format((int) $produk['harga'], 0, ',', '.') ?>
                    </div>
                    <p class="text-muted mb-4"><?= esc($produk['keterangan']) ?></p>

                    <table class="table table-sm table-borderless mb-4 small">
                        <tbody>
                            <tr>
                                <th class="text-muted ps-0" style="width: 140px;">ID Produk</th>
                                <td class="fw-medium">#<?= esc($produk['id_brg']) ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0">Kategori</th>
                                <td class="fw-medium"><?= esc($produk['kategori']) ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0">Ketersediaan</th>
                                <td>
                                    <span class="badge <?= (int) $produk['stok'] > 0 ? 'text-bg-success' : 'text-bg-danger' ?>">
                                        <?= (int) $produk['stok'] > 0 ? 'Tersedia (' . esc($produk['stok']) . ' unit)' : 'Stok Habis' ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= base_url('keranjang/tambah/' . (int) $produk['id_brg']) ?>" class="btn btn-primary px-4">
                            <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
