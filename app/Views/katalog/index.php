<section class="hero-banner text-white py-4 py-md-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge rounded-pill text-bg-primary bg-opacity-75 mb-2 px-3 py-2">
                    <i class="bi bi-stars me-1"></i>Toko Online &mdash; CodeIgniter 4
                </span>
                <h1 class="h2 fw-bold mb-2">Temukan Produk Pilihan Berkualitas</h1>
                <p class="mb-0 text-white-50">
                    Jelajahi koleksi elektronik, pakaian, dan perlengkapan olahraga terbaik yang tersimpan langsung di database MySQL CodeIgniter 4.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-inline-flex align-items-center gap-3 bg-white bg-opacity-10 rounded-3 px-4 py-3 border border-white border-opacity-10">
                    <i class="bi bi-box-seam fs-2 text-info"></i>
                    <div class="text-start">
                        <div class="fs-4 fw-bold lh-1"><?= count($barang) ?></div>
                        <div class="small text-white-50">Produk Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
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

    <!-- Filter Kategori -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('/') ?>" class="btn btn-sm rounded-pill <?= ($kategoriAktif ?? '') === '' ? 'btn-primary' : 'btn-outline-secondary bg-white' ?>">
                Semua Produk
            </a>
            <?php foreach ($kategoriList as $kat): ?>
                <a href="<?= base_url('/?kategori=' . urlencode($kat)) ?>" class="btn btn-sm rounded-pill <?= ($kategoriAktif ?? '') === $kat ? 'btn-primary' : 'btn-outline-secondary bg-white' ?>">
                    <?= esc($kat) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (! empty($keyword)): ?>
            <div class="small text-muted">
                Hasil pencarian untuk: <strong>&ldquo;<?= esc($keyword) ?>&rdquo;</strong>
                <a href="<?= base_url('/') ?>" class="ms-2 text-decoration-none">Reset</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Grid Katalog Produk -->
    <?php if (empty($barang)): ?>
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-inbox display-4 text-muted"></i>
                <h5 class="mt-3 fw-semibold">Produk tidak ditemukan</h5>
                <p class="text-muted mb-3">Coba pilih kategori lain atau hapus kata kunci pencarian.</p>
                <a href="<?= base_url('/') ?>" class="btn btn-primary btn-sm">Lihat Semua Produk</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($barang as $item): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="product-img-wrapper position-relative">
                            <img
                                src="<?= base_url('uploads/' . esc($item['gambar'])) ?>"
                                class="card-img-top product-img"
                                alt="<?= esc($item['nama_brg']) ?>"
                            >
                            <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-2 px-2 py-1 fw-normal">
                                <?= esc($item['kategori']) ?>
                            </span>
                            <span class="badge <?= (int) $item['stok'] > 0 ? 'text-bg-success' : 'text-bg-danger' ?> position-absolute top-0 end-0 m-2 px-2 py-1 fw-normal">
                                Stok: <?= esc($item['stok']) ?>
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-1 fs-6 text-dark">
                                <?= esc($item['nama_brg']) ?>
                            </h5>
                            <p class="card-text text-muted small product-desc mb-3">
                                <?= esc($item['keterangan']) ?>
                            </p>
                            <div class="mt-auto">
                                <div class="price-tag fw-bold fs-5 text-primary">
                                    Rp <?= number_format((int) $item['harga'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('keranjang/tambah/' . (int) $item['id_brg']) ?>" class="btn btn-primary btn-sm flex-grow-1 fw-medium">
                                    <i class="bi bi-cart-plus me-1"></i>Tambah ke Keranjang
                                </a>
                                <a href="<?= base_url('produk/' . (int) $item['id_brg']) ?>" class="btn btn-outline-secondary btn-sm fw-medium">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
