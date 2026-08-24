<?php $content = ob_start() ?: ''; ?>

<section class="container py-5" style="max-width:420px">
  <div class="text-center mb-4">
    <div class="brand justify-content-center">
      <img src="<?= base_url('assets/img/logoSilvina.png') ?>" alt="Silvina Jorge Viajes" class="brand-logo">
      <span class="brand-agencia">Silvina Jorge</span>
    </div>
    <p class="text-muted small mt-1">Panel de administración</p>
  </div>

  <div class="info-card">
    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small"><?= esc($error) ?></div>
    <?php endif ?>
    <form method="post" action="<?= site_url('login') ?>">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label small mb-1">Usuario</label>
        <input type="text" name="usuario" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label small mb-1">Contraseña</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn-brand w-100">Ingresar</button>
    </form>
  </div>

  <div class="text-center mt-3">
    <a href="<?= site_url('/') ?>" class="small text-muted"><i class="bi bi-arrow-left me-1"></i>Volver al sitio</a>
  </div>
</section>

<?php $content = ob_get_clean(); echo view('layout', ['title' => 'Ingresar', 'config' => $config, 'content' => $content]); ?>
