<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;

class Configuracion extends BaseController
{
    public function index()
    {
        return view('admin/configuracion/index', [
            'title'  => 'Configuración del sitio',
            'config' => $this->config,
        ]);
    }

    public function guardar()
    {
        $model = new ConfiguracionModel();

        $model->update(1, [
            'nombre_agencia' => $this->request->getPost('nombre_agencia'),
            'eslogan'        => $this->request->getPost('eslogan'),
            'texto_nosotros' => $this->request->getPost('texto_nosotros'),
            'telefono'       => $this->request->getPost('telefono'),
            'whatsapp'       => $this->request->getPost('whatsapp'),
            'email'          => $this->request->getPost('email'),
            'direccion'      => $this->request->getPost('direccion'),
            'instagram'      => $this->request->getPost('instagram'),
            'facebook'       => $this->request->getPost('facebook'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/configuracion')->with('ok', 'Configuración actualizada.');
    }
}
