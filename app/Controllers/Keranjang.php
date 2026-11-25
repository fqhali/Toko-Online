<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\InvoiceModel;
use App\Models\PesananModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Keranjang extends BaseController
{
    protected BarangModel $barangModel;
    protected InvoiceModel $invoiceModel;
    protected PesananModel $pesananModel;

    public function __construct()
    {
        $this->barangModel  = new BarangModel();
        $this->invoiceModel = new InvoiceModel();
        $this->pesananModel = new PesananModel();
    }

    /**
     * Ambil isi keranjang dari session.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getCart(): array
    {
        $cart = session()->get('cart');

        return is_array($cart) ? $cart : [];
    }

    public function index(): string
    {
        $cart  = $this->getCart();
        $items = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $produk = $this->barangModel->find((int) $id);
            if ($produk === null) {
                continue;
            }

            $qty      = max(1, (int) $item['qty']);
            $harga    = (int) $produk['harga'];
            $subtotal = $harga * $qty;
            $total   += $subtotal;

            $items[] = [
                'id_brg'   => (int) $produk['id_brg'],
                'nama_brg' => $produk['nama_brg'],
                'kategori' => $produk['kategori'],
                'gambar'   => $produk['gambar'],
                'harga'    => $harga,
                'stok'     => (int) $produk['stok'],
                'qty'      => $qty,
                'subtotal' => $subtotal,
            ];
        }

        $data = [
            'title'      => 'Keranjang Belanja — TokoOnline',
            'activeMenu' => 'keranjang',
            'items'      => $items,
            'total'      => $total,
        ];

        return view('layout/header', $data)
            . view('keranjang/index', $data)
            . view('layout/footer');
    }

    public function tambah(int $id): RedirectResponse
    {
        $produk = $this->barangModel->find($id);

        if ($produk === null) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        if ((int) $produk['stok'] <= 0) {
            session()->setFlashdata('error', 'Maaf, stok produk "' . $produk['nama_brg'] . '" sedang habis.');

            return redirect()->back();
        }

        $cart       = $this->getCart();
        $currentQty = isset($cart[$id]) ? (int) $cart[$id]['qty'] : 0;

        if ($currentQty + 1 > (int) $produk['stok']) {
            session()->setFlashdata('error', 'Jumlah di keranjang sudah mencapai batas stok tersedia (' . $produk['stok'] . ' unit).');

            return redirect()->back();
        }

        $cart[$id] = [
            'id_brg'   => (int) $produk['id_brg'],
            'nama_brg' => $produk['nama_brg'],
            'harga'    => (int) $produk['harga'],
            'gambar'   => $produk['gambar'],
            'kategori' => $produk['kategori'],
            'qty'      => $currentQty + 1,
        ];

        session()->set('cart', $cart);
        session()->setFlashdata('success', '"' . $produk['nama_brg'] . '" berhasil ditambahkan ke keranjang.');

        return redirect()->to(base_url('keranjang'));
    }

    public function update(): RedirectResponse
    {
        $id  = (int) $this->request->getPost('id_brg');
        $qty = (int) $this->request->getPost('qty');

        $cart = $this->getCart();
        if (! isset($cart[$id])) {
            return redirect()->to(base_url('keranjang'));
        }

        if ($qty <= 0) {
            unset($cart[$id]);
            session()->set('cart', $cart);
            session()->setFlashdata('info', 'Produk dihapus dari keranjang.');

            return redirect()->to(base_url('keranjang'));
        }

        $produk = $this->barangModel->find($id);
        if ($produk === null) {
            unset($cart[$id]);
            session()->set('cart', $cart);

            return redirect()->to(base_url('keranjang'));
        }

        if ($qty > (int) $produk['stok']) {
            session()->setFlashdata('error', 'Stok "' . $produk['nama_brg'] . '" hanya tersedia ' . $produk['stok'] . ' unit.');

            return redirect()->to(base_url('keranjang'));
        }

        $cart[$id]['qty'] = $qty;
        session()->set('cart', $cart);
        session()->setFlashdata('success', 'Jumlah "' . $produk['nama_brg'] . '" diperbarui menjadi ' . $qty . '.');

        return redirect()->to(base_url('keranjang'));
    }

    public function hapus(int $id): RedirectResponse
    {
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            $nama = $cart[$id]['nama_brg'] ?? 'Produk';
            unset($cart[$id]);
            session()->set('cart', $cart);
            session()->setFlashdata('info', '"' . $nama . '" dihapus dari keranjang.');
        }

        return redirect()->to(base_url('keranjang'));
    }

    public function kosongkan(): RedirectResponse
    {
        session()->remove('cart');
        session()->setFlashdata('info', 'Keranjang belanja telah dikosongkan.');

        return redirect()->to(base_url('keranjang'));
    }

    public function checkout(): RedirectResponse|string
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            session()->setFlashdata('error', 'Keranjang belanja masih kosong. Silakan pilih produk terlebih dahulu.');

            return redirect()->to(base_url('keranjang'));
        }

        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $produk = $this->barangModel->find((int) $id);
            if ($produk === null) {
                continue;
            }
            $qty      = max(1, (int) $item['qty']);
            $harga    = (int) $produk['harga'];
            $subtotal = $harga * $qty;
            $total   += $subtotal;

            $items[] = [
                'id_brg'   => (int) $produk['id_brg'],
                'nama_brg' => $produk['nama_brg'],
                'harga'    => $harga,
                'qty'      => $qty,
                'subtotal' => $subtotal,
            ];
        }

        if (empty($items)) {
            session()->remove('cart');

            return redirect()->to(base_url('keranjang'));
        }

        $data = [
            'title'      => 'Checkout Pesanan — TokoOnline',
            'activeMenu' => 'keranjang',
            'items'      => $items,
            'total'      => $total,
            'validation' => service('validation'),
        ];

        return view('layout/header', $data)
            . view('keranjang/checkout', $data)
            . view('layout/footer');
    }

    public function prosesCheckout(): RedirectResponse
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            session()->setFlashdata('error', 'Keranjang belanja kosong.');

            return redirect()->to(base_url('keranjang'));
        }

        $rules = [
            'nama'              => 'required|min_length[3]|max_length[56]',
            'alamat'            => 'required|min_length[10]|max_length[225]',
            'jasa_pengiriman'   => 'required|max_length[50]',
            'metode_pembayaran' => 'required|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama       = trim((string) $this->request->getPost('nama'));
        $alamat     = trim((string) $this->request->getPost('alamat'));
        $kurir      = trim((string) $this->request->getPost('jasa_pengiriman'));
        $pembayaran = trim((string) $this->request->getPost('metode_pembayaran'));
        $pilihan    = 'Kurir: ' . $kurir . ' | Pembayaran: ' . $pembayaran;

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $verifiedItems = [];
            foreach ($cart as $id => $item) {
                $produk = $this->barangModel->find((int) $id);
                $qty    = max(1, (int) $item['qty']);

                if ($produk === null) {
                    throw new \RuntimeException('Salah satu produk tidak ditemukan di database.');
                }

                if ((int) $produk['stok'] < $qty) {
                    throw new \RuntimeException(
                        'Stok "' . $produk['nama_brg'] . '" tidak mencukupi (tersisa ' . $produk['stok'] . ' unit).'
                    );
                }

                $verifiedItems[] = [
                    'produk' => $produk,
                    'qty'    => $qty,
                ];
            }

            $tglPesan   = date('Y-m-d H:i:s');
            $batasBayar = date('Y-m-d H:i:s', strtotime('+1 day'));

            $this->invoiceModel->insert([
                'nama'        => $nama,
                'alamat'      => $alamat,
                'tgl_pesan'   => $tglPesan,
                'batas_bayar' => $batasBayar,
            ]);

            $invoiceId = (int) $this->invoiceModel->getInsertID();

            foreach ($verifiedItems as $entry) {
                $produk = $entry['produk'];
                $qty    = $entry['qty'];

                $this->pesananModel->insert([
                    'id_invoice' => $invoiceId,
                    'id_brg'     => (int) $produk['id_brg'],
                    'nama_brg'   => $produk['nama_brg'],
                    'jumlah'     => $qty,
                    'harga'      => (int) $produk['harga'],
                    'pilihan'    => $pilihan,
                ]);

                $this->barangModel->update((int) $produk['id_brg'], [
                    'stok' => (int) $produk['stok'] - $qty,
                ]);
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Gagal menyimpan transaksi ke database.');
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            session()->setFlashdata('error', $e->getMessage());

            return redirect()->back()->withInput();
        }

        session()->remove('cart');
        session()->set('last_invoice_id', $invoiceId);
        session()->setFlashdata('success', 'Pesanan berhasil dibuat dengan nomor Invoice #' . $invoiceId . '!');

        return redirect()->to(base_url('checkout/sukses/' . $invoiceId));
    }

    public function sukses(int $id): RedirectResponse|string
    {
        $lastInvoiceId = (int) session()->get('last_invoice_id');
        $isAdmin       = (int) session()->get('role_id') === 1;

        if (! $isAdmin && $lastInvoiceId !== $id) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke invoice tersebut.');

            return redirect()->to(base_url('/'));
        }

        $invoice = $this->invoiceModel->find($id);
        if ($invoice === null) {
            throw PageNotFoundException::forPageNotFound('Invoice tidak ditemukan.');
        }

        $pesanan = $this->pesananModel->getByInvoice($id);
        $total   = 0;
        foreach ($pesanan as $row) {
            $total += (int) $row['harga'] * (int) $row['jumlah'];
        }

        $data = [
            'title'      => 'Pesanan Berhasil #' . $id . ' — TokoOnline',
            'activeMenu' => 'keranjang',
            'invoice'    => $invoice,
            'pesanan'    => $pesanan,
            'total'      => $total,
        ];

        return view('layout/header', $data)
            . view('keranjang/sukses', $data)
            . view('layout/footer');
    }
}
