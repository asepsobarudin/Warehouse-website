<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Goods;
use App\Models\GoodsHistory;
use App\Models\GoodsRestock;
use App\Models\Restock;
use App\Models\Users;

class DashboardController extends BaseController
{

    protected $Users, $Goods, $Restock, $GoodsRestock, $GoodsHistory;
    public function __construct()
    {
        $this->Users = new Users();
        $this->Goods = new Goods();
        $this->Restock = new Restock();
        $this->GoodsHistory = new GoodsHistory();
        $this->GoodsRestock = new GoodsRestock();
    }

    public function index()
    {
        return view('pages/dashboard/dashboard_page', [
            'title' => 'Dashboard'
        ]);
    }

    public function trash()
    {
        return view('pages/dashboard/menu_page', [
            'title' => 'Trash'
        ]);
    }
}
