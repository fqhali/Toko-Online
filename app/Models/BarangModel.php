<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'tb_barang';
    protected $primaryKey       = 'id_brg';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_brg',
        'keterangan',
        'kategori',
        'harga',
        'stok',
        'gambar',
    ];

    /**
     * Ambil daftar produk dengan dukungan filter kategori dan pencarian kata kunci.
     *
     * @return list<array<string, mixed>>
     */
    public function getKatalog(?string $kategori = null, ?string $keyword = null): array
    {
        $builder = $this->builder();

        if ($kategori !== null && $kategori !== '') {
            $builder->where('kategori', $kategori);
        }

        if ($keyword !== null && $keyword !== '') {
            $builder->groupStart()
                ->like('nama_brg', $keyword)
                ->orLike('keterangan', $keyword)
                ->orLike('kategori', $keyword)
                ->groupEnd();
        }

        return $builder->orderBy('id_brg', 'ASC')->get()->getResultArray();
    }

    /**
     * Ambil daftar kategori unik yang tersedia di tabel tb_barang.
     *
     * @return list<string>
     */
    public function getKategoriList(): array
    {
        $rows = $this->select('kategori')
            ->distinct()
            ->orderBy('kategori', 'ASC')
            ->findAll();

        return array_column($rows, 'kategori');
    }
}
