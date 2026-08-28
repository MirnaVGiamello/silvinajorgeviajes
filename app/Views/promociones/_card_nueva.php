<?php /** @var array $p variable de la promoción, provista por la vista que incluye este partial */ ?>
<a href="<?= site_url('promociones/' . $p['id']) ?>" class="n-card">
  <div class="n-card-img">
    <?php if (!empty($p['imagen_portada'])): ?>
      <img src="<?= base_url($p['imagen_portada']) ?>" alt="<?= esc($p['titulo']) ?>">
    <?php else: ?>
      <i class="bi bi-airplane"></i>
    <?php endif ?>
    <?php if (!empty($p['destacado_html'])): ?>
      <div class="n-card-destacado-html"><?= $p['destacado_html'] ?></div>
    <?php elseif (!empty($p['destacado_foto'])): ?>
      <span class="n-card-tag"><?= esc(strtoupper($p['destacado_foto'])) ?></span>
    <?php endif ?>
  </div>
  <div class="n-stub">
    <div class="n-stub-destino"><?= esc($p['destino']) ?></div>
    <h3><?= esc($p['titulo']) ?></h3>
    <div class="n-stub-foot">
      <?php if ($p['precio']): ?>
        <div>
          <span class="n-price-label">Precio final</span>
          <span class="n-price"><?= esc($p['moneda']) ?> <?= number_format($p['precio'], 0) ?></span>
        </div>
      <?php else: ?><span></span><?php endif ?>
      <span class="n-cat"><?= esc(strtoupper($p['categoria'])) ?></span>
    </div>
  </div>
</a>
