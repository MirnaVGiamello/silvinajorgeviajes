<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\PromocionImagenModel;
use App\Models\PromocionModel;

class Promociones extends BaseController
{
    public function index()
    {
        $model   = new PromocionModel();
        $filtros = [
            'destino'      => $this->request->getGet('destino'),
            'categoria_id' => $this->request->getGet('categoria_id'),
        ];

        $vista = ($this->config['tema_home'] ?? 'actual') === 'nueva' ? 'promociones/index_nueva' : 'promociones/index';

        return view($vista, [
            'title'       => 'Promociones',
            'config'      => $this->config,
            'promociones' => $model->publicas($filtros),
            'categorias'  => (new CategoriaModel())->todasConConteo(),
            'filtros'     => $filtros,
        ]);
    }

    public function ver(int $id)
    {
        $model     = new PromocionModel();
        $promocion = $model->where('activa', 1)->find($id);

        if (!$promocion) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $promocion = $model->adjuntarCategorias([$promocion])[0];
        $imagenes  = (new PromocionImagenModel())->dePromocion($id);
        $vista     = ($this->config['tema_home'] ?? 'actual') === 'nueva' ? 'promociones/detalle_nueva' : 'promociones/detalle';

        return view($vista, [
            'title'     => $promocion['titulo'],
            'config'    => $this->config,
            'promocion' => $promocion,
            'imagenes'  => $imagenes,
        ]);
    }
}
