<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->db->table('tb_barang')->countAllResults() > 0) {
            return;
        }

        $data = [
            [
                'nama_brg'   => 'Sepatu Lari AeroRun Pro',
                'keterangan' => 'Sepatu lari ringan dengan bantalan responsif dan upper mesh breathable untuk olahraga harian.',
                'kategori'   => 'Peralatan Olahraga',
                'harga'      => 675000,
                'stok'       => 18,
                'gambar'     => 'sepatu-lari.jpg',
            ],
            [
                'nama_brg'   => 'Kamera Mirrorless X-M5',
                'keterangan' => 'Kamera mirrorless 26MP dengan lensa kit 15-45mm, perekaman video 4K, dan bodi ringkas.',
                'kategori'   => 'Elektronik',
                'harga'      => 8950000,
                'stok'       => 9,
                'gambar'     => 'kamera-mirrorless.jpg',
            ],
            [
                'nama_brg'   => 'Laptop Ultrabook Pro 14"',
                'keterangan' => 'Laptop tipis berbahan aluminium dengan layar IPS Full HD, SSD NVMe 512GB, dan baterai tahan 12 jam.',
                'kategori'   => 'Elektronik',
                'harga'      => 13500000,
                'stok'       => 12,
                'gambar'     => 'laptop-ultrabook.jpg',
            ],
            [
                'nama_brg'   => 'Headphone Wireless ANC',
                'keterangan' => 'Headphone over-ear Bluetooth 5.3 dengan Active Noise Cancellation dan kualitas audio Hi-Res.',
                'kategori'   => 'Elektronik',
                'harga'      => 1450000,
                'stok'       => 25,
                'gambar'     => 'headphone-anc.jpg',
            ],
            [
                'nama_brg'   => 'Jaket Denim Classic Navy',
                'keterangan' => 'Jaket denim katun tebal 12oz dengan potongan modern fit, jahitan rapi, dan nyaman dipakai harian.',
                'kategori'   => 'Pakaian Pria',
                'harga'      => 345000,
                'stok'       => 30,
                'gambar'     => 'jaket-denim.jpg',
            ],
            [
                'nama_brg'   => 'Tas Ransel Urban Waterproof',
                'keterangan' => 'Tas ransel stylish tahan air dengan kompartemen laptop 15 inci dan desain tali bahu ergonomis.',
                'kategori'   => 'Pakaian Wanita',
                'harga'      => 285000,
                'stok'       => 20,
                'gambar'     => 'tas-ransel.jpg',
            ],
        ];

        $this->db->table('tb_barang')->insertBatch($data);
    }
}
