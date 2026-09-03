<?php $content = ob_start() ?: ''; ?>

<section class="hero" style="padding:3.5rem 0">
  <div class="container">
    <div class="hero-eslogan">Sobre mí</div>
    <h1>Quién soy</h1>
  </div>
</section>

<section class="container py-4 pb-5">
  <div class="row g-4 align-items-center">
    <div class="col-12 col-lg-6">
      <div class="detalle-hero">
        <?php if (!empty($config['foto_nosotros'])): ?>
          <img src="<?= base_url($config['foto_nosotros']) ?>" alt="">
        <?php else: ?>
          <i class="bi bi-suitcase-lg"></i>
        <?php endif ?>
      </div>
    </div>
    <div class="col-12 col-lg-6">
      <p class="fs-5" style="white-space:pre-line"><?= esc($config['texto_nosotros'] ?? '') ?></p>
    </div>
  </div>

  <div class="row g-4 mt-5">
    <div class="col-12 col-md-4">
      <div class="info-card text-center">
        <i class="bi bi-heart-fill"></i>
        <h4>Atención personalizada</h4>
        <p class="text-muted small mb-0">Te acompañamos en cada paso, desde la idea hasta la valija.</p>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="info-card text-center">
        <i class="bi bi-globe2"></i>
        <h4>Destinos para todos los gustos</h4>
        <p class="text-muted small mb-0">Nacionales e internacionales, en grupo o a medida.</p>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="info-card text-center">
        <i class="bi bi-shield-check"></i>
        <h4>Confianza</h4>
        <p class="text-muted small mb-0">Años de experiencia ayudando a viajar tranquilo.</p>
      </div>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); echo view('layout', ['title' => 'Sobre mí', 'config' => $config, 'content' => $content]); ?>
