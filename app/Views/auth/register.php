<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="hero-banner text-white text-center p-4">
                    <span class="brand-icon d-inline-flex align-items-center justify-content-center rounded-3 mb-2" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        <i class="bi bi-person-plus"></i>
                    </span>
                    <h1 class="h4 fw-bold mb-1">Daftar Akun Baru</h1>
                    <p class="small text-white-50 mb-0">Buat akun pelanggan untuk mulai berbelanja di TokoOnline.</p>
                </div>

                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger small border-0 shadow-sm">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium small">Nama Lengkap</label>
                            <input
                                type="text"
                                class="form-control"
                                id="nama"
                                name="nama"
                                value="<?= esc(old('nama', '')) ?>"
                                placeholder="Contoh: Siti Aminah"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label fw-medium small">Username</label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                value="<?= esc(old('username', '')) ?>"
                                placeholder="Minimal 4 karakter (huruf, angka, _ atau -)"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium small">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Minimal 6 karakter"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="password_confirm" class="form-label fw-medium small">Konfirmasi Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirm"
                                name="password_confirm"
                                placeholder="Ulangi password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-person-check me-2"></i>Daftar Akun
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center small">
                        Sudah punya akun?
                        <a href="<?= base_url('login') ?>" class="fw-semibold text-decoration-none">Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
