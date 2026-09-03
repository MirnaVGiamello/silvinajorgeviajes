<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;

class Configuracion extends BaseController
{
    private const TAMANO_MAXIMO_FOTO = 5 * 1024 * 1024; // 5 MB

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

        $datos = [
            'nombre_agencia' => $this->request->getPost('nombre_agencia'),
            'eslogan'        => $this->request->getPost('eslogan'),
            'texto_nosotros' => $this->request->getPost('texto_nosotros'),
            'telefono'       => $this->request->getPost('telefono'),
            'whatsapp'       => $this->request->getPost('whatsapp'),
            'email'          => $this->request->getPost('email'),
            'direccion'      => $this->request->getPost('direccion'),
            'instagram'      => $this->request->getPost('instagram'),
            'facebook'       => $this->request->getPost('facebook'),
            'tema_home'      => $this->request->getPost('tema_home') === 'nueva' ? 'nueva' : 'actual',
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $error = null;
        $foto  = $this->guardarFotoNosotros($error);
        if ($foto) {
            $datos['foto_nosotros'] = $foto;
        }

        $model->update(1, $datos);

        return redirect()->to('/admin/configuracion')->with('ok', 'Configuración actualizada.')->with('error', $error);
    }

    private function guardarFotoNosotros(?string &$error): ?string
    {
        $archivo = $this->request->getFile('foto_nosotros');
        if (!$archivo || !$archivo->isValid() || $archivo->hasMoved()) {
            return null;
        }

        if ($archivo->getMimeType() !== 'image/jpeg') {
            $error = 'La foto de "Sobre mí" debe estar en formato JPG.';

            return null;
        }

        if ($archivo->getSize() > self::TAMANO_MAXIMO_FOTO) {
            $error = 'La foto de "Sobre mí" pesa demasiado (máximo 5 MB).';

            return null;
        }

        $dir = FCPATH . 'uploads/config';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $nombre = 'sobre-mi_' . uniqid() . '.' . $archivo->getExtension();
        $archivo->move($dir, $nombre);

        $ruta = $dir . '/' . $nombre;
        $info = @getimagesize($ruta);
        if ($info && $info[0] > 1600) {
            try {
                service('image')
                    ->withFile($ruta)
                    ->resize(1600, (int) round($info[1] * 1600 / $info[0]), true, 'width')
                    ->save($ruta, 82);
            } catch (\Throwable $e) {
                log_message('error', 'No se pudo optimizar la foto de Sobre mí: {msg}', ['msg' => $e->getMessage()]);
            }
        }

        return 'uploads/config/' . $nombre;
    }
}
