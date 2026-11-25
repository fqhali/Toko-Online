<?php
$cartSession = session()->get('cart');
$cartCount   = 0;
if (is_array($cartSession)) {
    foreach ($cartSession as $cartItem) {
        $cartCount += (int) ($cartItem['qty'] ?? 0);
    }
}
$isLoggedIn = (bool) session()->get('isLoggedIn');
$roleId     = (int) session()->get('role_id');
$userName   = (string) session()->get('nama');
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'TokoOnline — CodeIgniter 4') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-navy sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
            <span class="brand-icon d-inline-flex align-items-center justify-content-center rounded-2">
                <i class="bi bi-bag-check-fill"></i>
            </span>
            <span>TokoOnline</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                <li class="nav-item">
                    <a class="nav-link <?= ($activeMenu ?? '') === 'home' ? 'active fw-semibold' : '' ?>" href="<?= base_url('/') ?>">
                        <i class="bi bi-grid-fill me-1"></i>Katalog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($activeMenu ?? '') === 'about' ? 'active fw-semibold' : '' ?>" href="<?= base_url('about') ?>">
                        Tentang Kami
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($activeMenu ?? '') === 'contact' ? 'active fw-semibold' : '' ?>" href="<?= base_url('contact') ?>">
                        Kontak
                    </a>
                </li>
            </ul>

            <form class="d-flex me-lg-3 my-2 my-lg-0" role="search" method="get" action="<?= base_url('/') ?>">
                <div class="input-group input-group-sm">
                    <input class="form-control border-0" type="search" name="q" placeholder="Cari produk..." aria-label="Cari produk" value="<?= esc($keyword ?? '') ?>">
                    <button class="btn btn-primary px-3" type="submit" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="d-flex align-items-center gap-2">
                <a href="<?= base_url('keranjang') ?>" class="btn <?= ($activeMenu ?? '') === 'keranjang' ? 'btn-primary' : 'btn-outline-light' ?> btn-sm">
                    <i class="bi bi-cart3 me-1"></i>Keranjang
                    <span class="badge <?= $cartCount > 0 ? 'text-bg-warning text-dark' : 'text-bg-primary' ?> ms-1"><?= $cartCount ?></span>
                </a>

                <?php if ($isLoggedIn): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i><?= esc($userName) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm small">
                            <li>
                                <span class="dropdown-item-text text-muted">
                                    Login sebagai <strong><?= $roleId === 1 ? 'Administrator' : 'Pelanggan' ?></strong>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if ($roleId === 1): ?>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin') ?>">
                                        <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Admin
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('keranjang') ?>">
                                    <i class="bi bi-cart3 me-2 text-primary"></i>Keranjang Belanja
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow-1">
