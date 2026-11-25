<?php

namespace App\Controllers;

use App\Models\BarangModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    protected BarangModel $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index(): string
    {
        $kategori = trim((string) $this->request->getGet('kategori'));
        $keyword  = trim((string) $this->request->getGet('q'));

        $data = [
            'title'         => 'Katalog Produk — TokoOnline',
            'activeMenu'    => 'home',
            'barang'        => $this->barangModel->getKatalog($kategori, $keyword),
            'kategoriList'  => $this->barangModel->getKategoriList(),
            'kategoriAktif' => $kategori,
            'keyword'       => $keyword,
        ];

        return view('layout/header', $data)
            . view('katalog/index', $data)
            . view('layout/footer');
    }

    public function detail(int $id): string
    {
        $produk = $this->barangModel->find($id);

        if ($produk === null) {
            throw PageNotFoundException::forPageNotFound('Produk dengan ID ' . $id . ' tidak ditemukan.');
        }

        $data = [
            'title'      => $produk['nama_brg'] . ' — TokoOnline',
            'activeMenu' => 'home',
            'produk'     => $produk,
        ];

        return view('layout/header', $data)
            . view('katalog/detail', $data)
            . view('layout/footer');
    }
}
