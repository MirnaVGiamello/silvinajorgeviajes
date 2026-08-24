<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateConfiguracion extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'nombre_agencia'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'eslogan'         => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'texto_nosotros'  => ['type' => 'TEXT', 'null' => true],
            'telefono'        => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'whatsapp'        => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'email'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'direccion'       => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'instagram'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'facebook'        => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('configuracion');
    }

    public function down()
    {
        $this->forge->dropTable('configuracion');
    }
}
