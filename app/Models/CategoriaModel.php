<?php
namespace App\Models;
use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table         = 'categorias';
    protected $allowedFields = ['nombre', 'created_at'];
    protected $useTimestamps = false;

    public function todas(): array
    {
        return $this->orderBy('nombre', 'ASC')->findAll();
    }

    /**
     * Categorias con la cantidad de promociones activas que las tienen,
     * para mostrar en el filtro publico (ej. "Playa (2)").
     */
    public function todasConConteo(): array
    {
        return $this->select('categorias.id, categorias.nombre, COUNT(p.id) AS cantidad')
            ->join('promocion_categorias pc', 'pc.categoria_id = categorias.id', 'left')
            ->join('promociones p', 'p.id = pc.promocion_id AND p.activa = 1', 'left')
            ->groupBy('categorias.id, categorias.nombre')
            ->orderBy('categorias.nombre', 'ASC')
            ->findAll();
    }
}
