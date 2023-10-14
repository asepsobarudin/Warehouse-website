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
        'goods_category',
        'goods_code',
        'goods_name',
        'goods_description',
        'goods_price',
        'goods_prev_price',
        'goods_stok',
        'goods_min_stok',
        'goods_images',
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
        'goods_category' => 'required',
        'goods_price' => 'required|min_length[3]|numeric',
        'goods_prev_price' => 'numeric',
        'goods_stok' => 'min_length[1]|numeric',
        'goods_images' => 'max_size[goods_images,5120]|is_image[goods_images]|mime_in[goods_images,image/png,image/jpeg,image/jpg,image/webp]'
    ];
    protected $validationMessages   = [
        'goods_name' => [
            'required' => 'Nama tidak boleh kosong!',
            'min_length' => 'Minimal panjang nama barang harus lebih 3 karakter!',
            'max_length' => 'Maksimal panjang nama barang adalah 255 karakter'
        ],
        'goods_category' => [
            'required' => 'Category tidak boleh kosong!'
        ],
        'goods_price' => [
            'required' => 'Harga tidak boleh kosong!',
            'min_length' => 'Minimal harga Rp 100',
            'numeric' => 'Input Harus berupa angka!'
        ],
        'goods_stok' => [
            'min_length' => 'Minimal stok 1',
            'numeric' => 'Input Harus berupa angka!'
        ],
        'goods_images' => [
            'max_size' => 'File image tidak boleh lebih dari 5MB!',
            'is_image' => 'Yang anda inputkan bukan file image jpg,jpeg,png!',
            'mime_in' => 'Yang anda inputkan bukan file image jpg,jpeg,png!'
        ]
    ];
    protected $skipValidation       = true;
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
        return $this->orderBy('created_at', 'desc')->paginate(30);
    }

    public function search($search)
    {
        return $this->like("goods_name", $search)->orderBy('created_at', 'desc')->paginate(20);
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
