<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Goods extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'goods_category' => [
                'type' => 'INT',
                'null' => false
            ],
            'goods_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'goods_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'goods_description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'goods_price' => [
                'type' => 'INT',
                'null' => false
            ],
            'goods_prev_price' => [
                'type' => 'INT',
                'null' => true
            ],
            'goods_stok' => [
                'type' => 'INT',
                'null' => true
            ],
            'goods_min_stok' => [
                'type' => 'INT',
                'null' => true
            ],
            'goods_images' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'goods_users' => [
                'type' => 'INT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('goods');
    }

    public function down()
    {
        $this->forge->dropTable('goods');
    }
}
