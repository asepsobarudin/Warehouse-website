<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Goods;
use CodeIgniter\HTTP\Request;

class GoodsController extends BaseController
{
    protected $Goods;
    public function __construct()
    {
        $this->Goods = new Goods();
    }
    public function index()
    {
        $pager = \Config\Services::pager();
        $data = [
            'title' => 'Goods',
            'goods' => $this->Goods->getAll(),
            'currentPage' => $pager->getCurrentPage(),
            'pageCount'  => $pager->getPageCount(),
            'totalItems' => $pager->getTotal(),
            'nextPage' => $pager->getNextPageURI(),
            'backPage' => $pager->getPreviousPageURI(),
        ];

        return view('pages/all/goods_page', $data);
    }
}
