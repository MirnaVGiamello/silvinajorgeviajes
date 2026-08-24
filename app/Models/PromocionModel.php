<?php
namespace App\Models;
use CodeIgniter\Model;

class PromocionModel extends Model
{
    protected $table         = 'promociones';
    protected $allowedFields = [
        'titulo', 'destino', 'categoria', 'descripcion', 'precio', 'moneda',
        'fecha_desde', 'fecha_hasta', 'imagen_portada', 'activa', 'orden', 'usuario_id',
    ];
    protected $useTimestamps = true;

    public function publicas(array $filtros = []): array
    {
        $builder = $this->where('activa', 1);

        if (!empty($filtros['destino']))   $builder->like('destino', $filtros['destino']);
        if (!empty($filtros['categoria'])) $builder->where('categoria', $filtros['categoria']);

        return $builder->orderBy('orden', 'ASC')->orderBy('created_at', 'DESC')->findAll();
    }

    public function destacadas(int $cantidad = 3): array
    {
        return $this->where('activa', 1)->orderBy('orden', 'ASC')->orderBy('created_at', 'DESC')->findAll($cantidad);
    }

    public function categorias(): array
    {
        return array_column(
            $this->select('categoria')->distinct()->where('categoria !=', '')->orderBy('categoria')->findAll(),
            'categoria'
        );
    }
}
