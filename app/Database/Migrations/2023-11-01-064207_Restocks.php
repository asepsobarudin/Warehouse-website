<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Restocks extends Migration
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
            'restock_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'request_user_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'response_user_id' => [
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
        $this->forge->createTable('restocks');
    }

    public function down()
    {
        $this->forge->dropTable('restocks');
    }
}
