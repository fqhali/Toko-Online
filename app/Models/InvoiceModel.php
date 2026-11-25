<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'tb_invoice';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'alamat',
        'tgl_pesan',
        'batas_bayar',
    ];

    /**
     * Ambil seluruh invoice beserta jumlah item dan total harga dari tb_pesanan.
     *
     * @return list<array<string, mixed>>
     */
    public function getAllWithTotal(?int $limit = null): array
    {
        $builder = $this->db->table('tb_invoice i')
            ->select('i.*, COALESCE(SUM(p.jumlah), 0) AS total_item, COALESCE(SUM(p.jumlah * p.harga), 0) AS total_bayar')
            ->join('tb_pesanan p', 'p.id_invoice = i.id', 'left')
            ->groupBy('i.id')
            ->orderBy('i.id', 'DESC');

        if ($limit !== null) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Hitung total pendapatan dari seluruh pesanan.
     */
    public function getTotalPendapatan(): int
    {
        $row = $this->db->table('tb_pesanan')
            ->select('COALESCE(SUM(jumlah * harga), 0) AS total')
            ->get()
            ->getRowArray();

        return (int) ($row['total'] ?? 0);
    }
}
