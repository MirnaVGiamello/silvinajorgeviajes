<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddTemaHomeToConfiguracion extends Migration
{
    public function up()
    {
        $this->forge->addColumn('configuracion', [
            'tema_home' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'actual'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('configuracion', 'tema_home');
    }
}
