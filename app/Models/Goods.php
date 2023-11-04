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
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'goods_code',
        'goods_name',
        'goods_price',
        'goods_prev_price',
        'goods_stok_toko',
        'goods_stok_gudang',
        'goods_min_stok',
        'users_id'
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
        'goods_stok_toko' => 'min_length[1]|numeric',
        'goods_stok_gudang' => 'min_length[1]|numeric',
        'goods_min_stok' => 'min_length[1]|numeric',
        'users_id' => 'required'
    ];
    protected $validationMessages   = [
        'goods_name' => [
            'required' => 'Nama tidak boleh kosong!',
            'min_length' => 'Minimal panjang nama barang harus lebih 3 karakter!',
            'max_length' => 'Maksimal panjang nama barang adalah 255 karakter'
        ],
        'goods_price' => [
            'required' => 'Harga tidak boleh kosong!',
            'min_length' => 'Minimal harga Rp 100',
            'numeric' => 'Input Harus berupa angka!'
        ],
        'goods_stok_toko' => [
            'min_length' => 'Stok toko minimal 1!',
            'numeric' => 'Input Harus berupa angka!'
        ],
        'goods_stok_gudang' => [
            'min_length' => 'Stok gudang minimal 1!',
            'numeric' => 'Input Harus berupa angka!'
        ],
        'goods_min_stok' => [
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
        return $this->orderBy('created_at', 'desc')->paginate(20);
    }

    public function getAll()
    {
        return $this->orderBy('goods_stok_toko', 'ASC')->get();
    }

    public function search($search)
    {
        $searchData = "";
        if($search) {
            $searchData = $this->like("goods_name", $search)->orderBy('created_at', 'desc')->paginate(20);
        }

        if($searchData == null) {
            $searchData = $this->like("goods_code", $search)->orderBy('created_at', 'desc')->paginate(20);
        }
        return $searchData;
    }

    public function getOneData($code)
    {
        $getData = $this->where('goods_code', $code)->first();
        return $this->where('id', $getData['id'])->first();
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
