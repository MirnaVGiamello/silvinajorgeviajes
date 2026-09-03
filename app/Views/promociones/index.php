<?php $content = ob_start() ?: ''; ?>

<section class="hero" style="padding:3.5rem 0">
  <div class="container">
    <div class="hero-eslogan">Sueña · Explora · Descubre</div>
    <h1>Nuestras promociones</h1>
  </div>
</section>

<section class="container py-4 pb-5">
  <div class="filtros-box mb-4">
    <form method="get" class="row g-2 align-items-end">
      <div class="col-12 col-md-5">
        <label class="form-label small mb-1">Destino</label>
        <input type="text" name="destino" class="form-control" placeholder="Ej: Brasil, Bariloche..." value="<?= esc($filtros['destino'] ?? '') ?>">
      </div>
      <div class="col-8 col-md-5">
        <label class="form-label small mb-1">Categoría</label>
        <select name="categoria_id" class="form-select">
          <option value="">Todas</option>
          <?php foreach ($categorias as $c): ?>
            <option value="<?= $c['id'] ?>" <?= (int) ($filtros['categoria_id'] ?? 0) === $c['id'] ? 'selected' : '' ?>><?= esc($c['nombre']) ?> (<?= (int) $c['cantidad'] ?>)</option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="col-4 col-md-2">
        <button class="btn-brand w-100"><i class="bi bi-search"></i></button>
      </div>
    </form>
  </div>

  <?php if (empty($promociones)): ?>
    <p class="text-center text-muted py-5">No encontramos promociones con esos filtros.</p>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($promociones as $p): ?>
      <div class="col-12 col-md-6 col-lg-4">
        <a href="<?= site_url('promociones/' . $p['id']) ?>" class="promo-card d-block">
          <div class="promo-img">
            <?php if (!empty($p['imagen_portada'])): ?>
              <img src="<?= base_url($p['imagen_portada']) ?>" alt="<?= esc($p['titulo']) ?>">
            <?php else: ?>
              <i class="bi bi-airplane"></i>
            <?php endif ?>
            <?php if (!empty($p['destacado_foto'])): ?>
              <span class="promo-precio-badge"><?= esc($p['destacado_foto']) ?></span>
            <?php endif ?>
            <?php if (!empty($p['destacado_html'])): ?>
              <div class="promo-destacado-html"><?= $p['destacado_html'] ?></div>
            <?php endif ?>
          </div>
          <div class="promo-body">
            <div class="promo-destino"><?= esc($p['destino']) ?></div>
            <h3><?= esc($p['titulo']) ?></h3>
            <p><?= esc(mb_strimwidth(strip_tags($p['descripcion']), 0, 110, '…')) ?></p>
            <div class="promo-footer">
              <?php if ($p['precio']): ?>
                <span class="promo-precio"><?= esc($p['moneda']) ?> <?= number_format($p['precio'], 0) ?></span>
              <?php else: ?><span></span><?php endif ?>
              <div class="d-flex flex-wrap gap-1 justify-content-end">
                <?php foreach ($p['categorias'] as $c): ?>
                  <span class="badge-categoria"><?= esc($c['nombre']) ?></span>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</section>

<?php $content = ob_get_clean(); echo view('layout', ['title' => 'Promociones', 'config' => $config, 'content' => $content]); ?>
