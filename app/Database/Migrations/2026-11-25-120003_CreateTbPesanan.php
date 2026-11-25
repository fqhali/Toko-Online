<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbPesanan extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'id_invoice' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_brg' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'nama_brg' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'pilihan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('id_invoice');
        $this->forge->addKey('id_brg');
        $this->forge->createTable('tb_pesanan', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_pesanan', true);
    }
}
