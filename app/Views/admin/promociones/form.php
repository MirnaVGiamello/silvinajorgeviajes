<?php $content = ob_start() ?: ''; ?>

<form method="post" enctype="multipart/form-data"
      action="<?= $promocion ? site_url('admin/promociones/actualizar/' . $promocion['id']) : site_url('admin/promociones/guardar') ?>">
  <?= csrf_field() ?>

  <div class="card mb-3">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-12 col-md-8">
          <label class="form-label small mb-1">Título</label>
          <input type="text" name="titulo" class="form-control" required value="<?= esc($promocion['titulo'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small mb-1">Destino</label>
          <input type="text" name="destino" class="form-control" required placeholder="Ej: Brasil" value="<?= esc($promocion['destino'] ?? '') ?>">
        </div>

        <div class="col-12 col-md-4">
          <label class="form-label small mb-1">Categoría</label>
          <input type="text" name="categoria" class="form-control" placeholder="Ej: Playa, Aventura, Cultural" value="<?= esc($promocion['categoria'] ?? '') ?>">
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Precio</label>
          <input type="number" step="0.01" name="precio" class="form-control" value="<?= esc($promocion['precio'] ?? '') ?>">
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Moneda</label>
          <select name="moneda" class="form-select">
            <?php foreach (['ARS', 'USD'] as $m): ?>
              <option value="<?= $m ?>" <?= ($promocion['moneda'] ?? 'ARS') === $m ? 'selected' : '' ?>><?= $m ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Vigencia desde</label>
          <input type="date" name="fecha_desde" class="form-control" value="<?= esc($promocion['fecha_desde'] ?? '') ?>">
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Vigencia hasta</label>
          <input type="date" name="fecha_hasta" class="form-control" value="<?= esc($promocion['fecha_hasta'] ?? '') ?>">
        </div>

        <div class="col-12">
          <label class="form-label small mb-1">Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4"><?= esc($promocion['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="col-12">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="activa" id="activa" value="1" <?= (!$promocion || $promocion['activa']) ? 'checked' : '' ?>>
            <label class="form-check-label small" for="activa">Promoción activa (visible en el sitio)</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <label class="form-label small mb-1">Imagen de portada</label>
      <?php if (!empty($promocion['imagen_portada'])): ?>
        <div class="mb-2"><img src="<?= base_url($promocion['imagen_portada']) ?>" style="max-width:180px;border-radius:10px" alt="Portada actual"></div>
      <?php endif ?>
      <input type="file" name="imagen_portada" class="form-control" accept="image/*">
      <div class="form-text">Se muestra en las tarjetas de promoción y en el detalle. Dejá vacío para no cambiarla.</div>
    </div>
  </div>

  <?php if ($promocion): ?>
  <div class="card mb-3">
    <div class="card-body">
      <label class="form-label small mb-1">Galería de fotos</label>
      <?php if (!empty($imagenes)): ?>
        <div class="d-flex flex-wrap gap-2 mb-3">
          <?php foreach ($imagenes as $img): ?>
            <div class="position-relative">
              <img src="<?= base_url($img['ruta']) ?>" style="width:100px;height:100px;object-fit:cover;border-radius:10px" alt="Foto">
              <form method="post" action="<?= site_url('admin/promociones/imagen/eliminar/' . $img['id']) ?>"
                    onsubmit="return confirm('¿Eliminar esta foto?')" class="position-absolute top-0 end-0 m-1">
                <?= csrf_field() ?>
                <button class="btn btn-sm btn-danger py-0 px-1"><i class="bi bi-x"></i></button>
              </form>
            </div>
          <?php endforeach ?>
        </div>
      <?php endif ?>
      <input type="file" name="galeria[]" class="form-control" accept="image/*" multiple>
      <div class="form-text">Podés seleccionar varias fotos a la vez para agregarlas a la galería.</div>
    </div>
  </div>
  <?php endif ?>

  <div class="d-flex gap-2">
    <button class="btn btn-brand"><i class="bi bi-check-lg me-1"></i>Guardar</button>
    <a href="<?= site_url('admin/promociones') ?>" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => $promocion ? 'Editar promoción' : 'Nueva promoción', 'content' => $content]); ?>
