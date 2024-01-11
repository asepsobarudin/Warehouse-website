<?php

namespace App\Models;

use CodeIgniter\Model;

class GoodsHistory extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'goods_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'goods_id',
        'user_id',
        'qty'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'goods_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'qty' => 'required|numeric'
    ];
    protected $validationMessages   = [
        'goods_id' => [
            'required' => 'Data barang tidak ditemukan!',
            'numeric' => 'Input yang dimasukan harus berupa nomor!'
        ],
        'user_id' => [
            'required' => 'Data user tidak ditemukan',
            'numeric' => 'Input yang dimasukan harus berupa nomor!'
        ],
        'qty' => [
            'required' => 'Masukan jumlah barang!',
            'numeric' => 'Input yang dimasukan harus berupa nomor!'
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

    public function listGoods () {
        $listGoods = $this->orderBy('created_at', 'DESC')->findAll();
        return $listGoods;
    }

    public function searchListGoods ($date) {
        return $this->like('created_at', $date)->orderBy('created_at', 'DESC')->findAll();
    }
}
