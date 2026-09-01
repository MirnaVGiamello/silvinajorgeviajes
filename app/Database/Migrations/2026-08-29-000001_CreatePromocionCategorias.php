<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreatePromocionCategorias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'promocion_id' => ['type' => 'INT'],
            'categoria_id' => ['type' => 'INT'],
        ]);
        $this->forge->addPrimaryKey(['promocion_id', 'categoria_id']);
        $this->forge->addForeignKey('promocion_id', 'promociones', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('categoria_id', 'categorias', 'id', '', 'CASCADE');
        $this->forge->createTable('promocion_categorias');
    }

    public function down()
    {
        $this->forge->dropTable('promocion_categorias');
    }
}
