<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password',
        'role',
        "online_status"
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'username' => 'required|min_length[4]|is_unique[users.username]',
        'password' => 'required|min_length[8]',
        'role' => 'required'
    ];
    protected $validationMessages   = [
        'username' => [
            'required' => 'Username tidak boleh kosong!',
            'is_unique' => 'Username sudah digunakan!',
            'min_length' => 'Username harus lebih dari 4 karakter!',
        ],
        'password' => [
            'required' => 'Password tidak boleh kosong!',
            'min_length' => 'Panjang password minimal 8 karakter!',
        ],
        'role' => [
            'required' => 'Silahkan pilih role!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllUser()
    {
        return $this->orderBy('updated_at', 'desc')->findAll(20);
    }

    public function getUserId($id)
    {
        return $this->where('id', $id)->first();
    }

    public function getUser($username)
    {
        return $this->like('username', $username)->first();
    }

    public function getStatus($username)
    {
        $value = $this->where('username', $username)->first();
        if (!$value) {
            $value["online_status"] = null;
        }
        return $value;
    }
}
