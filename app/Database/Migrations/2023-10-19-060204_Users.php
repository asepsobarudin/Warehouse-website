<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'online_status' => [
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
        $this->forge->createTable('users');

        // Goods
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true
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
            'goods_price' => [
                'type' => 'BIGINT',
                'null' => false
            ],
            'goods_prev_price' => [
                'type' => 'BIGINT',
                'null' => true
            ],
            'goods_stock_warehouse' => [
                'type' => 'BIGINT',
                'null' => true
            ],
            'goods_min_stock' => [
                'type' => 'BIGINT',
                'null' => true
            ],
            'users_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('goods');

        // Restock
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'restock_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'status' => [
                'type' => 'INT',
                'null' => false
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true
            ],
            'res_user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('restocks');

        // Goods Restock
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'goods_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false
            ],
            'restock_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false
            ],
            'qty' => [
                'type' => 'BIGINT',
                'null' => false
            ],
            'check' => [
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

        // History Add Stock Goods
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'goods_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true
            ],
            'qty' => [
                'type' => 'BIGINT',
                'null' => false
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('goods_history');
    }

    public function down()
    {
        $this->forge->dropTable('goods_history');
        $this->forge->dropTable('goods_restocks');
        $this->forge->dropTable('restocks');
        $this->forge->dropTable('goods');
        $this->forge->dropTable('users');
    }
}
