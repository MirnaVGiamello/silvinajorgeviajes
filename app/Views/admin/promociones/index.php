<?php
$content = ob_start() ?: '';

$urlOrden = function (string $columna) use ($ordenPor, $direccion) {
    $nuevaDireccion = ($ordenPor === $columna && $direccion === 'ASC') ? 'desc' : 'asc';

    return site_url('admin/promociones') . '?orden=' . $columna . '&dir=' . $nuevaDireccion;
};
$flechaOrden = function (string $columna) use ($ordenPor, $direccion) {
    if ($ordenPor !== $columna) {
        return '';
    }

    return $direccion === 'ASC' ? ' <i class="bi bi-caret-up-fill"></i>' : ' <i class="bi bi-caret-down-fill"></i>';
};
$th = function (string $columna, string $etiqueta) use ($urlOrden, $flechaOrden) {
    return '<a href="' . $urlOrden($columna) . '" class="text-dark text-decoration-none">' . esc($etiqueta) . $flechaOrden($columna) . '</a>';
};
?>

<div class="d-flex justify-content-end mb-3">
  <a href="<?= site_url('admin/promociones/nueva') ?>" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg me-1"></i>Nueva promoción</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0 small align-middle">
      <thead class="table-light">
        <tr>
          <th><?= $th('id', 'ID') ?></th>
          <th class="text-center"><?= $th('orden', 'Orden') ?></th>
          <th><?= $th('titulo', 'Título') ?></th>
          <th><?= $th('destino', 'Destino') ?></th>
          <th>Categoría</th>
          <th><?= $th('fecha_desde', 'Vigencia') ?></th>
          <th class="text-end"><?= $th('precio', 'Precio') ?></th>
          <th class="text-center"><?= $th('activa', 'Estado') ?></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($promociones as $p):
          $vencida = !empty($p['fecha_hasta']) && strtotime($p['fecha_hasta']) < strtotime('today');
        ?>
        <tr class="<?= $vencida ? 'table-danger' : '' ?>">
          <td><?= $p['id'] ?></td>
          <td class="text-center"><?= (int) $p['orden'] ?></td>
          <td><?= esc($p['titulo']) ?></td>
          <td><?= esc($p['destino']) ?></td>
          <td><?= esc(implode(', ', array_column($p['categorias'], 'nombre'))) ?></td>
          <td class="text-nowrap">
            <?php if (!empty($p['fecha_desde']) || !empty($p['fecha_hasta'])): ?>
              <?= !empty($p['fecha_desde']) ? esc(date('d/m/Y', strtotime($p['fecha_desde']))) : '?' ?>
              <?php if (!empty($p['fecha_hasta'])): ?> al <?= esc(date('d/m/Y', strtotime($p['fecha_hasta']))) ?><?php endif ?>
            <?php else: ?>-<?php endif ?>
          </td>
          <td class="text-end"><?= $p['precio'] ? esc($p['moneda']) . ' ' . number_format($p['precio'], 0) : '-' ?></td>
          <td class="text-center">
            <?= $p['activa'] ? '<span class="badge bg-success">Activa</span>' : '<span class="badge bg-secondary">Oculta</span>' ?>
          </td>
          <td class="text-end">
            <a href="<?= site_url('promociones/' . $p['id']) ?>" class="btn btn-sm btn-outline-secondary py-0 px-2" target="_blank" title="Ver en el sitio"><i class="bi bi-eye"></i></a>
            <a href="<?= site_url('admin/promociones/editar/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary py-0 px-2"><i class="bi bi-pencil"></i></a>
            <form method="post" action="<?= site_url('admin/promociones/eliminar/' . $p['id']) ?>" class="d-inline"
                  onsubmit="return confirm('¿Eliminar esta promoción? Esta acción no se puede deshacer.')">
              <?= csrf_field() ?>
              <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach ?>
        <?php if (empty($promociones)): ?>
        <tr><td colspan="9" class="text-center text-muted py-4">Todavía no hay promociones cargadas.</td></tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted small"><?= count($promociones) ?> promociones</div>
</div>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => 'Promociones', 'content' => $content]); ?>
