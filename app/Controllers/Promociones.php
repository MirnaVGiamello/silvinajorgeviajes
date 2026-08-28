<?php

namespace App\Controllers;

use App\Models\PromocionImagenModel;
use App\Models\PromocionModel;

class Promociones extends BaseController
{
    public function index()
    {
        $model   = new PromocionModel();
        $filtros = [
            'destino'   => $this->request->getGet('destino'),
            'categoria' => $this->request->getGet('categoria'),
        ];

        $vista = ($this->config['tema_home'] ?? 'actual') === 'nueva' ? 'promociones/index_nueva' : 'promociones/index';

        return view($vista, [
            'title'       => 'Promociones',
            'config'      => $this->config,
            'promociones' => $model->publicas($filtros),
            'categorias'  => $model->categorias(),
            'filtros'     => $filtros,
        ]);
    }

    public function ver(int $id)
    {
        $promocion = (new PromocionModel())->where('activa', 1)->find($id);

        if (!$promocion) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $imagenes = (new PromocionImagenModel())->dePromocion($id);
        $vista    = ($this->config['tema_home'] ?? 'actual') === 'nueva' ? 'promociones/detalle_nueva' : 'promociones/detalle';

        return view($vista, [
            'title'     => $promocion['titulo'],
            'config'    => $this->config,
            'promocion' => $promocion,
            'imagenes'  => $imagenes,
        ]);
    }
}
