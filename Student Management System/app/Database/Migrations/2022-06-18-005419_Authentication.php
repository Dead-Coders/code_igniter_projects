<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Authentication extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'email' => [
                'type' => 'TEXT',
            ],
            'password' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'type' => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
            'recovery_question' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'recovery_answer' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'last_login datetime default NULL ',
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
        //
    }
}
