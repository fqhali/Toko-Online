<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->db->table('tb_user')->countAllResults() > 0) {
            return;
        }

        $data = [
            [
                'nama'     => 'Administrator',
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id'  => 1,
            ],
            [
                'nama'     => 'Budi Santoso',
                'username' => 'budi',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role_id'  => 2,
            ],
        ];

        $this->db->table('tb_user')->insertBatch($data);
    }
}
