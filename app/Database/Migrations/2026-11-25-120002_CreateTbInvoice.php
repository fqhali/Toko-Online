<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbInvoice extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 56,
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => 225,
            ],
            'tgl_pesan' => [
                'type' => 'DATETIME',
            ],
            'batas_bayar' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_invoice', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_invoice', true);
    }
}
