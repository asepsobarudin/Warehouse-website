<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Goods extends Seeder
{
    public function run()
    {

        $account = [
            [
                'username' => 'admin',
                'password' => '$2y$10$/ZdMSGioLVKnMUkZVUe9suuWMA5N2Y2N7Za0pdk3iHicB3e0ypRSC',
                'role' => 'admin',
                "online_status" => null,
                'created_at' => '2023-11-03 20:34:03',
                'updated_at' => '2023-11-03 20:34:03'
            ],
            [
                'username' => 'gudang',
                'password' => '$2y$10$/ZdMSGioLVKnMUkZVUe9suuWMA5N2Y2N7Za0pdk3iHicB3e0ypRSC',
                'role' => 'gudang',
                "online_status" => null,
                'created_at' => '2023-11-03 20:34:03',
                'updated_at' => '2023-11-03 20:34:03'
            ],
        ];

        foreach ($account as $ac) {
            $this->db->table('users')->insert($ac);
        }

        function randomDate($startDate, $endDate)
        {
            $startTimestamp = strtotime($startDate);
            $endTimestamp = strtotime($endDate);
            $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
            return date("Y-m-d H:i:s", $randomTimestamp);
        }

        for ($i = 1; $i <= 500; $i++) {
            $data = [
                'goods_code' => 'GS' . uniqid(),
                'goods_name' => 'Semen Gresik ' . $i . 'kg Area Surabaya - Tanpa Bongkar ' . $i,
                'goods_price' => rand(50000, 70000),
                'goods_prev_price' => rand(45000, 60000),
                'goods_stock_warehouse' => rand(500, 1000),
                'goods_min_stock' => rand(50, 200),
                'users_id' => '1',
                'created_at' => randomDate('2023-12-01 00:00:00', '2023-12-04 23:59:59'),
                'updated_at' => randomDate('2023-12-04 00:00:00', '2023-12-04 23:59:59'),
                'deleted_at' => null,
            ];
            $this->db->table('goods')->insert($data);
        }
    }
}
