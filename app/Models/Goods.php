<?php

namespace App\Models;

use CodeIgniter\Model;

class Goods extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'goods';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'goods_code',
        'goods_name',
        'goods_price',
        'goods_prev_price',
        'goods_stock_shop',
        'goods_stock_warehouse',
        'goods_min_stock',
        'users_id',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'goods_code' => 'is_unique[goods.goods_code]',
        'goods_name' => 'required|min_length[5]|max_length[255]',
        'goods_price' => 'required|min_length[3]|numeric',
        'goods_prev_price' => 'numeric',
        'goods_stock_warehouse' => 'min_length[1]|numeric',
        'goods_min_stock' => 'min_length[1]|numeric',
        'users_id' => 'required'
    ];
    protected $validationMessages   = [
        'goods_name' => [
            'required' => 'Nama barang tidak boleh kosong!',
            'min_length' => 'Minimal panjang nama barang harus lebih 3 karakter!',
            'max_length' => 'Maksimal panjang nama barang adalah 255 karakter'
        ],
        'goods_price' => [
            'required' => 'Harga tidak boleh kosong!',
            'min_length' => 'Minimal harga Rp 100',
            'numeric' => 'Input Harus berupa angka!'
        ],
        'goods_stock_warehouse' => [
            'min_length' => 'Stok gudang tidak boleh minus!',
            'numeric' => 'Input Harus berupa angka!'
        ],
        'goods_min_stock' => [
            'min_length' => 'Stok minimal barang 1!',
            'numeric' => 'Input Harus berupa angka!'
        ],
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

    public function getPaginate()
    {
        return $this->orderBy('goods_name', 'ASC')->paginate(30);
    }

    public function getListDeleted()
    {
        $goods = $this->onlyDeleted()->orderBy('deleted_at', 'DESC')->paginate(1);
        return $goods;
    }

    public function search($search)
    {
        $searchData = [];
        if ($search) {
            $searchData = $this->like("goods_name", $search)->orderBy('goods_name', 'ASC')->findAll(30);
        }

        if ($searchData == null) {
            $searchData = $this->like("goods_code", $search)->orderBy('goods_name', 'ASC')->paginate(30);
        }
        return $searchData;
    }

    public function getOneData($code)
    {
        $goods = $this->like('goods_code', $code)->first();
        return $goods;
    }

    public function getDataById($id)
    {
        $goods = $this->where('id', $id)->first();
        return $goods;
    }

    public function getDataByName($name)
    {
        $goods = $this->like('goods_name', $name)->first();
        return $goods;
    }

    public function uniqueCode()
    {
        $newCode = '';
        $getCode = $this->where('goods_code', $newCode)->first();

        do {
            $prefix = 'GS';
            $maxDigit = 5;
            $unique = uniqid();


            $result = $this->findAll();
            $maxCode = sizeof($result);
            $newNumericPart = $maxCode + 1;

            $newCode = $prefix . $unique . str_pad($newNumericPart, $maxDigit, '0', STR_PAD_LEFT);
        } while ($newCode == $getCode);

        return $newCode;
    }
}
