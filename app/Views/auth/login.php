<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="hero-banner text-white text-center p-4">
                    <span class="brand-icon d-inline-flex align-items-center justify-content-center rounded-3 mb-2" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        <i class="bi bi-person-lock"></i>
                    </span>
                    <h1 class="h4 fw-bold mb-1">Masuk ke TokoOnline</h1>
                    <p class="small text-white-50 mb-0">Login untuk berbelanja, checkout, atau mengelola toko.</p>
                </div>

                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success small border-0 shadow-sm">
                            <i class="bi bi-check-circle-fill me-1"></i><?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger small border-0 shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i><?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('info')): ?>
                        <div class="alert alert-info small border-0 shadow-sm">
                            <i class="bi bi-info-circle-fill me-1"></i><?= esc(session()->getFlashdata('info')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger small border-0 shadow-sm">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label fw-medium small">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    value="<?= esc(old('username', '')) ?>"
                                    placeholder="Masukkan username"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center small">
                        Belum punya akun?
                        <a href="<?= base_url('register') ?>" class="fw-semibold text-decoration-none">Daftar Sekarang</a>
                    </div>

                    <div class="mt-3 p-3 bg-light rounded-3 border small">
                        <div class="fw-semibold text-dark mb-1"><i class="bi bi-info-circle text-primary me-1"></i>Akun Demo (Seeder):</div>
                        <div class="text-muted">Admin: <code>admin</code> / <code>admin123</code></div>
                        <div class="text-muted">Customer: <code>budi</code> / <code>user123</code></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
