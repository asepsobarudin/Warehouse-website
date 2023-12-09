<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\JwtHelpers;
use App\Models\Goods;
use App\Models\GoodsHistory;
use App\Models\Users;
use CodeIgniter\I18n\Time;

class GoodsController extends BaseController
{
    protected $Goods, $GoodsHistory, $Users, $JwtHelpers;
    public function __construct()
    {
        $this->Goods = new Goods();
        $this->Users = new Users();
        $this->GoodsHistory = new GoodsHistory();
        $this->JwtHelpers = new JwtHelpers();
    }
    public function index()
    {
        $data = [
            'title' => 'Barang',
        ];

        return view('pages/goods/goods_page', $data);
    }

    // Json Response
    public function goodsList()
    {
        $lengthData = sizeof($this->Goods->getPaginate());
        $nextURL = null;
        if ($lengthData != 0) {
            $nextURL = $this->Pager->getNextPageURI();
        }

        $getGoods = $this->Goods->getPaginate();
        $setGoods = [];
        foreach ($getGoods as $goods) {
            unset($goods['id']);
            unset($goods['users_id']);
            $setGoods = array_merge($setGoods, [$goods]);
        }

        $data = [
            'goods' => $setGoods,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'perPage' => $this->Pager->getPerPage(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $nextURL,
            'backPage' => $this->Pager->getPreviousPageURI(),
        ];

        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }

    public function goodsSearch()
    {
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        $getGoods = $this->Goods->search($body['search']);
        $setGoods = [];
        foreach ($getGoods as $goods) {
            unset($goods['id']);
            unset($goods['users_id']);
            $setGoods = array_merge($setGoods, [$goods]);
        }

        $data = [
            'goods' => $setGoods,
        ];
        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }
    // End Json Response

    public function create()
    {
        $body = $this->request->getPost();
        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        if ($body && isset($decoded->username)) {
            if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
                session()->setFlashdata('errors', 'Barang gagal ditambahkan!');
                return redirect()->back();
            }

            $prepPrice = ['goods_prev_price' => 0];
            $body = array_merge($body, $prepPrice);
            $body = array_merge($body, ['goods_code' => $this->Goods->uniqueCode()]);
            $users = $this->Users->getUser($decoded->username);
            $body['users_id'] = $users['id'];
            unset($decoded->username);

            if (isset($body['goods_price'])) {
                $price = (int)$body['goods_price'];
                if ($price < 0) {
                    $body['goods_price'] = 0;
                } else {
                    $body['goods_price'] = $price;
                }
            }

            if (isset($body['goods_min_stock'])) {
                $minStok = (int)$body['goods_min_stock'];
                if ($minStok < 1) {
                    $body['goods_min_stock'] = '';
                } else {
                    $body['goods_min_stock'] = $minStok;
                }
            }

            if (isset($body['goods_stock_warehouse'])) {
                $warehouse = (int)$body['goods_stock_warehouse'];
                if ($warehouse < 0) {
                    $body['goods_stock_warehouse'] = '';
                } else {
                    $body['goods_stock_warehouse'] = $warehouse;
                }
            }

            if (!$this->validateData($body, $this->Goods->getValidationRules(), $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $data = [
                    'goods_code' => $body['goods_code'],
                    'goods_name' => $body['goods_name'],
                    'goods_price' => $body['goods_price'],
                    'goods_prev_price' => $body['goods_prev_price'],
                    'goods_stock_warehouse' => $body['goods_stock_warehouse'],
                    'goods_min_stock' => $body['goods_min_stock'],
                    'users_id' => $body['users_id']
                ];
                if ($this->Goods->insert($data)) {
                    session()->setFlashdata('success', 'Barang berhasil di tambahkan');
                    return redirect()->to('/goods');
                } else {
                    session()->setFlashdata('errors', 'Barang gagal di tambahkan');
                    return redirect()->to('/goods');
                }
            }
        } else {
            $data = [
                'title' => 'Tambah barang',
                'link' => '/goods'
            ];
            return view('pages/goods/goods_create', $data);
        }
    }

    public function edit($slug)
    {
        $goods = $this->Goods->getOneData($slug);
        $users = $this->Users->getUserId($goods['users_id']);
        $goods['users_id'] = $users['username'];
        if ($goods) {
            unset($goods['id']);
            $goods['created_at'] = Time::parse($goods['created_at'], 'Asia/Jakarta', 'id-ID')->humanize();
            $goods['updated_at'] = Time::parse($goods['updated_at'], 'Asia/Jakarta', 'id-ID')->humanize();
            $data = [
                'title' => "Edit barang",
                'link' => '/goods',
                'goods' => $goods,
            ];

            return view('pages/goods/goods_edit', $data);
        } else {
            session()->setFlashdata('errors', 'Data barang tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function update()
    {
        $body = $this->request->getPost();
        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if (isset($body['goods_price'])) {
            $price = (int)$body['goods_price'];
            if ($price < 0) {
                $body['goods_price'] = 0;
            } else {
                $body['goods_price'] = $price;
            }
        }


        if (isset($body['goods_min_stock'])) {
            $minStok = (int)$body['goods_min_stock'];
            if ($minStok < 1) {
                $body['goods_min_stock'] = '';
            } else {
                $body['goods_min_stock'] = $minStok;
            }
        }

        if ($body && isset($body['goods_code']) && isset($decoded->username)) {
            $goods = $this->Goods->getOneData($body['goods_code']);
            $users = $this->Users->getUser($decoded->username);
            $body = array_merge($body, ['users_id' => $users['id']]);
            $rules = $this->Goods->getValidationRules();
            $message = $this->Goods->getValidationMessages();
            unset($body['goods_code']);
            unset($rules['goods_stock_warehouse']);

            if ($body) {
                if ($goods['goods_price'] != $body['goods_price']) {
                    $body += ['goods_prev_price' => $goods['goods_price']];
                } else {
                    $body += ['goods_prev_price' => 0];
                }
            }

            $data = [
                'goods_name' => $body['goods_name'],
                'goods_price' => $body['goods_price'],
                'goods_prev_price' => $body['goods_prev_price'],
                'goods_min_stock' => $body['goods_min_stock'],
                'users_id' => $body['users_id']
            ];

            if ($this->validateData($data, $rules, $message) && $this->Goods->update($goods['id'], $data)) {
                session()->setFlashdata('success', 'Barang berhasil di update.');
                return redirect()->to('/goods');
            } else {
                session()->setFlashdata('errors', 'Barang gagal di update!');
                session()->setFlashdata('open', 'open');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('errors', 'Barang yang akan di update tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function updateStock()
    {
        $body = $this->request->getPost();
        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['goods_code']) && isset($decoded->username)) {
            $goods = $this->Goods->getOneData($body['goods_code']);
            $users = $this->Users->getUser($decoded->username);
            $body = array_merge($body, ['users_id' => $users['id']]);
            unset($body['goods_code']);

            $rules = $this->Goods->getValidationRules();
            $message = $this->Goods->getValidationMessages();
            unset($rules['goods_name']);
            unset($rules['goods_price']);
            unset($rules['goods_prev_price']);
            unset($rules['goods_min_stock']);

            $data = [];

            if (isset($body['goods_stock_warehouse'])) {
                $warehouse = (int)$body['goods_stock_warehouse'];
                if ($warehouse < 0) {
                    $body['goods_stock_warehouse'] = '';
                } else {
                    $body['goods_stock_warehouse'] = $warehouse;
                }

                $data = [
                    'goods_stock_warehouse' => $body['goods_stock_warehouse'],
                    'users_id' => $body['users_id']
                ];
            }

            if ($this->validateData($data, $rules, $message) && $this->Goods->update($goods['id'], $data)) {
                session()->setFlashdata('success', 'Stok barang berhasil di update.');
                return redirect()->to('/goods');
            } else {
                session()->setFlashdata('errors', 'Stok barang gagal di update!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Stok barang yang akan di update tidak di temukan!');
            return redirect()->back();
        }
    }

    public function delete()
    {
        $body = $this->request->getPost();
        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['goods_code']) && isset($decoded->username)) {
            $goods = $this->Goods->getOneData($body['goods_code']);
            $users = $this->Users->getUser($decoded->username);
            if ($goods && $users) {
                $this->Goods->update($goods['id'], ['users_id' => $users['id']]);
                $this->Goods->delete($goods['id']);
                session()->setFlashdata('success', 'Barang berhasil di hapus.');
                return redirect()->to('/goods');
            } else {
                session()->setFlashdata('errors', 'Barang tidak ditemukan!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Barang tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function trash()
    {
        $getGoods = $this->Goods->getListDeleted();
        $setGoods = [];
        foreach ($getGoods as $list) {
            unset($list['id']);
            $users = $this->Users->getUserId($list['users_id']);
            if(isset($users['username'])) {
                $list['users_id'] = $users['username'];
            } else {
                $list['users_id'] = 'Tidak ditemukan';
            }
            $setGoods = array_merge($setGoods, [$list]);
        }

        $data = [
            'goods' => $setGoods
        ];
        
        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }

    public function restore()
    {
        $body = $this->request->getPost();

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['goods_code'])) {
            $goods = $this->Goods->onlyDeleted()->where('goods_code', $body['goods_code'])->first();
            $data = [
                'id' => $goods['id'],
                'deleted_at' => null
            ];

            if ($goods && $this->Goods->onlyDeleted()->save($data)) {
                session()->setFlashdata('success', 'Barang berhasil di kembalikan.');
                return redirect()->back();
            } else {
                session()->setFlashdata('errors', 'Data barang gagal di kembalikan!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Barang tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function deleteTrash()
    {
        $body = $this->request->getPost();

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['goods_code'])) {
            $goods = $this->Goods->onlyDeleted()->where('goods_code', $body['goods_code'])->first();
            if ($goods && $this->Goods->onlyDeleted()->delete($goods['id'], true)) {
                session()->setFlashdata('success', 'Barang berhasil di hapus secara permanen.');
                return redirect()->back();
            } else {
                session()->setFlashdata('errors', 'Data barang gagal di hapus!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Barang tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function deleteAllTrash()
    {
        $body = $this->request->getPost();

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && $this->Goods->onlyDeleted()->purgeDeleted()) {
            session()->setFlashdata('success', 'Semua data barang berhasil di hapus secara permanen.');
            return redirect()->back();
        } else {
            session()->setFlashdata('errors', 'Barang tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function addStock()
    {
        $body = $this->request->getPost();
        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);


        if ($body && isset($body['goods_name'])) {
            if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
                $body = null;
            }

            if (isset($body['goods_name']) && isset($decoded->username) && isset($body['goods_qty'])) {
                $goods = $this->Goods->getDataByName($body['goods_name']);
                if (!$goods) {
                    $goods = $this->Goods->getOneData($body['goods_name']);
                }
                $users = $this->Users->getUser($decoded->username);
                $rules = $this->GoodsHistory->getValidationRules();
                $message = $this->GoodsHistory->getValidationMessages();

                $data = [];
                if (isset($goods['id']) && isset($users['id']) && (isset($body['goods_qty']) && (int)$body['goods_qty'] > 0)) {
                    $data = [
                        'goods_id' => $goods['id'],
                        'user_id' => $users['id'],
                        'qty' => $body['goods_qty']
                    ];
                }

                $goodsValue = 0;
                if ($body['goods_qty'] >= 1 && isset($goods['goods_stock_warehouse'])) {
                    $goodsValue = $goods['goods_stock_warehouse'] + (int)$body['goods_qty'];
                }

                if ($this->validateData($data, $rules, $message)) {
                    if ($goodsValue != 0 && $this->Goods->update($data['goods_id'], ['goods_stock_warehouse' => $goodsValue]) && $this->GoodsHistory->insert($data)) {
                        session()->setFlashdata('success', 'Penambahan stok barang berhasil.');
                        return redirect()->back();
                    } else {
                        session()->setFlashdata('errors', 'Penambahan stok barang gagal!');
                        return redirect()->withInput()->back();
                    }
                } else {
                    session()->setFlashdata('errors', 'Penambahan stok barang gagal!');
                    return redirect()->withInput()->back();
                }
            } else {
                session()->setFlashdata('errors', 'Data barang tidak ditemukan');
                return redirect()->back();
            }
        }
        $goods = $this->Goods->findAll();
        $setGoods = [];
        foreach ($goods as $list) {
            $users = $this->Users->getUserId($list['users_id']);
            $list['user_id'] = $users['username'];
            unset($list['id']);
            if ($list['goods_stock_warehouse'] < $list['goods_min_stock']) {
                $setGoods = array_merge($setGoods, [$list]);
            }
        }

        $data = [
            'title' => 'Tambah Stok',
            'goods' => $setGoods
        ];
        return view('/pages/goods/goods_stock', $data);
    }
}
