<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Goods extends Seeder
{
    public function run()
    {
        $time = round(microtime(true) * 1000);
        $data1 = [
            'category_name' => 'Semen'
        ];

        $this->db->table('category')->insert($data1);
        // for ($i = 1; $i <= 50; $i++) {
        //     $data = [
        //         'id_category' => 1,
        //         'code_goods' => 'B-00000'. $i,
        //         'name_goods' => 'Tahu Bulat 25',
        //         'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod repudiandae, ut esse odit adipisci cupiditate rerum vitae quia accusantium autem inventore, doloremque totam expedita neque provident nemo. Cum, porro itaque!',
        //         'previous_price' => 1000,
        //         'price' => 10000,
        //         'store_stok' => 10,
        //         'warehouse_stok' => 20,
        //         'minimum_stok' => 10,
        //         'images' => 'image1',
        //     ];

        //     $this->db->table('goods')->insert($data);
        // }
    }
}
