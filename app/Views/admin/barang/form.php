<?php
$isEdit = ($mode ?? 'tambah') === 'edit';
$actionUrl = $isEdit
    ? base_url('admin/barang/update/' . (int) $produk['id_brg'])
    : base_url('admin/barang/simpan');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1"><?= $isEdit ? 'Edit Data Barang' : 'Tambah Barang Baru' ?></h1>
        <p class="text-muted small mb-0">Lengkapi formulir produk di bawah ini dengan informasi yang valid.</p>
    </div>
    <a href="<?= base_url('admin/barang') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger border-0 shadow-sm">
        <div class="fw-semibold mb-1"><i class="bi bi-exclamation-circle me-1"></i>Periksa kembali input Anda:</div>
        <ul class="mb-0 small">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-8">
                    <label for="nama_brg" class="form-label fw-medium">Nama Barang</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nama_brg"
                        name="nama_brg"
                        value="<?= esc(old('nama_brg', $produk['nama_brg'] ?? '')) ?>"
                        placeholder="Contoh: Smartwatch Sport Pro"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label for="kategori" class="form-label fw-medium">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <?php $katVal = old('kategori', $produk['kategori'] ?? 'Elektronik'); ?>
                        <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?= esc($kat) ?>" <?= $katVal === $kat ? 'selected' : '' ?>>
                                <?= esc($kat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12">
                    <label for="keterangan" class="form-label fw-medium">Keterangan Produk</label>
                    <textarea
                        class="form-control"
                        id="keterangan"
                        name="keterangan"
                        rows="3"
                        placeholder="Deskripsi singkat keunggulan dan spesifikasi produk"
                        required
                    ><?= esc(old('keterangan', $produk['keterangan'] ?? '')) ?></textarea>
                </div>

                <div class="col-md-4">
                    <label for="harga" class="form-label fw-medium">Harga (Rp)</label>
                    <input
                        type="number"
                        class="form-control"
                        id="harga"
                        name="harga"
                        min="1"
                        value="<?= esc(old('harga', $produk['harga'] ?? '')) ?>"
                        placeholder="Contoh: 450000"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label for="stok" class="form-label fw-medium">Stok</label>
                    <input
                        type="number"
                        class="form-control"
                        id="stok"
                        name="stok"
                        min="0"
                        value="<?= esc(old('stok', $produk['stok'] ?? '10')) ?>"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label for="gambar" class="form-label fw-medium">
                        Foto Produk <?= $isEdit ? '<span class="text-muted fw-normal small">(Opsional)</span>' : '' ?>
                    </label>
                    <input
                        type="file"
                        class="form-control"
                        id="gambar"
                        name="gambar"
                        accept="image/jpeg,image/png,image/webp"
                        <?= $isEdit ? '' : 'required' ?>
                    >
                    <div class="form-text">Format JPG/PNG/WebP, maksimal 2 MB.</div>
                </div>

                <?php if ($isEdit && ! empty($produk['gambar'])): ?>
                    <div class="col-12">
                        <label class="form-label small text-muted d-block">Gambar Saat Ini:</label>
                        <img
                            src="<?= base_url('uploads/' . esc($produk['gambar'])) ?>"
                            alt="<?= esc($produk['nama_brg']) ?>"
                            class="rounded-3 border shadow-sm object-fit-cover"
                            style="width: 180px; height: 135px;"
                        >
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Barang' ?>
                </button>
                <a href="<?= base_url('admin/barang') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
