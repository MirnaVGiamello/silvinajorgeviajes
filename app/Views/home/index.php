<?php
$content = ob_start() ?: '';

$fotosSlideshow = array_merge(
    [base_url('assets/img/hero-bg.webp')],
    array_map(fn ($p) => base_url($p['imagen_portada']), $fotosHero ?? [])
);
$totalSlides = count($fotosSlideshow);
$segundosPorFoto = 15;
?>

<section class="hero">
  <div class="hero-slides">
    <?php foreach ($fotosSlideshow as $i => $url): ?>
      <div class="hero-slide" style="background-image:url('<?= esc($url, 'attr') ?>')<?php if ($totalSlides > 1): ?>;animation:heroFade-<?= $i ?> <?= $totalSlides * $segundosPorFoto ?>s infinite<?php endif ?>"></div>
    <?php endforeach ?>
  </div>
  <?php if ($totalSlides > 1): ?>
    <style>
      <?php foreach ($fotosSlideshow as $i => $url):
        $inicio       = $i / $totalSlides * 100;
        $entrada      = ($i + 0.12) / $totalSlides * 100;
        $salida       = ($i + 0.88) / $totalSlides * 100;
        $fin          = ($i + 1) / $totalSlides * 100;
      ?>
      @keyframes heroFade-<?= $i ?> {
        0%, <?= $inicio ?>% { opacity: 0; }
        <?= $entrada ?>% { opacity: 1; }
        <?= $salida ?>% { opacity: 1; }
        <?= $fin ?>%, 100% { opacity: 0; }
      }
      <?php endforeach ?>
    </style>
  <?php endif ?>
  <div class="container">
    <div class="row align-items-center g-4 g-lg-5">
      <div class="col-12 col-lg-4 text-center">
        <img src="<?= base_url('assets/img/logoSilvina.png') ?>" alt="Silvina Jorge" class="hero-logo">
      </div>
      <div class="col-12 col-lg-8 text-center text-lg-start">
        <div class="hero-eslogan"><?= esc($config['eslogan'] ?? 'Sueña · Explora · Descubre') ?></div>
        <h1><span class="hero-script">Silvina Jorge</span></h1>
        <p class="lead mx-auto mx-lg-0">Asesoramiento personalizado para tu próxima escapada, con las mejores promociones a destinos nacionales e internacionales.</p>
        <a href="<?= site_url('promociones') ?>" class="btn-brand">Ver promociones</a>
      </div>
    </div>
  </div>
</section>

<section class="container py-4 pb-5">
  <div class="section-titulo">
    <div class="kicker">Destacadas</div>
    <h2>Promociones del momento</h2>
    <div class="section-linea"></div>
  </div>

  <?php if (empty($promociones)): ?>
    <p class="text-center text-muted">Todavía no hay promociones publicadas. ¡Volvé pronto!</p>
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
    <div class="text-center mt-4">
      <a href="<?= site_url('promociones') ?>" class="btn-brand-outline">Ver todas las promociones</a>
    </div>
  <?php endif ?>
</section>

<section class="container py-5">
  <div class="row align-items-center g-4">
    <div class="col-12 col-md-6">
      <div class="kicker" style="font-family:'Playfair Display',serif;font-style:italic;color:var(--lilac)">Sobre mí</div>
      <h2 class="mt-1">Hago realidad tu próximo viaje</h2>
      <p class="text-muted"><?= esc(mb_strimwidth($config['texto_nosotros'] ?? '', 0, 220, '…')) ?></p>
      <a href="<?= site_url('nosotros') ?>" class="btn-brand-outline">Conoceme</a>
    </div>
    <div class="col-12 col-md-6">
      <div class="detalle-hero">
        <?php if (!empty($config['foto_nosotros'])): ?>
          <img src="<?= base_url($config['foto_nosotros']) ?>" alt="">
        <?php else: ?>
          <i class="bi bi-globe-americas"></i>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); echo view('layout', ['title' => 'Inicio', 'config' => $config, 'content' => $content]); ?>
