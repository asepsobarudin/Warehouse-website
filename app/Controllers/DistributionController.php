<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\JwtHelpers;
use App\Helpers\SessionHelpers;
use App\Models\Goods;
use App\Models\GoodsRestock;
use App\Models\Restock;
use App\Models\Users;

class DistributionController extends BaseController
{
    protected $Restock, $GoodsRestock, $Goods, $Users;
    protected $JwtHelpers, $SessionHelpers;
    public function __construct()
    {
        $this->Restock = new Restock();
        $this->GoodsRestock = new GoodsRestock();
        $this->Goods = new Goods();
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
        $this->SessionHelpers = new SessionHelpers();
    }
}
