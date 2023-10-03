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
            'kode_goods' => [
                'type' => 'INT',
                'constraint' => 7
            ],
            'name_goods' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'previous_price' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'price' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false
            ],
            'store_stok' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'warehouse_stok' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'minimum_stok' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'images' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
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
 