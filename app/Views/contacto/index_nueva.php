<?php $content = ob_start() ?: ''; ?>

<section class="n-pagehero">
  <div class="n-pagehero-bg" style="--hero-photo:url('<?= base_url('assets/img/hero-bg.webp') ?>')"></div>
  <div class="n-pagehero-inner">
    <span class="n-eyebrow mono">Contacto</span>
    <h1 class="mt-2">Hablemos de tu próximo viaje</h1>
  </div>
</section>

<div class="n-info-grid">
  <?php if (!empty($config['whatsapp'])): ?>
    <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $config['whatsapp']), 'attr') ?>" target="_blank" rel="noopener" class="n-info-card">
      <i class="bi bi-whatsapp"></i>
      <h4>WhatsApp</h4>
      <p><?= esc($config['whatsapp']) ?></p>
    </a>
  <?php endif ?>

  <?php if (!empty($config['telefono'])): ?>
    <div class="n-info-card">
      <i class="bi bi-telephone"></i>
      <h4>Teléfono</h4>
      <p><?= esc($config['telefono']) ?></p>
    </div>
  <?php endif ?>

  <?php if (!empty($config['email'])): ?>
    <a href="mailto:<?= esc($config['email'], 'attr') ?>" class="n-info-card">
      <i class="bi bi-envelope"></i>
      <h4>Email</h4>
      <p><?= esc($config['email']) ?></p>
    </a>
  <?php endif ?>

  <?php if (!empty($config['direccion'])): ?>
    <div class="n-info-card">
      <i class="bi bi-geo-alt"></i>
      <h4>Dirección</h4>
      <p><?= esc($config['direccion']) ?></p>
    </div>
  <?php endif ?>

  <?php if (!empty($config['instagram'])): ?>
    <a href="https://instagram.com/<?= esc(ltrim($config['instagram'], '@'), 'attr') ?>" target="_blank" rel="noopener" class="n-info-card">
      <i class="bi bi-instagram"></i>
      <h4>Instagram</h4>
      <p>@<?= esc(ltrim($config['instagram'], '@')) ?></p>
    </a>
  <?php endif ?>

  <?php if (!empty($config['facebook'])): ?>
    <a href="https://facebook.com/<?= esc($config['facebook'], 'attr') ?>" target="_blank" rel="noopener" class="n-info-card">
      <i class="bi bi-facebook"></i>
      <h4>Facebook</h4>
      <p><?= esc($config['facebook']) ?></p>
    </a>
  <?php endif ?>
</div>

<?php if (empty($config['whatsapp']) && empty($config['telefono']) && empty($config['email'])): ?>
  <p class="text-center py-4" style="max-width:1180px;margin:0 auto">Todavía no se cargaron los datos de contacto. Podés editarlos desde el panel de administración.</p>
<?php endif ?>

<?php $content = ob_get_clean(); echo view('layout_nueva', ['title' => 'Contacto', 'config' => $config, 'content' => $content]); ?>
