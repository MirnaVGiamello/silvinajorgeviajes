<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddOrdenToPromociones extends Migration
{
    public function up()
    {
        $this->forge->addColumn('promociones', [
            'orden' => ['type' => 'INT', 'default' => 0, 'after' => 'activa'],
        ]);
        $this->db->query('ALTER TABLE promociones ADD INDEX promociones_orden (orden)');
    }

    public function down()
    {
        $this->forge->dropColumn('promociones', 'orden');
    }
}
