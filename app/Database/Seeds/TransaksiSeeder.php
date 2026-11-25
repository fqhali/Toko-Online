<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->db->table('tb_invoice')->countAllResults() > 0) {
            return;
        }

        $tglPesan   = date('Y-m-d H:i:s');
        $batasBayar = date('Y-m-d H:i:s', strtotime('+1 day'));

        $this->db->table('tb_invoice')->insert([
            'nama'        => 'Budi Santoso',
            'alamat'      => 'Jl. Merdeka No. 45, Bandung, Jawa Barat',
            'tgl_pesan'   => $tglPesan,
            'batas_bayar' => $batasBayar,
        ]);

        $invoiceId = $this->db->insertID();

        $barang = $this->db->table('tb_barang')->orderBy('id_brg', 'ASC')->limit(2)->get()->getResultArray();

        if (! empty($barang)) {
            $pesanan = [];
            foreach ($barang as $index => $item) {
                $pesanan[] = [
                    'id_invoice' => $invoiceId,
                    'id_brg'     => $item['id_brg'],
                    'nama_brg'   => $item['nama_brg'],
                    'jumlah'     => $index === 0 ? 1 : 2,
                    'harga'      => $item['harga'],
                    'pilihan'    => null,
                ];
            }

            $this->db->table('tb_pesanan')->insertBatch($pesanan);
        }
    }
}
