<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Inicio') ?> · <?= esc($config['nombre_agencia'] ?? 'Silvina Jorge Viajes') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800&family=Work+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&family=Sacramento&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/site-nueva.css') ?>?v=<?= @filemtime(FCPATH . 'assets/css/site-nueva.css') ?: time() ?>">
<link rel="icon" type="image/png" href="<?= base_url('assets/img/logoSilvina.png') ?>">
</head>
<body class="tema-nueva">

<?php if (session()->getFlashdata('ok')): ?>
  <div class="alert alert-success alert-dismissible m-0 rounded-0 text-center py-2" role="alert">
    <?= esc(session()->getFlashdata('ok')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif ?>

<header class="n-header">
  <div class="n-header-inner">
    <a href="<?= site_url('/') ?>" class="n-brandmark"><span><?= esc(strtoupper($config['nombre_agencia'] ?? 'Silvina Jorge')) ?></span></a>

    <button class="n-nav-toggle" id="nBtnNav" aria-label="Menú"><i class="bi bi-list"></i></button>

    <nav class="n-nav">
      <?php $u = current_url(); ?>
      <a href="<?= site_url('/') ?>" class="<?= $u === site_url('/') ? 'active' : '' ?>">Inicio</a>
      <a href="<?= site_url('promociones') ?>" class="<?= str_contains($u, 'promociones') ? 'active' : '' ?>">Promociones</a>
      <a href="<?= site_url('nosotros') ?>" class="<?= str_contains($u, 'nosotros') ? 'active' : '' ?>">Sobre mí</a>
      <a href="<?= site_url('contacto') ?>" class="<?= str_contains($u, 'contacto') ? 'active' : '' ?>">Contacto</a>
    </nav>
  </div>
  <nav class="n-mobile-nav" id="nMobileNav">
    <a href="<?= site_url('/') ?>">Inicio</a>
    <a href="<?= site_url('promociones') ?>">Promociones</a>
    <a href="<?= site_url('nosotros') ?>">Sobre mí</a>
    <a href="<?= site_url('contacto') ?>">Contacto</a>
  </nav>
</header>

<main><?= $content ?></main>

<footer class="n-foot">
  © <?= date('Y') ?> <?= esc(strtoupper($config['nombre_agencia'] ?? 'Silvina Jorge')) ?> —
  <a href="<?= session()->get('usuario_id') ? site_url('admin') : site_url('login') ?>">Ingresar</a>
</footer>

<?php if (!empty($config['whatsapp']) && empty($ocultarWhatsappFlotante)): ?>
  <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $config['whatsapp']), 'attr') ?>" target="_blank" rel="noopener" class="n-whatsapp" aria-label="WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>
<?php endif ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('nBtnNav').addEventListener('click', function () {
  document.getElementById('nMobileNav').classList.toggle('open');
});
</script>
</body>
</html>
