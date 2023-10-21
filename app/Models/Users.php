<?php

namespace App\Models;

use CodeIgniter\Model;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
        'token'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'username' => 'required|min_length[4]',
        'password' => 'required|min_length[8]'
    ];
    protected $validationMessages   = [
        'username' => [
            'required' => 'username harus di isi',
            'is_unique' => 'username sudah digunakan',
            'min_length' => 'username harus lebih dari 4 karakter'
        ],
        'password' => [
            'required' => 'Silahkan masukan password',
            'min_length' => 'panjang password minimal 8 karakter'
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


    public function getUser ($username) {
        return $this->like('username', $username)->first();
    }

    public function generateToken ($data) {
        $key = 'tokoKitaNo1';
        $value = $data;
        $algoritma = 'HS256';
        $token = JWT::encode($value, $key, $algoritma);
        return $token;
    }

    public function decodeToken ($data) {
        $token = str_replace('Bearer ', '',  $data);
        $decoded = JWT::decode($token, new Key('tokoKitaNo1', 'HS256'));
        return $decoded;
    }

    public function getToken ($token) {
        $value = $this->where('token', $token)->first();
        return $value['token'];
    }
}
