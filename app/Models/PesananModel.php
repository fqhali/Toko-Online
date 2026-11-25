<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table            = 'tb_pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_invoice',
        'id_brg',
        'nama_brg',
        'jumlah',
        'harga',
        'pilihan',
    ];

    /**
     * Ambil seluruh item pesanan berdasarkan ID invoice.
     *
     * @return list<array<string, mixed>>
     */
    public function getByInvoice(int $idInvoice): array
    {
        return $this->where('id_invoice', $idInvoice)
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}
