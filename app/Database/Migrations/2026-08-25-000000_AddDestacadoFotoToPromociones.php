<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddDestacadoFotoToPromociones extends Migration
{
    public function up()
    {
        $this->forge->addColumn('promociones', [
            'destacado_foto' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'imagen_portada'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('promociones', 'destacado_foto');
    }
}
