<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Admin Panel — TokoOnline') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex min-vh-100">
    <!-- Sidebar -->
    <aside class="admin-sidebar bg-navy text-white d-flex flex-column flex-shrink-0 p-3">
        <a href="<?= base_url('admin') ?>" class="d-flex align-items-center gap-2 text-white text-decoration-none pb-3 mb-3 border-bottom border-secondary border-opacity-25">
            <span class="brand-icon d-inline-flex align-items-center justify-content-center rounded-2">
                <i class="bi bi-speedometer2"></i>
            </span>
            <div>
                <div class="fw-bold lh-1">Admin Panel</div>
                <small class="text-white-50">TokoOnline CI4</small>
            </div>
        </a>

        <ul class="nav nav-pills flex-column gap-1 mb-auto">
            <li class="nav-item">
                <a href="<?= base_url('admin') ?>" class="nav-link text-white <?= ($activeAdmin ?? '') === 'dashboard' ? 'active bg-primary' : 'opacity-75' ?>">
                    <i class="bi bi-house-door-fill me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/barang') ?>" class="nav-link text-white <?= ($activeAdmin ?? '') === 'barang' ? 'active bg-primary' : 'opacity-75' ?>">
                    <i class="bi bi-box-seam-fill me-2"></i>Data Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/invoice') ?>" class="nav-link text-white <?= ($activeAdmin ?? '') === 'invoice' ? 'active bg-primary' : 'opacity-75' ?>">
                    <i class="bi bi-receipt-cutoff me-2"></i>Invoice &amp; Pesanan
                </a>
            </li>
            <li class="nav-item mt-3 pt-3 border-top border-secondary border-opacity-25">
                <a href="<?= base_url('/') ?>" class="nav-link text-white opacity-75">
                    <i class="bi bi-shop me-2"></i>Lihat Katalog Toko
                </a>
            </li>
        </ul>

        <div class="pt-3 border-top border-secondary border-opacity-25">
            <div class="d-flex align-items-center justify-content-between">
                <div class="small">
                    <div class="fw-semibold"><?= esc(session()->get('nama') ?? 'Administrator') ?></div>
                    <div class="text-white-50" style="font-size: 0.75rem;">Role: Admin</div>
                </div>
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light btn-sm" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Area -->
    <div class="flex-grow-1 d-flex flex-column min-w-0">
        <header class="bg-white border-bottom px-4 py-3 d-flex align-items-center justify-content-between shadow-sm">
            <div class="fw-semibold text-dark">
                <?= esc($title ?? 'Dashboard Admin') ?>
            </div>
            <div class="d-flex align-items-center gap-3 small">
                <span class="badge text-bg-primary">
                    <i class="bi bi-shield-check me-1"></i>Admin Terautentikasi
                </span>
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </div>
        </header>

        <main class="p-4 flex-grow-1">
