<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\PromocionImagenModel;
use App\Models\PromocionModel;

class Promociones extends BaseController
{
    private const TAMANO_MAXIMO_FOTO = 5 * 1024 * 1024; // 5 MB

    /** @var string[] mensajes de fotos rechazadas, para avisar al usuario tras guardar */
    private array $avisos = [];

    private function directorioUploads(int $id): string
    {
        return FCPATH . 'uploads/promociones/' . $id;
    }

    private function guardarImagen($archivo, int $promocionId, string $nombreBase): ?string
    {
        if (!$archivo || !$archivo->isValid() || $archivo->hasMoved()) {
            return null;
        }

        if ($archivo->getMimeType() !== 'image/jpeg') {
            $this->avisos[] = $archivo->getClientName() . ': solo se aceptan fotos en formato JPG.';

            return null;
        }

        if ($archivo->getSize() > self::TAMANO_MAXIMO_FOTO) {
            $this->avisos[] = $archivo->getClientName() . ': la foto pesa demasiado (máximo 5 MB).';

            return null;
        }

        $dir = $this->directorioUploads($promocionId);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $nombre = $nombreBase . '_' . uniqid() . '.' . $archivo->getExtension();
        $archivo->move($dir, $nombre);

        $this->optimizarImagen($dir . '/' . $nombre);

        return 'uploads/promociones/' . $promocionId . '/' . $nombre;
    }

    /**
     * Las fotos de celular/stock suelen pesar varios MB; sin esto, cada
     * apertura del formulario de edicion y cada guardado se hacen muy lentos.
     */
    private function optimizarImagen(string $ruta, int $anchoMaximo = 1600): void
    {
        $info = @getimagesize($ruta);
        if (!$info || $info[0] <= $anchoMaximo) {
            return;
        }

        try {
            service('image')
                ->withFile($ruta)
                ->resize($anchoMaximo, (int) round($info[1] * $anchoMaximo / $info[0]), true, 'width')
                ->save($ruta, 82);
        } catch (\Throwable $e) {
            log_message('error', 'No se pudo optimizar la imagen {ruta}: {msg}', ['ruta' => $ruta, 'msg' => $e->getMessage()]);
        }
    }

    private const COLUMNAS_ORDENABLES = ['id', 'orden', 'titulo', 'destino', 'precio', 'activa', 'fecha_desde'];

    public function index()
    {
        $model = new PromocionModel();

        $ordenPor  = $this->request->getGet('orden');
        $ordenPor  = in_array($ordenPor, self::COLUMNAS_ORDENABLES, true) ? $ordenPor : 'id';
        $direccion = strtolower((string) $this->request->getGet('dir')) === 'asc' ? 'ASC' : 'DESC';

        return view('admin/promociones/index', [
            'title'       => 'Promociones',
            'config'      => $this->config,
            'promociones' => $model->adjuntarCategorias($model->orderBy($ordenPor, $direccion)->findAll()),
            'ordenPor'    => $ordenPor,
            'direccion'   => $direccion,
        ]);
    }

    public function nueva()
    {
        return view('admin/promociones/form', [
            'title'            => 'Nueva promoción',
            'config'           => $this->config,
            'promocion'        => null,
            'imagenes'         => [],
            'categorias'       => (new CategoriaModel())->todas(),
            'categoriasElegidas' => [],
        ]);
    }

    public function editar(int $id)
    {
        $model     = new PromocionModel();
        $promocion = $model->find($id);
        if (!$promocion) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('admin/promociones/form', [
            'title'              => 'Editar promoción',
            'config'             => $this->config,
            'promocion'          => $promocion,
            'imagenes'           => (new PromocionImagenModel())->dePromocion($id),
            'categorias'         => (new CategoriaModel())->todas(),
            'categoriasElegidas' => $model->categoriaIdsDe($id),
        ]);
    }

    private function datosFormulario(): array
    {
        $fechaHasta = $this->request->getPost('fecha_hasta') ?: null;
        $activa     = $this->request->getPost('activa') ? 1 : 0;

        if ($activa && $fechaHasta && $fechaHasta < date('Y-m-d')) {
            $activa = 0;
            $this->avisos[] = 'La vigencia de esta promoción venció el ' . date('d/m/Y', strtotime($fechaHasta)) . ', así que se guardó como "Oculta". Actualizá "Vigencia hasta" a una fecha futura para poder activarla.';
        }

        return [
            'titulo'         => $this->request->getPost('titulo'),
            'destino'        => $this->request->getPost('destino'),
            'descripcion'    => $this->request->getPost('descripcion'),
            'precio'         => $this->request->getPost('precio') !== '' ? $this->request->getPost('precio') : null,
            'moneda'         => $this->request->getPost('moneda') ?: 'ARS',
            'fecha_desde'    => $this->request->getPost('fecha_desde') ?: null,
            'fecha_hasta'    => $fechaHasta,
            'destacado_foto' => $this->request->getPost('destacado_foto') ?: null,
            'destacado_html' => $this->request->getPost('destacado_html') ?: null,
            'activa'         => $activa,
            'orden'          => (int) ($this->request->getPost('orden') ?: 0),
        ];
    }

    public function guardar()
    {
        $model = new PromocionModel();
        $datos = $this->datosFormulario();
        $datos['usuario_id'] = session()->get('usuario_id');

        $id = $model->insert($datos);
        $model->sincronizarCategorias($id, $this->request->getPost('categorias') ?? []);

        $portada = $this->guardarImagen($this->request->getFile('imagen_portada'), $id, 'portada');
        if ($portada) {
            $model->update($id, ['imagen_portada' => $portada]);
        }

        $this->guardarGaleria($id);

        return redirect()->to('/admin/promociones')
            ->with('ok', 'Promoción creada correctamente.')
            ->with('error', $this->avisos ? implode(' ', $this->avisos) : null);
    }

    public function actualizar(int $id)
    {
        $model     = new PromocionModel();
        $promocion = $model->find($id);
        if (!$promocion) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $datos = $this->datosFormulario();

        $portada = $this->guardarImagen($this->request->getFile('imagen_portada'), $id, 'portada');
        if ($portada) {
            $datos['imagen_portada'] = $portada;
        }

        $model->update($id, $datos);
        $model->sincronizarCategorias($id, $this->request->getPost('categorias') ?? []);
        $this->guardarGaleria($id);

        return redirect()->to('/admin/promociones')
            ->with('ok', 'Promoción actualizada correctamente.')
            ->with('error', $this->avisos ? implode(' ', $this->avisos) : null);
    }

    private function guardarGaleria(int $promocionId): void
    {
        $archivos = $this->request->getFileMultiple('galeria');
        if (!$archivos) {
            return;
        }

        $imagenModel = new PromocionImagenModel();
        foreach ($archivos as $archivo) {
            $ruta = $this->guardarImagen($archivo, $promocionId, 'foto');
            if ($ruta) {
                $imagenModel->insert([
                    'promocion_id' => $promocionId,
                    'ruta'         => $ruta,
                    'orden'        => 0,
                    'created_at'   => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function eliminarImagen(int $id)
    {
        $imagenModel = new PromocionImagenModel();
        $imagen      = $imagenModel->find($id);

        if ($imagen) {
            $ruta = FCPATH . $imagen['ruta'];
            if (is_file($ruta)) {
                unlink($ruta);
            }
            $imagenModel->delete($id);
        }

        return redirect()->back()->with('ok', 'Foto eliminada.');
    }

    public function eliminar(int $id)
    {
        $model = new PromocionModel();
        if (!$model->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $model->delete($id);

        $dir = $this->directorioUploads($id);
        if (is_dir($dir)) {
            array_map('unlink', glob($dir . '/*'));
            rmdir($dir);
        }

        return redirect()->to('/admin/promociones')->with('ok', 'Promoción eliminada.');
    }
}
