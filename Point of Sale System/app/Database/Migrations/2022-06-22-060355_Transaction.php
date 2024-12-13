<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaction extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'customer' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'total_amount' => [
                'type'       => 'FLOAT',
                'constraint' => '12,2',
                'default' => 0,
            ],
            'tendered' => [
                'type'       => 'FLOAT',
                'constraint' => '12,2',
                'default' => 0,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');

    }
}
