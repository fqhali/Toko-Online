<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Barang extends BaseController
{
    protected BarangModel $barangModel;

    /** @var list<string> */
    private array $kategoriDefault = [
        'Elektronik',
        'Pakaian Pria',
        'Pakaian Wanita',
        'Pakaian Anak',
        'Peralatan Olahraga',
        'Aksesoris',
    ];

    /** @var list<string> */
    private array $seededImages = [
        'sepatu-lari.jpg',
        'kamera-mirrorless.jpg',
        'laptop-ultrabook.jpg',
        'headphone-anc.jpg',
        'jaket-denim.jpg',
        'tas-ransel.jpg',
    ];

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index(): string
    {
        $data = [
            'title'       => 'Kelola Data Barang — Admin TokoOnline',
            'activeAdmin' => 'barang',
            'barang'      => $this->barangModel->orderBy('id_brg', 'DESC')->findAll(),
        ];

        return view('admin/layout/header', $data)
            . view('admin/barang/index', $data)
            . view('admin/layout/footer');
    }

    public function tambah(): string
    {
        $data = [
            'title'        => 'Tambah Barang — Admin TokoOnline',
            'activeAdmin'  => 'barang',
            'mode'         => 'tambah',
            'produk'       => null,
            'kategoriList' => $this->kategoriDefault,
        ];

        return view('admin/layout/header', $data)
            . view('admin/barang/form', $data)
            . view('admin/layout/footer');
    }

    public function simpan(): RedirectResponse
    {
        $rules = [
            'nama_brg'   => 'required|min_length[3]|max_length[120]',
            'keterangan' => 'required|min_length[5]|max_length[225]',
            'kategori'   => 'required|max_length[60]',
            'harga'      => 'required|is_natural_no_zero',
            'stok'       => 'required|is_natural',
            'gambar'     => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $namaGambar = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $namaGambar);

        $this->barangModel->insert([
            'nama_brg'   => trim((string) $this->request->getPost('nama_brg')),
            'keterangan' => trim((string) $this->request->getPost('keterangan')),
            'kategori'   => trim((string) $this->request->getPost('kategori')),
            'harga'      => (int) $this->request->getPost('harga'),
            'stok'       => (int) $this->request->getPost('stok'),
            'gambar'     => $namaGambar,
        ]);

        session()->setFlashdata('success', 'Produk baru berhasil ditambahkan ke katalog.');

        return redirect()->to(base_url('admin/barang'));
    }

    public function edit(int $id): string
    {
        $produk = $this->barangModel->find($id);
        if ($produk === null) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $data = [
            'title'        => 'Edit Barang — Admin TokoOnline',
            'activeAdmin'  => 'barang',
            'mode'         => 'edit',
            'produk'       => $produk,
            'kategoriList' => $this->kategoriDefault,
        ];

        return view('admin/layout/header', $data)
            . view('admin/barang/form', $data)
            . view('admin/layout/footer');
    }

    public function update(int $id): RedirectResponse
    {
        $produk = $this->barangModel->find($id);
        if ($produk === null) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $rules = [
            'nama_brg'   => 'required|min_length[3]|max_length[120]',
            'keterangan' => 'required|min_length[5]|max_length[225]',
            'kategori'   => 'required|max_length[60]',
            'harga'      => 'required|is_natural_no_zero',
            'stok'       => 'required|is_natural',
        ];

        $file = $this->request->getFile('gambar');
        $hasNewImage = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
        if ($hasNewImage) {
            $rules['gambar'] = 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,2048]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaGambar = $produk['gambar'];
        if ($hasNewImage && $file->isValid() && ! $file->hasMoved()) {
            $namaGambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $namaGambar);

            $oldFile = $produk['gambar'];
            if ($oldFile !== '' && ! in_array($oldFile, $this->seededImages, true)) {
                $oldPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . basename($oldFile);
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }
        }

        $this->barangModel->update($id, [
            'nama_brg'   => trim((string) $this->request->getPost('nama_brg')),
            'keterangan' => trim((string) $this->request->getPost('keterangan')),
            'kategori'   => trim((string) $this->request->getPost('kategori')),
            'harga'      => (int) $this->request->getPost('harga'),
            'stok'       => (int) $this->request->getPost('stok'),
            'gambar'     => $namaGambar,
        ]);

        session()->setFlashdata('success', 'Data produk "' . trim((string) $this->request->getPost('nama_brg')) . '" berhasil diperbarui.');

        return redirect()->to(base_url('admin/barang'));
    }

    public function hapus(int $id): RedirectResponse
    {
        $produk = $this->barangModel->find($id);
        if ($produk === null) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $oldFile = $produk['gambar'];
        $this->barangModel->delete($id);

        if ($oldFile !== '' && ! in_array($oldFile, $this->seededImages, true)) {
            $oldPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . basename($oldFile);
            if (is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        session()->setFlashdata('success', 'Produk "' . $produk['nama_brg'] . '" berhasil dihapus.');

        return redirect()->to(base_url('admin/barang'));
    }
}
