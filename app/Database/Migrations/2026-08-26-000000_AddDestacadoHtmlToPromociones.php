<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddDestacadoHtmlToPromociones extends Migration
{
    public function up()
    {
        $this->forge->addColumn('promociones', [
            'destacado_html' => ['type' => 'TEXT', 'null' => true, 'after' => 'destacado_foto'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('promociones', 'destacado_html');
    }
}
