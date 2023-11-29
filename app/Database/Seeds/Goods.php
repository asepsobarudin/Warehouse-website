<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Goods extends Seeder
{
    public function run()
    {

        $account = [
            'username' => 'admin',
            'password' => '$2y$10$/ZdMSGioLVKnMUkZVUe9suuWMA5N2Y2N7Za0pdk3iHicB3e0ypRSC',
            'role' => 'admin',
            'status' => null,
            'created_at' => '2023-11-03 20:34:03',
            'updated_at' => '2023-11-03 20:34:03'
        ];
        $this->db->table('users')->insert($account);
    }
}
