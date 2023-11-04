<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Goods;
use App\Models\GoodsRestock;
use App\Models\Restock;
use App\Models\Users;

class RestockController extends BaseController
{
    protected $Restock, $GoodsRestock, $Goods, $Users, $validation;
    public function __construct()
    {
        $this->Restock = new Restock();
        $this->GoodsRestock = new GoodsRestock();
        $this->Goods = new Goods();
        $this->Users = new Users();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $pager = \Config\Services::pager();
        $data = [
            'title' => 'Stok',
            'restock' => $this->Restock->getPaginate(),
            'pager' => $pager
        ];

        return view('pages/restock/restock_page', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Buat Request Barang',
            'link' => '/restock',
            'goods' => $this->Goods->getAll(),
            'noRes' => $this->Restock->uniqueCode()
        ];
        return view('pages/restock/restock_create', $data);
    }

    public function addGoods()
    {
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        if ($body && isset($body['restock'])) {
            $noRestock = $this->Restock->getOneData($body['restock']);
            $users = $this->Users->getUser(session()->get('username'));
            $goods = $this->Goods->getOneData($body['goods']);

            if (!$noRestock) {
                $data = [
                    'restock_code' => $body['restock'],
                    'status' => 'process',
                    'request_user_id' => $users['id'],
                    'response_user_id' => null
                ];

                $rules = $this->Restock->getValidationRules();
                $rules = array_merge($rules, ['request_user_id' => 'required']);
                $message = $this->Restock->getValidationMessages();
                $message = array_merge($message, [
                    'request_user_id' => [
                        'required' => 'Request user tidak boleh kosong'
                    ]
                ]);

                if (!$this->validateData($data, $rules, $message)) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => $this->validation->getErrors()]);
                } else {
                    if ($this->Restock->insert($data)) {
                        $noRestock = $this->Restock->getOneData($body['restock']);
                    } else {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['errors' => 'Input invalid!']);
                    }
                }
            }

            if ($noRestock) {
                $data = [
                    'goods_id' => $goods['id'],
                    'restock_id' => $noRestock['id'],
                    'qty' => $body['qty']
                ];

                $rules = $this->GoodsRestock->getValidationRules();
                $message = $this->GoodsRestock->getValidationMessages();
                if(!$this->validateData($data, $rules, $message)) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => $this->validation->getErrors()]);
                } else {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['success' => 'success']);
                }
            } else {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Input Invaidd!']);
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Input Invaid!']);
        }
    }
}
