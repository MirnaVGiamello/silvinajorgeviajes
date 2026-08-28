<?php

namespace App\Controllers;

use App\Models\PromocionModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new PromocionModel();
        $datos = [
            'title'       => 'Inicio',
            'config'      => $this->config,
            'promociones' => $model->destacadas(3),
            'fotosHero'   => $model->fotosHero(),
        ];

        $vista = ($this->config['tema_home'] ?? 'actual') === 'nueva' ? 'home/index_nueva' : 'home/index';

        return view($vista, $datos);
    }
}
