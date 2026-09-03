<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddFotoNosotrosToConfiguracion extends Migration
{
    public function up()
    {
        $this->forge->addColumn('configuracion', [
            'foto_nosotros' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('configuracion', 'foto_nosotros');
    }
}
