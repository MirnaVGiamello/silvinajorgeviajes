<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Categorias extends BaseController
{
    public function index()
    {
        return view('admin/categorias/index', [
            'title'      => 'Categorías',
            'config'     => $this->config,
            'categorias' => (new CategoriaModel())->todas(),
        ]);
    }

    public function guardar()
    {
        $nombre = trim((string) $this->request->getPost('nombre'));
        if ($nombre === '') {
            return redirect()->to('/admin/categorias')->with('error', 'El nombre no puede estar vacío.');
        }

        $model = new CategoriaModel();
        if ($model->where('nombre', $nombre)->first()) {
            return redirect()->to('/admin/categorias')->with('error', 'Esa categoría ya existe.');
        }

        $model->insert(['nombre' => $nombre, 'created_at' => date('Y-m-d H:i:s')]);

        return redirect()->to('/admin/categorias')->with('ok', 'Categoría creada correctamente.');
    }

    public function eliminar(int $id)
    {
        $model = new CategoriaModel();
        if (!$model->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $model->delete($id);

        return redirect()->to('/admin/categorias')->with('ok', 'Categoría eliminada. Se sacó de las promociones que la tenían.');
    }
}
