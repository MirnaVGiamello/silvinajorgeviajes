<?php
namespace App\Models;
use CodeIgniter\Model;

class PromocionModel extends Model
{
    protected $table         = 'promociones';
    protected $allowedFields = [
        'titulo', 'destino', 'descripcion', 'precio', 'moneda',
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

        if (!empty($filtros['destino'])) {
            $builder->like('destino', $filtros['destino']);
        }
        if (!empty($filtros['categoria_id'])) {
            $builder->whereIn('id', function ($sub) use ($filtros) {
                return $sub->select('promocion_id')->from('promocion_categorias')->where('categoria_id', $filtros['categoria_id']);
            });
        }

        return $this->adjuntarCategorias($this->ordenarPorPrioridad($builder)->findAll());
    }

    public function destacadas(int $cantidad = 3): array
    {
        return $this->adjuntarCategorias($this->ordenarPorPrioridad($this->where('activa', 1))->findAll($cantidad));
    }

    /**
     * Agrega la clave 'categorias' (array de nombres) a cada promocion,
     * con una sola consulta en vez de una por promocion.
     */
    public function adjuntarCategorias(array $promociones): array
    {
        if (!$promociones) {
            return $promociones;
        }

        $ids = array_column($promociones, 'id');
        $vinculos = $this->db->table('promocion_categorias pc')
            ->select('pc.promocion_id, c.id AS categoria_id, c.nombre')
            ->join('categorias c', 'c.id = pc.categoria_id')
            ->whereIn('pc.promocion_id', $ids)
            ->orderBy('c.nombre', 'ASC')
            ->get()->getResultArray();

        $porPromocion = [];
        foreach ($vinculos as $v) {
            $porPromocion[$v['promocion_id']][] = ['id' => $v['categoria_id'], 'nombre' => $v['nombre']];
        }

        foreach ($promociones as &$p) {
            $p['categorias'] = $porPromocion[$p['id']] ?? [];
        }

        return $promociones;
    }

    public function categoriaIdsDe(int $promocionId): array
    {
        return array_column(
            $this->db->table('promocion_categorias')->select('categoria_id')->where('promocion_id', $promocionId)->get()->getResultArray(),
            'categoria_id'
        );
    }

    public function sincronizarCategorias(int $promocionId, array $categoriaIds): void
    {
        $this->db->table('promocion_categorias')->where('promocion_id', $promocionId)->delete();

        $categoriaIds = array_unique(array_filter(array_map('intval', $categoriaIds)));
        if (!$categoriaIds) {
            return;
        }

        $filas = array_map(fn ($categoriaId) => ['promocion_id' => $promocionId, 'categoria_id' => $categoriaId], $categoriaIds);
        $this->db->table('promocion_categorias')->insertBatch($filas);
    }

    /**
     * Apaga (activa = 0) las promociones cuya vigencia ya paso. Se llama en
     * cada request (ver BaseController) para que no dependa de un cron.
     */
    public function desactivarVencidas(): void
    {
        $this->where('activa', 1)
            ->where('fecha_hasta IS NOT NULL', null, false)
            ->where('fecha_hasta <', date('Y-m-d'))
            ->set(['activa' => 0])
            ->update();
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
}
