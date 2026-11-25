<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbUser extends Migration
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
                'constraint' => 50,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role_id' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 2,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('tb_user', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_user', true);
    }
}
