<?php

namespace App\Controllers;

use App\Models\PromocionModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new PromocionModel();

        return view('home/index', [
            'title'       => 'Inicio',
            'config'      => $this->config,
            'promociones' => $model->destacadas(3),
            'fotosHero'   => $model->fotosHero(),
        ]);
    }
}
