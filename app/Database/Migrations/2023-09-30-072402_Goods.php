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
            'id_category' => [
                'type' => 'INT',
                'null' => false
            ],
            'code_goods' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'name_goods' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'price' => [
                'type' => 'INT',
                'null' => false
            ],
            'previous_price' => [
                'type' => 'INT',
                'null' => true
            ],
            'store_stok' => [
                'type' => 'INT',
                'null' => true
            ],
            'warehouse_stok' => [
                'type' => 'INT',
                'null' => true
            ],
            'minimum_stok' => [
                'type' => 'INT',
                'null' => true
            ],
            'images' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->createTable('goods', true);
    }

    public function down()
    {
        $this->forge->dropTable('goods');
    }
}
