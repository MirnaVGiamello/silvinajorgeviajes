<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    public function index()
    {
        return view('admin/usuarios/index', [
            'title'    => 'Usuarios',
            'config'   => $this->config,
            'usuarios' => (new UsuarioModel())->orderBy('nombre')->findAll(),
        ]);
    }

    public function nuevo()
    {
        return view('admin/usuarios/form', [
            'title'   => 'Nuevo usuario',
            'config'  => $this->config,
            'usuario' => null,
        ]);
    }

    public function editar(int $id)
    {
        $usuario = (new UsuarioModel())->find($id);
        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('admin/usuarios/form', [
            'title'   => 'Editar usuario',
            'config'  => $this->config,
            'usuario' => $usuario,
        ]);
    }

    public function guardar()
    {
        $model = new UsuarioModel();

        $model->insert([
            'usuario' => $this->request->getPost('usuario'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nombre'  => $this->request->getPost('nombre'),
            'perfil'  => $this->request->getPost('perfil'),
            'activo'  => $this->request->getPost('activo') ? 1 : 0,
        ]);

        return redirect()->to('/admin/usuarios')->with('ok', 'Usuario creado correctamente.');
    }

    public function actualizar(int $id)
    {
        $model   = new UsuarioModel();
        $usuario = $model->find($id);
        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $datos = [
            'usuario' => $this->request->getPost('usuario'),
            'nombre'  => $this->request->getPost('nombre'),
            'perfil'  => $this->request->getPost('perfil'),
            'activo'  => $this->request->getPost('activo') ? 1 : 0,
        ];

        if ($this->request->getPost('password')) {
            $datos['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $datos);

        return redirect()->to('/admin/usuarios')->with('ok', 'Usuario actualizado correctamente.');
    }

    public function eliminar(int $id)
    {
        if ($id === (int) session()->get('usuario_id')) {
            return redirect()->to('/admin/usuarios')->with('error', 'No podés eliminar tu propio usuario.');
        }

        $model = new UsuarioModel();
        if (!$model->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $model->update($id, ['activo' => 0]);

        return redirect()->to('/admin/usuarios')->with('ok', 'Usuario dado de baja.');
    }
}
