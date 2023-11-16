<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GoodsRestocks extends Migration
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
            'goods_id' => [
                'type' => 'INT',
                'null' => false
            ],
            'restock_id' => [
                'type' => 'INT',
                'null' => false
            ],
            'qty' => [
                'type' => 'INT',
                'null' => false
            ],
            'qty_response' => [
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
        $this->forge->createTable('goods_restocks');
    }

    public function down()
    {
        $this->forge->dropTable('goods_restocks');
    }
}
