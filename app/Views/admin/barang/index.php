<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Kelola Data Barang</h1>
        <p class="text-muted small mb-0">Tambah, ubah, dan hapus produk yang tampil di katalog TokoOnline.</p>
    </div>
    <a href="<?= base_url('admin/barang/tambah') ?>" class="btn btn-primary btn-sm px-3">
        <i class="bi bi-plus-lg me-1"></i>Tambah Barang
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-uppercase text-muted">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center pe-4" style="width: 170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($barang)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">Belum ada data barang.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($barang as $index => $item): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img
                                        src="<?= base_url('uploads/' . esc($item['gambar'])) ?>"
                                        alt="<?= esc($item['nama_brg']) ?>"
                                        class="rounded-2 border object-fit-cover"
                                        style="width: 60px; height: 45px;"
                                    >
                                    <div>
                                        <div class="fw-semibold text-dark"><?= esc($item['nama_brg']) ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 300px;">
                                            <?= esc($item['keterangan']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge text-bg-secondary fw-normal"><?= esc($item['kategori']) ?></span></td>
                            <td class="text-end fw-semibold text-primary text-nowrap">
                                Rp <?= number_format((int) $item['harga'], 0, ',', '.') ?>
                            </td>
                            <td class="text-center">
                                <span class="badge <?= (int) $item['stok'] > 0 ? 'text-bg-success' : 'text-bg-danger' ?>">
                                    <?= esc($item['stok']) ?>
                                </span>
                            </td>
                            <td class="text-center pe-4 text-nowrap">
                                <a href="<?= base_url('admin/barang/edit/' . (int) $item['id_brg']) ?>" class="btn btn-outline-primary btn-sm me-1">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <form action="<?= base_url('admin/barang/hapus/' . (int) $item['id_brg']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk <?= esc($item['nama_brg'], 'js') ?>?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
