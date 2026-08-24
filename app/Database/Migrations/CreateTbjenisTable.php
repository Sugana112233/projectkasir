<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbjenisTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'nama_jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_jenis');
        $this->forge->addUniqueKey('nama_jenis');
        $this->forge->createTable('tbjenis');
    }

    public function down()
    {
        $this->forge->dropTable('tbjenis');
    }
}