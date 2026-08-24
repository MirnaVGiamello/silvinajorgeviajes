<?php $content = ob_start() ?: ''; ?>

<section class="container py-5">
  <a href="<?= site_url('promociones') ?>" class="d-inline-block mb-3 text-muted"><i class="bi bi-arrow-left me-1"></i>Volver a promociones</a>

  <div class="detalle-hero mb-4">
    <?php if (!empty($promocion['imagen_portada'])): ?>
      <img src="<?= base_url($promocion['imagen_portada']) ?>" alt="<?= esc($promocion['titulo']) ?>" class="img-ampliable" role="button">
    <?php else: ?>
      <i class="bi bi-airplane"></i>
    <?php endif ?>
  </div>

  <div class="row g-4">
    <div class="col-12 col-lg-8">
      <div class="promo-destino mb-1"><?= esc($promocion['destino']) ?></div>
      <h1><?= esc($promocion['titulo']) ?></h1>
      <span class="badge-categoria mb-3 d-inline-block"><?= esc($promocion['categoria']) ?></span>
      <p class="text-muted" style="white-space:pre-line"><?= esc($promocion['descripcion']) ?></p>

      <?php if (!empty($imagenes)): ?>
        <div class="galeria-mini">
          <?php foreach ($imagenes as $img): ?>
            <img src="<?= base_url($img['ruta']) ?>" alt="Foto de <?= esc($promocion['titulo']) ?>" class="img-ampliable" role="button">
          <?php endforeach ?>
        </div>
      <?php endif ?>
    </div>

    <div class="col-12 col-lg-4">
      <div class="info-card">
        <?php if ($promocion['precio']): ?>
          <div class="promo-precio fs-3 mb-2"><?= esc($promocion['moneda']) ?> <?= number_format($promocion['precio'], 0) ?></div>
        <?php endif ?>
        <?php if (!empty($promocion['fecha_desde']) || !empty($promocion['fecha_hasta'])): ?>
          <p class="small text-muted mb-3">
            <i class="bi bi-calendar-event me-1"></i>
            Vigencia: <?= esc(date('d/m/Y', strtotime($promocion['fecha_desde']))) ?>
            <?php if (!empty($promocion['fecha_hasta'])): ?> al <?= esc(date('d/m/Y', strtotime($promocion['fecha_hasta']))) ?><?php endif ?>
          </p>
        <?php endif ?>
        <?php
          $mensajeWpp = sprintf(
              'Hola! Quiero más info de este viaje: %s - %s (ID #%d)',
              $promocion['titulo'],
              $promocion['destino'],
              $promocion['id']
          );
        ?>
        <?php if (!empty($config['whatsapp'])): ?>
          <p class="small text-muted mb-2">¿Te interesa? Consultanos</p>
          <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $config['whatsapp']), 'attr') ?>?text=<?= rawurlencode($mensajeWpp) ?>" target="_blank" rel="noopener" class="btn-whatsapp-consultar" aria-label="Consultar por WhatsApp">
            <i class="bi bi-whatsapp"></i>
          </a>
        <?php else: ?>
          <a href="<?= site_url('contacto') ?>" class="btn-brand w-100 d-block text-center">Consultar</a>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-transparent border-0">
      <button type="button" class="btn-close btn-close-white ms-auto m-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      <img src="" alt="" id="lightboxImg" class="w-100" style="object-fit:contain;max-height:85vh">
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.img-ampliable').forEach(function (img) {
  img.addEventListener('click', function () {
    var lightboxImg = document.getElementById('lightboxImg');
    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt;
    new bootstrap.Modal(document.getElementById('lightboxModal')).show();
  });
});
</script>

<?php $content = ob_get_clean(); echo view('layout', ['title' => $promocion['titulo'], 'config' => $config, 'content' => $content, 'ocultarWhatsappFlotante' => true]); ?>
