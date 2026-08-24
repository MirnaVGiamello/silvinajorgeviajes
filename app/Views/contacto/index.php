<?php $content = ob_start() ?: ''; ?>

<section class="hero" style="padding:3.5rem 0">
  <div class="container">
    <div class="hero-eslogan">Contacto</div>
    <h1>Hablemos de tu próximo viaje</h1>
  </div>
</section>

<section class="container py-4 pb-5">
  <div class="row g-4">
    <?php if (!empty($config['whatsapp'])): ?>
    <div class="col-12 col-md-4">
      <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $config['whatsapp']), 'attr') ?>" target="_blank" rel="noopener" class="info-card text-center d-block">
        <i class="bi bi-whatsapp"></i>
        <h4>WhatsApp</h4>
        <p class="text-muted mb-0"><?= esc($config['whatsapp']) ?></p>
      </a>
    </div>
    <?php endif ?>

    <?php if (!empty($config['telefono'])): ?>
    <div class="col-12 col-md-4">
      <div class="info-card text-center">
        <i class="bi bi-telephone"></i>
        <h4>Teléfono</h4>
        <p class="text-muted mb-0"><?= esc($config['telefono']) ?></p>
      </div>
    </div>
    <?php endif ?>

    <?php if (!empty($config['email'])): ?>
    <div class="col-12 col-md-4">
      <a href="mailto:<?= esc($config['email'], 'attr') ?>" class="info-card text-center d-block">
        <i class="bi bi-envelope"></i>
        <h4>Email</h4>
        <p class="text-muted mb-0"><?= esc($config['email']) ?></p>
      </a>
    </div>
    <?php endif ?>

    <?php if (!empty($config['direccion'])): ?>
    <div class="col-12 col-md-4">
      <div class="info-card text-center">
        <i class="bi bi-geo-alt"></i>
        <h4>Dirección</h4>
        <p class="text-muted mb-0"><?= esc($config['direccion']) ?></p>
      </div>
    </div>
    <?php endif ?>

    <?php if (!empty($config['instagram'])): ?>
    <div class="col-12 col-md-4">
      <a href="https://instagram.com/<?= esc(ltrim($config['instagram'], '@'), 'attr') ?>" target="_blank" rel="noopener" class="info-card text-center d-block">
        <i class="bi bi-instagram"></i>
        <h4>Instagram</h4>
        <p class="text-muted mb-0">@<?= esc(ltrim($config['instagram'], '@')) ?></p>
      </a>
    </div>
    <?php endif ?>

    <?php if (!empty($config['facebook'])): ?>
    <div class="col-12 col-md-4">
      <a href="https://facebook.com/<?= esc($config['facebook'], 'attr') ?>" target="_blank" rel="noopener" class="info-card text-center d-block">
        <i class="bi bi-facebook"></i>
        <h4>Facebook</h4>
        <p class="text-muted mb-0"><?= esc($config['facebook']) ?></p>
      </a>
    </div>
    <?php endif ?>
  </div>

  <?php if (empty($config['whatsapp']) && empty($config['telefono']) && empty($config['email'])): ?>
    <p class="text-center text-muted py-4">Todavía no se cargaron los datos de contacto. Podés editarlos desde el panel de administración.</p>
  <?php endif ?>
</section>

<?php $content = ob_get_clean(); echo view('layout', ['title' => 'Contacto', 'config' => $config, 'content' => $content]); ?>
