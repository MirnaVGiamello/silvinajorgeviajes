<?php $content = ob_start() ?: ''; ?>

<div class="d-flex justify-content-end mb-3">
  <a href="<?= site_url('admin/promociones/nueva') ?>" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg me-1"></i>Nueva promoción</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0 small align-middle">
      <thead class="table-light">
        <tr><th>ID</th><th>Título</th><th>Destino</th><th>Categoría</th><th class="text-end">Precio</th><th class="text-center">Estado</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($promociones as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= esc($p['titulo']) ?></td>
          <td><?= esc($p['destino']) ?></td>
          <td><?= esc($p['categoria']) ?></td>
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
        <tr><td colspan="7" class="text-center text-muted py-4">Todavía no hay promociones cargadas.</td></tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted small"><?= count($promociones) ?> promociones</div>
</div>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => 'Promociones', 'content' => $content]); ?>
