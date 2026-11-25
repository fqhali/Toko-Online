<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\PesananModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Invoice extends BaseController
{
    protected InvoiceModel $invoiceModel;
    protected PesananModel $pesananModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->pesananModel = new PesananModel();
    }

    public function index(): string
    {
        $data = [
            'title'       => 'Daftar Invoice & Pesanan — Admin TokoOnline',
            'activeAdmin' => 'invoice',
            'invoices'    => $this->invoiceModel->getAllWithTotal(),
        ];

        return view('admin/layout/header', $data)
            . view('admin/invoice/index', $data)
            . view('admin/layout/footer');
    }

    public function detail(int $id): string
    {
        $invoice = $this->invoiceModel->find($id);
        if ($invoice === null) {
            throw PageNotFoundException::forPageNotFound('Invoice tidak ditemukan.');
        }

        $pesanan = $this->pesananModel->getByInvoice($id);
        $total   = 0;
        foreach ($pesanan as $item) {
            $total += (int) $item['harga'] * (int) $item['jumlah'];
        }

        $data = [
            'title'       => 'Detail Invoice #' . $id . ' — Admin TokoOnline',
            'activeAdmin' => 'invoice',
            'invoice'     => $invoice,
            'pesanan'     => $pesanan,
            'total'       => $total,
        ];

        return view('admin/layout/header', $data)
            . view('admin/invoice/detail', $data)
            . view('admin/layout/footer');
    }
}
