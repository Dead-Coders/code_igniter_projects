<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
            ],
            'title' => [
                'type'       => 'TEXT',
            ],
            'short_description' => [
                'type'       => 'TEXT',
            ],
            'content' => [
                'type'       => 'TEXT',
            ],
            'banner' => [
                'type'       => 'TEXT',
            ],
            'tags' => [
                'type'       => 'TEXT',
            ],
            'status' => [
                'type'       => 'TINYINT',
                'default'       => 0,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('category_id');
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('category_id','categories','id','CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('user_id','users','id','CASCADE', 'NO ACTION');
        $this->forge->createTable('posts');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
