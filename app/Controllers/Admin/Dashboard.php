<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\InvoiceModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $barangModel  = new BarangModel();
        $invoiceModel = new InvoiceModel();
        $userModel    = new UserModel();

        $allBarang  = $barangModel->orderBy('id_brg', 'ASC')->findAll();
        $totalStok  = array_sum(array_map(static fn (array $row): int => (int) $row['stok'], $allBarang));

        $data = [
            'title'           => 'Dashboard Admin — TokoOnline',
            'activeAdmin'     => 'dashboard',
            'totalBarang'     => count($allBarang),
            'totalStok'       => $totalStok,
            'totalInvoice'    => $invoiceModel->countAllResults(),
            'totalPendapatan' => $invoiceModel->getTotalPendapatan(),
            'totalUser'       => $userModel->countAllResults(),
            'recentInvoices'  => $invoiceModel->getAllWithTotal(5),
            'barangTerbaru'   => array_slice(array_reverse($allBarang), 0, 5),
        ];

        return view('admin/layout/header', $data)
            . view('admin/dashboard', $data)
            . view('admin/layout/footer');
    }
}
