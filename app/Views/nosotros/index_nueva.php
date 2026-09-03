<?php $content = ob_start() ?: ''; ?>

<section class="n-pagehero">
  <div class="n-pagehero-bg" style="--hero-photo:url('<?= base_url('assets/img/hero-bg.webp') ?>')"></div>
  <div class="n-pagehero-inner">
    <span class="n-eyebrow mono">Sobre mí</span>
    <h1 class="mt-2">Quién soy</h1>
  </div>
</section>

<section class="n-sobre">
  <div>
    <p style="white-space:pre-line;font-size:1.05rem"><?= esc($config['texto_nosotros'] ?? '') ?></p>
  </div>
  <div class="n-sobre-photo">
    <img src="<?= base_url(!empty($config['foto_nosotros']) ? $config['foto_nosotros'] : 'assets/img/hero-bg.webp') ?>" alt="">
  </div>
</section>

<div class="n-info-grid">
  <div class="n-info-card">
    <i class="bi bi-heart-fill"></i>
    <h4>Atención personalizada</h4>
    <p>Te acompaño en cada paso, desde la idea hasta la valija.</p>
  </div>
  <div class="n-info-card">
    <i class="bi bi-globe2"></i>
    <h4>Destinos para todos los gustos</h4>
    <p>Nacionales e internacionales, en grupo o a medida.</p>
  </div>
  <div class="n-info-card">
    <i class="bi bi-shield-check"></i>
    <h4>Confianza</h4>
    <p>Años de experiencia ayudando a viajar tranquilo.</p>
  </div>
</div>

<?php $content = ob_get_clean(); echo view('layout_nueva', ['title' => 'Sobre mí', 'config' => $config, 'content' => $content]); ?>
