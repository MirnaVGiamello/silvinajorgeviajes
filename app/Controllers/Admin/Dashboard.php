<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromocionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new PromocionModel();

        return view('admin/dashboard/index', [
            'title'            => 'Inicio',
            'config'           => $this->config,
            'totalPromociones' => $model->countAll(),
            'activas'          => $model->where('activa', 1)->countAllResults(),
        ]);
    }
}
