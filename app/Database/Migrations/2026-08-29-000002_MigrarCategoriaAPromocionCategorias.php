<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class MigrarCategoriaAPromocionCategorias extends Migration
{
    public function up()
    {
        $promociones = $this->db->table('promociones')
            ->select('id, categoria')
            ->where('categoria !=', '')
            ->get()->getResultArray();

        foreach ($promociones as $p) {
            $nombre = trim($p['categoria']);
            if ($nombre === '') {
                continue;
            }

            $categoria = $this->db->table('categorias')->where('nombre', $nombre)->get()->getRowArray();
            if (!$categoria) {
                $this->db->table('categorias')->insert(['nombre' => $nombre, 'created_at' => date('Y-m-d H:i:s')]);
                $categoriaId = $this->db->insertID();
            } else {
                $categoriaId = $categoria['id'];
            }

            $this->db->table('promocion_categorias')->insert([
                'promocion_id' => $p['id'],
                'categoria_id' => $categoriaId,
            ]);
        }

        $this->forge->dropColumn('promociones', 'categoria');
    }

    public function down()
    {
        $this->forge->addColumn('promociones', [
            'categoria' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => '', 'after' => 'destino'],
        ]);

        $vinculos = $this->db->table('promocion_categorias pc')
            ->select('pc.promocion_id, c.nombre')
            ->join('categorias c', 'c.id = pc.categoria_id')
            ->get()->getResultArray();

        foreach ($vinculos as $v) {
            $this->db->table('promociones')->where('id', $v['promocion_id'])->update(['categoria' => $v['nombre']]);
        }
    }
}
