<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbBarang extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_brg' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_brg' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 225,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'gambar' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey('id_brg', true);
        $this->forge->createTable('tb_barang', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_barang', true);
    }
}
