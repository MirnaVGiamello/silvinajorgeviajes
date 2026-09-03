<?php
$content = ob_start() ?: '';

$fotosSlideshow = array_merge(
    [base_url('assets/img/hero-bg.webp')],
    array_map(fn ($p) => base_url($p['imagen_portada']), $fotosHero ?? [])
);
$totalSlides = count($fotosSlideshow);
$segundosPorFoto = 15;
?>

<section class="n-hero">
  <div class="n-hero-slides">
    <?php foreach ($fotosSlideshow as $i => $url): ?>
      <div class="n-hero-slide" style="background-image:url('<?= esc($url, 'attr') ?>')<?php if ($totalSlides > 1): ?>;animation:nHeroFade-<?= $i ?> <?= $totalSlides * $segundosPorFoto ?>s infinite<?php endif ?>"></div>
    <?php endforeach ?>
  </div>
  <?php if ($totalSlides > 1): ?>
    <style>
      <?php foreach ($fotosSlideshow as $i => $url):
        $inicio  = $i / $totalSlides * 100;
        $entrada = ($i + 0.12) / $totalSlides * 100;
        $salida  = ($i + 0.88) / $totalSlides * 100;
        $fin     = ($i + 1) / $totalSlides * 100;
      ?>
      @keyframes nHeroFade-<?= $i ?> {
        0%, <?= $inicio ?>% { opacity: 0; }
        <?= $entrada ?>% { opacity: 1; }
        <?= $salida ?>% { opacity: 1; }
        <?= $fin ?>%, 100% { opacity: 0; }
      }
      <?php endforeach ?>
    </style>
  <?php endif ?>

  <div class="n-hero-inner">
    <div class="n-hero-text">
      <div class="n-eyebrow-row n-reveal">
        <svg class="n-flightpath" viewBox="0 0 64 16" fill="none" aria-hidden="true">
          <path class="n-dash" d="M2 13C14 13 18 3 32 3C46 3 48 8 62 8" stroke="#F0703F" stroke-width="2" stroke-linecap="round"/>
          <circle cx="62" cy="8" r="2.5" fill="#F0703F"/>
        </svg>
        <span class="n-eyebrow"><?= esc($config['eslogan'] ?? 'Sueña · Explora · Descubre') ?></span>
      </div>
      <h1 class="n-headline n-reveal n-reveal-2">Tu próximo<br>viaje <em>empieza</em><br>acá.</h1>
      <p class="n-lead n-reveal n-reveal-3">Asesoramiento personalizado para tu próxima escapada, con las mejores promociones a destinos nacionales e internacionales.</p>
      <div class="n-cta-row n-reveal n-reveal-3">
        <a class="n-btn" href="<?= site_url('promociones') ?>">Ver promociones →</a>
        <?php if (!empty($config['whatsapp'])): ?>
          <span class="n-cta-sub mono">Respuesta por WhatsApp en el día</span>
        <?php endif ?>
      </div>
    </div>
    <div class="n-hero-badge n-reveal n-reveal-2">
      <img src="<?= base_url('assets/img/logoSilvina.png') ?>" alt="<?= esc($config['nombre_agencia'] ?? 'Silvina Jorge Viajes') ?>">
    </div>
  </div>
</section>

<section class="n-promos">
  <div class="n-section-head">
    <h2>Promociones del momento</h2>
    <span class="mono">DESTACADAS / <?= str_pad((string) count($promociones), 2, '0', STR_PAD_LEFT) ?></span>
  </div>

  <?php if (empty($promociones)): ?>
    <p>Todavía no hay promociones publicadas. ¡Volvé pronto!</p>
  <?php else: ?>
    <div class="n-cards">
      <?php foreach ($promociones as $p): ?>
        <?php include APPPATH . 'Views/promociones/_card_nueva.php'; ?>
      <?php endforeach ?>
    </div>
    <div class="text-center mt-4">
      <a href="<?= site_url('promociones') ?>" class="n-btn-outline">Ver todas las promociones</a>
    </div>
  <?php endif ?>
</section>

<section class="n-sobre">
  <div>
    <span class="n-eyebrow mono">Sobre mí</span>
    <h2 class="mt-2">Hago realidad tu próximo viaje</h2>
    <p><?= esc(mb_strimwidth($config['texto_nosotros'] ?? '', 0, 220, '…')) ?></p>
    <a href="<?= site_url('nosotros') ?>" class="n-btn-outline">Conoceme</a>
  </div>
  <div class="n-sobre-photo">
    <img src="<?= base_url(!empty($config['foto_nosotros']) ? $config['foto_nosotros'] : 'assets/img/hero-bg.webp') ?>" alt="">
  </div>
</section>

<?php $content = ob_get_clean(); echo view('layout_nueva', ['title' => 'Inicio', 'config' => $config, 'content' => $content]); ?>
