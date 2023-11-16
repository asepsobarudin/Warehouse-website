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
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'restock_code',
        'status',
        'request_user_id',
        'response_user_id',
        'message'
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
        'status' => 'required',
    ];
    protected $validationMessages = [
        'restock_code' => [
            'required' => 'Restock Code tidak boleh kosong'
        ],
        'status' => [
            'required' => 'Status tidak boleh kosong'
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
        return $this->orderBy('created_at', 'DESC')->paginate(20);
    }

    public function getOneData($code)
    {
        return $this->where('restock_code', $code)->first();
    }

    public function getDataById ($id) {
        return $this->where('id', $id)->first();
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
