<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'username',
        'password',
        'role_id',
    ];

    /**
     * Cari akun pengguna berdasarkan username.
     *
     * @return array<string, mixed>|null
     */
    public function findByUsername(string $username): ?array
    {
        return $this->where('username', $username)->first();
    }
}
