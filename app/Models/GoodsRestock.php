<?php

namespace App\Models;

use CodeIgniter\Model;

class GoodsRestock extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'goods_restocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'goods_id',
        'restock_id',
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
        'goods_id' => 'required',
        'restock_id' => 'required',
        'qty' => 'required|numeric|min_length[1]'
    ];
    protected $validationMessages   = [
        'goods_id' => [
            'required' => 'Kode barang harus dimasukan'
        ],
        'restock_id' => [
            'required' => 'Restock code tidak boleh kosong'
        ],
        'qty' => [
            'required' => 'Silahkan masukan jumlah barang!',
            'numeric' => 'Nilai harus berupa angka!'
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

    public function listRestock ($id) {
        return $this->like('restock_id', $id)->findAll();
    }
}
