<?php $content = ob_start() ?: ''; ?>

<section class="n-pagehero">
  <div class="n-pagehero-bg" style="--hero-photo:url('<?= base_url('assets/img/hero-bg.webp') ?>')"></div>
  <div class="n-pagehero-inner">
    <span class="n-eyebrow mono">Sueña · Explora · Descubre</span>
    <h1 class="mt-2">Nuestras promociones</h1>
  </div>
</section>

<section class="n-promos n-promos-listado">
  <form method="get" class="n-filtros row g-3 align-items-end">
    <div class="col-12 col-md-5">
      <label for="fDestino">Destino</label>
      <input type="text" id="fDestino" name="destino" class="form-control" placeholder="Ej: Brasil, Bariloche..." value="<?= esc($filtros['destino'] ?? '') ?>">
    </div>
    <div class="col-8 col-md-5">
      <label for="fCategoria">Categoría</label>
      <select id="fCategoria" name="categoria" class="form-select">
        <option value="">Todas</option>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= esc($c) ?>" <?= ($filtros['categoria'] ?? '') === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="col-4 col-md-2">
      <button class="n-btn w-100 justify-content-center"><i class="bi bi-search"></i></button>
    </div>
  </form>

  <?php if (empty($promociones)): ?>
    <p>No encontramos promociones con esos filtros.</p>
  <?php else: ?>
    <div class="n-cards">
      <?php foreach ($promociones as $p): ?>
        <?php include APPPATH . 'Views/promociones/_card_nueva.php'; ?>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</section>

<?php $content = ob_get_clean(); echo view('layout_nueva', ['title' => 'Promociones', 'config' => $config, 'content' => $content]); ?>
