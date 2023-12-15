<?php

namespace App\Models;

use CodeIgniter\Model;

class Restock extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'restocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'restock_code',
        'status',
        'user_id',
        'message',
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
        'restock_code' => 'required|is_unique[restocks.restock_code]',
        'status' => 'required|numeric',
        'user_id' => 'required',
    ];
    protected $validationMessages = [
        'restock_code' => [
            'required' => 'Restock Code tidak boleh kosong!'
        ],
        'status' => [
            'required' => 'Status tidak boleh kosong!',
            'numeric' => 'Status harus berupa angka!'
        ],
        'user_id' => [
            'required' => 'User tidak ditemukan!'
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


    protected $Users;
    public function __construct()
    {
        parent::__construct();
        $this->Users = new Users();
    }

    public function getPaginate()
    {
        $restockList = $this->orderBy('updated_at', 'DESC')->paginate(30);
        $restock = [];
        foreach ($restockList as $list) {
            $users = $this->Users->getUserId($list['user_id']);
            $list['user_id'] = $users['username'];
            unset($users);
            $restock = array_merge($restock, [$list]);
        }
        return $restock;
    }

    public function searchListRestock ($date) {
        return $this->like('updated_at', $date)->orderBy('updated_at', 'DESC')->findAll();
    }

    public function getOneData($code)
    {
        return $this->where('restock_code', $code)->first();
    }

    public function getDataById($id)
    {
        return $this->where('id', $id)->withDeleted()->first();
    }

    public function uniqueCode()
    {
        $newCode = '';
        $getCode = $this->where('restock_code', $newCode)->first();

        do {
            $prefix = 'RS';
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
