<?php $content = ob_start() ?: ''; ?>

<div class="row g-3">
  <div class="col-6 col-md-4">
    <div class="card"><div class="card-body">
      <div class="text-muted small">Promociones totales</div>
      <div class="fs-3 fw-bold"><?= $totalPromociones ?></div>
    </div></div>
  </div>
  <div class="col-6 col-md-4">
    <div class="card"><div class="card-body">
      <div class="text-muted small">Promociones activas</div>
      <div class="fs-3 fw-bold text-success"><?= $activas ?></div>
    </div></div>
  </div>
</div>

<div class="mt-4">
  <a href="<?= site_url('admin/promociones/nueva') ?>" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i>Nueva promoción</a>
</div>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => 'Panel', 'content' => $content]); ?>
