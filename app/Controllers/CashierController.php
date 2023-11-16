<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Goods;

class CashierController extends BaseController
{
    protected $Goods;
    public function __construct()
    {
        $this->Goods = new Goods();
    }

    public function index()
    {
        $data = [
            'title' => 'Kasir',
        ];
        return view('pages/cashier/cashier_page', $data);
    }
}
