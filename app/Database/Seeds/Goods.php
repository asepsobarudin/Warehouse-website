<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Goods extends Seeder
{
    public function run()
    {
        $time = round(microtime(true) * 1000);
        for ($i = 1; $i < 30; $i++) { 
            $data = [
                'kode_goods' => 'B-0000001',
                'name_goods' => 'Tahu Bulat 25',
                'description' => 'null',
                'previous_price' => '0',
                'price' => '10000',
                'store_stok' => '10',
                'warehouse_stok' => '20',
                'minimum_stok' => '10',
                'images' => 'image1',
            ];
    
            $this->db->table('goods')->insert($data);
        }
    }
}
