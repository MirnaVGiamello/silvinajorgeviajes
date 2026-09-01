<?php $content = ob_start() ?: ''; ?>

<div class="card mb-3" style="max-width:480px">
  <div class="card-body">
    <form method="post" action="<?= site_url('admin/categorias/guardar') ?>" class="d-flex gap-2">
      <?= csrf_field() ?>
      <input type="text" name="nombre" class="form-control" placeholder="Ej: Playa, Aventura, Cultural" maxlength="50" required>
      <button class="btn btn-brand text-nowrap"><i class="bi bi-plus-lg me-1"></i>Agregar</button>
    </form>
  </div>
</div>

<div class="card" style="max-width:480px">
  <div class="table-responsive">
    <table class="table table-hover mb-0 small align-middle">
      <thead class="table-light"><tr><th>Nombre</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($categorias as $c): ?>
        <tr>
          <td><?= esc($c['nombre']) ?></td>
          <td class="text-end">
            <form method="post" action="<?= site_url('admin/categorias/eliminar/' . $c['id']) ?>" class="d-inline"
                  onsubmit="return confirm('¿Eliminar la categoría «<?= esc(addslashes($c['nombre'])) ?>»? Se va a sacar de todas las promociones que la tengan.')">
              <?= csrf_field() ?>
              <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach ?>
        <?php if (empty($categorias)): ?>
        <tr><td colspan="2" class="text-center text-muted py-4">Todavía no hay categorías cargadas.</td></tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted small"><?= count($categorias) ?> categorías</div>
</div>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => 'Categorías', 'content' => $content]); ?>
