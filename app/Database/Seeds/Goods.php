<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
class Goods extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50  ; $i++) { 
         $data = [
            'goods_code' => 'GS'.$i,
            'goods_name' => 'Semen '.$i. ' Roda',
            'goods_price' => $i,
            'goods_prev_price' => $i,
            'goods_stock_shop' => $i,
            'goods_stock_warehouse' => $i,
            'goods_min_stock' => $i,
            'users_id' => 1,
            'created_at' => '2023-11-03 20:34:03',
            'updated_at' => '2023-11-03 20:34:03'
         ];
         $this->db->table('goods')->insert($data);
        }
    }
}
