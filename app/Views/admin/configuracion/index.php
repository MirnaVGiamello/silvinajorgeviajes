<?php $content = ob_start() ?: ''; ?>

<div class="card" style="max-width:640px">
  <div class="card-body">
    <form method="post" action="<?= site_url('admin/configuracion') ?>">
      <?= csrf_field() ?>

      <div class="row g-3">
        <div class="col-12 col-md-8">
          <label class="form-label small mb-1">Nombre de la agencia</label>
          <input type="text" name="nombre_agencia" class="form-control" required value="<?= esc($config['nombre_agencia'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small mb-1">Eslogan</label>
          <input type="text" name="eslogan" class="form-control" value="<?= esc($config['eslogan'] ?? '') ?>">
        </div>

        <div class="col-12">
          <label class="form-label small mb-1">Texto "Sobre mí"</label>
          <textarea name="texto_nosotros" class="form-control" rows="5"><?= esc($config['texto_nosotros'] ?? '') ?></textarea>
        </div>

        <div class="col-12"><hr class="my-1"></div>

        <div class="col-12">
          <label class="form-label small mb-1 d-block">Diseño del sitio</label>
          <div class="d-flex gap-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="tema_home" id="temaActual" value="actual" <?= ($config['tema_home'] ?? 'actual') === 'actual' ? 'checked' : '' ?>>
              <label class="form-check-label small" for="temaActual">Actual</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="tema_home" id="temaNueva" value="nueva" <?= ($config['tema_home'] ?? 'actual') === 'nueva' ? 'checked' : '' ?>>
              <label class="form-check-label small" for="temaNueva">Propuesta nueva</label>
            </div>
          </div>
          <div class="form-text">Cambia el diseño de Inicio, Promociones y la ficha de cada promoción. Nosotros, Contacto y el panel no se modifican.</div>
        </div>

        <div class="col-12"><hr class="my-1"></div>

        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">WhatsApp (con código de país, ej: 5491122334455)</label>
          <input type="text" name="whatsapp" class="form-control" value="<?= esc($config['whatsapp'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Teléfono</label>
          <input type="text" name="telefono" class="form-control" value="<?= esc($config['telefono'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Email</label>
          <input type="email" name="email" class="form-control" value="<?= esc($config['email'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Dirección</label>
          <input type="text" name="direccion" class="form-control" value="<?= esc($config['direccion'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Instagram (usuario, sin @)</label>
          <input type="text" name="instagram" class="form-control" value="<?= esc($config['instagram'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Facebook (usuario o página)</label>
          <input type="text" name="facebook" class="form-control" value="<?= esc($config['facebook'] ?? '') ?>">
        </div>
      </div>

      <div class="d-flex gap-2 mt-3">
        <button class="btn btn-brand"><i class="bi bi-check-lg me-1"></i>Guardar</button>
      </div>
    </form>
  </div>
</div>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => 'Configuración del sitio', 'content' => $content]); ?>
