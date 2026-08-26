<?php
namespace App\Models;
use CodeIgniter\Model;

class PromocionModel extends Model
{
    protected $table         = 'promociones';
    protected $allowedFields = [
        'titulo', 'destino', 'categoria', 'descripcion', 'precio', 'moneda',
        'fecha_desde', 'fecha_hasta', 'imagen_portada', 'destacado_foto', 'destacado_html', 'activa', 'orden', 'usuario_id',
    ];
    protected $useTimestamps = true;

    /**
     * Orden con las de "orden" sin definir (0) al final: primero las que
     * tienen un orden explicito (1..N, de menor a mayor), despues el resto.
     */
    private function ordenarPorPrioridad($builder)
    {
        return $builder->orderBy('orden = 0', 'ASC', false)->orderBy('orden', 'ASC')->orderBy('created_at', 'DESC');
    }

    public function publicas(array $filtros = []): array
    {
        $builder = $this->where('activa', 1);

        if (!empty($filtros['destino']))   $builder->like('destino', $filtros['destino']);
        if (!empty($filtros['categoria'])) $builder->where('categoria', $filtros['categoria']);

        return $this->ordenarPorPrioridad($builder)->findAll();
    }

    public function destacadas(int $cantidad = 3): array
    {
        return $this->ordenarPorPrioridad($this->where('activa', 1))->findAll($cantidad);
    }

    public function fotosHero(int $ordenDesde = 1, int $ordenHasta = 5): array
    {
        return $this->select('imagen_portada, titulo')
            ->where('activa', 1)
            ->where('orden >=', $ordenDesde)
            ->where('orden <=', $ordenHasta)
            ->where('imagen_portada !=', '')
            ->orderBy('orden', 'ASC')
            ->findAll();
    }

    public function categorias(): array
    {
        return array_column(
            $this->select('categoria')->distinct()->where('categoria !=', '')->orderBy('categoria')->findAll(),
            'categoria'
        );
    }
}
