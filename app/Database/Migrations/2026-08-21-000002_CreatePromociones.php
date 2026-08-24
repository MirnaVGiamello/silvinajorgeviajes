<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreatePromociones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'titulo'         => ['type' => 'VARCHAR', 'constraint' => 150],
            'destino'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'categoria'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'descripcion'    => ['type' => 'TEXT'],
            'precio'         => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'moneda'         => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'ARS'],
            'fecha_desde'    => ['type' => 'DATE', 'null' => true],
            'fecha_hasta'    => ['type' => 'DATE', 'null' => true],
            'imagen_portada' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'activa'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'usuario_id'     => ['type' => 'INT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('activa');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', '', 'SET NULL');
        $this->forge->createTable('promociones');
    }

    public function down()
    {
        $this->forge->dropTable('promociones');
    }
}
