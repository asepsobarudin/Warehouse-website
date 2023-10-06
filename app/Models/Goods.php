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
        'id_category',
        'code_goods',
        'name_goods',
        'description',
        'price',
        'previous_price',
        'store_stok',
        'warehouse_stok',
        'minimum_stok',
        'images',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id_category' => 'required',
        'code_goods' => 'required|is_unique[goods.code_goods]',
        'name_goods' => 'required|min_length[5]|max_length[255]',
        'description' => 'min_length[5]',
        'price' => 'required|min_length[3]',
        'previous_price' => 'min_length[3]',
        'stok_store' => 'min_length[1]',
        'warehouse_stok' => 'min_length[1]',
        'minimum_stok' => 'min_length[1]',
        // 'images' => 'uploaded[images]|max_size[images,3072]|is_image[images]|mime_in[images,image/jpg,image/jpeg,image/png]'
    ];
    protected $validationMessages   = [];
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

    public function getAll() {
        return $this->orderBy('created_at', 'desc')->paginate(30);
    }

    public function search($search)
    {
        return $this->like("name_goods", $search)->orderBy('created_at', 'desc')->paginate(20);
    }

    public function getOneData($code)
    {
        $getData = $this->where('code_goods', $code)->first();
        return $this->where('id', $getData['id'])->first();
    }

    public function uniqueCode()
    {
        $newCode = '';
        $getCode = $this->where('code_goods', $newCode)->first();

        do {
            $prefix = 'GS-';
            $maxDigit = 5;
            $unique = uniqid();


            $result = $this->getAll();
            $maxCode = sizeof($result);
            $newNumericPart = $maxCode + 1;

            $newCode = $prefix . $unique . str_pad($newNumericPart, $maxDigit, '0', STR_PAD_LEFT);
        } while ($newCode == $getCode);

        return $newCode;
    }
}
