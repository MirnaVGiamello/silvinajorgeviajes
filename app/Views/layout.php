<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Inicio') ?> · <?= esc($config['nombre_agencia'] ?? 'Silvina Jorge Viajes') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&family=Sacramento&family=Montserrat:wght@400;500;600;700&family=Big+Shoulders+Display:wght@600;700;800&family=Work+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/site.css') ?>?v=<?= @filemtime(FCPATH . 'assets/css/site.css') ?: time() ?>">
<link rel="icon" type="image/png" href="<?= base_url('assets/img/logoSilvina.png') ?>">
</head>
<body>

<header class="site-header">
  <div class="container d-flex align-items-center justify-content-end py-3">
    <button class="btn btn-nav-toggle d-lg-none" id="btnNav" aria-label="Menú">
      <i class="bi bi-list fs-2"></i>
    </button>

    <nav class="d-none d-lg-flex align-items-center gap-4 main-nav">
      <?php $u = current_url(); ?>
      <a href="<?= site_url('/') ?>" class="<?= $u === site_url('/') ? 'active' : '' ?>">Inicio</a>
      <a href="<?= site_url('promociones') ?>" class="<?= str_contains($u, 'promociones') ? 'active' : '' ?>">Promociones</a>
      <a href="<?= site_url('nosotros') ?>" class="<?= str_contains($u, 'nosotros') ? 'active' : '' ?>">Sobre mí</a>
      <a href="<?= site_url('contacto') ?>" class="<?= str_contains($u, 'contacto') ? 'active' : '' ?>">Contacto</a>
    </nav>
  </div>

  <nav class="mobile-nav d-lg-none" id="mobileNav">
    <a href="<?= site_url('/') ?>">Inicio</a>
    <a href="<?= site_url('promociones') ?>">Promociones</a>
    <a href="<?= site_url('nosotros') ?>">Sobre mí</a>
    <a href="<?= site_url('contacto') ?>">Contacto</a>
  </nav>
</header>

<?php if (session()->getFlashdata('ok')): ?>
  <div class="alert alert-success alert-dismissible m-0 rounded-0 text-center py-2" role="alert">
    <?= esc(session()->getFlashdata('ok')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif ?>

<main>
  <?= $content ?>
</main>

<footer class="site-footer">
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="brand mb-2">
          <img src="<?= base_url('assets/img/logoSilvina.png') ?>" alt="Silvina Jorge Viajes" class="brand-logo brand-logo-footer">
          <span class="brand-agencia">Silvina Jorge</span>
        </div>
        <p class="footer-eslogan"><?= esc($config['eslogan'] ?? 'Sueña · Explora · Descubre') ?></p>
      </div>
      <div class="col-6 col-md-4">
        <div class="footer-titulo">Navegación</div>
        <a href="<?= site_url('promociones') ?>">Promociones</a>
        <a href="<?= site_url('nosotros') ?>">Sobre mí</a>
        <a href="<?= site_url('contacto') ?>">Contacto</a>
      </div>
      <div class="col-6 col-md-4">
        <div class="footer-titulo">Contacto</div>
        <?php if (!empty($config['whatsapp'])): ?>
          <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $config['whatsapp']), 'attr') ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1"></i><?= esc($config['whatsapp']) ?></a>
        <?php endif ?>
        <?php if (!empty($config['email'])): ?>
          <a href="mailto:<?= esc($config['email'], 'attr') ?>"><i class="bi bi-envelope me-1"></i><?= esc($config['email']) ?></a>
        <?php endif ?>
        <?php if (!empty($config['instagram'])): ?>
          <a href="https://instagram.com/<?= esc(ltrim($config['instagram'], '@'), 'attr') ?>" target="_blank" rel="noopener"><i class="bi bi-instagram me-1"></i>@<?= esc(ltrim($config['instagram'], '@')) ?></a>
        <?php endif ?>
      </div>
    </div>
    <hr class="footer-linea my-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center small footer-copy">
      <span>&copy; <?= date('Y') ?> <?= esc($config['nombre_agencia'] ?? 'Silvina Jorge Viajes') ?></span>
      <a href="<?= session()->get('usuario_id') ? site_url('admin') : site_url('login') ?>" class="footer-admin">Ingresar</a>
    </div>
  </div>
</footer>

<?php if (!empty($config['whatsapp']) && empty($ocultarWhatsappFlotante)): ?>
  <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $config['whatsapp']), 'attr') ?>" target="_blank" rel="noopener" class="btn-whatsapp" aria-label="WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>
<?php endif ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('btnNav').addEventListener('click', function () {
  document.getElementById('mobileNav').classList.toggle('open');
});
</script>
</body>
</html>
