<?php

namespace App\Controllers;

use App\Models\PromocionModel;

class Home extends BaseController
{
    public function index()
    {
        $promociones = (new PromocionModel())->destacadas(3);

        return view('home/index', [
            'title'       => 'Inicio',
            'config'      => $this->config,
            'promociones' => $promociones,
        ]);
    }
}
