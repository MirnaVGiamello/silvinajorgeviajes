<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreatePromocionImagenes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'promocion_id' => ['type' => 'INT'],
            'ruta'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'orden'        => ['type' => 'INT', 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('promocion_id', 'promociones', 'id', '', 'CASCADE');
        $this->forge->createTable('promocion_imagenes');
    }

    public function down()
    {
        $this->forge->dropTable('promocion_imagenes');
    }
}
