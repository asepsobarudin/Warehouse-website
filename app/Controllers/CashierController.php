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
        $pager = \Config\Services::pager();

        $data = [
            'title' => 'Dashboard',
            'goods' => $this->Goods->getAll(),
            'pager' => $pager
        ];
        return view('pages/home_pages', $data);
    }

    public function product()
    {
        $pager = \Config\Services::pager();

        $data = [
            'goods' => $this->Goods->getAll(),
            'currentPage' => $pager->getCurrentPage(),
            'pageCount'  => $pager->getPageCount(),
            'totalItems' => $pager->getTotal(),
            'nextPage' => $pager->getNextPageURI(),
            'backPage' => $pager->getPreviousPageURI(),
        ];

        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }

    public function search()
    {
        $pager = \Config\Services::pager();
        $requestBody = $this->request->getBody();
        $jsonData = json_decode($requestBody, true);

        $data = [
            'goods' => $this->Goods->search($jsonData['search']),
            'currentPage' => $pager->getCurrentPage(),
            'pageCount'  => $pager->getPageCount(),
            'totalItems' => $pager->getTotal(),
            'nextPage' => $pager->getNextPageURI(),
            'backPage' => $pager->getPreviousPageURI(),
        ];
        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }
}
