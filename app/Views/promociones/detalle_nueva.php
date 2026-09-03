<?php $content = ob_start() ?: ''; ?>

<section class="n-detalle">
  <a href="<?= site_url('promociones') ?>" class="n-volver"><i class="bi bi-arrow-left"></i> Volver a promociones</a>

  <div class="n-detalle-foto">
    <?php if (!empty($promocion['imagen_portada'])): ?>
      <img src="<?= base_url($promocion['imagen_portada']) ?>" alt="<?= esc($promocion['titulo']) ?>" class="img-ampliable" role="button">
    <?php else: ?>
      <i class="bi bi-airplane"></i>
    <?php endif ?>
  </div>

  <div class="n-detalle-grid">
    <div>
      <div class="n-detalle-destino"><?= esc($promocion['destino']) ?></div>
      <h1 class="n-detalle-titulo"><?= esc($promocion['titulo']) ?></h1>
      <div class="d-flex flex-wrap gap-1 mb-3">
        <?php foreach ($promocion['categorias'] as $c): ?>
          <span class="n-cat d-inline-block"><?= esc(strtoupper($c['nombre'])) ?></span>
        <?php endforeach ?>
      </div>
      <div class="n-detalle-desc"><?= $promocion['descripcion'] ?></div>

      <?php if (!empty($imagenes)): ?>
        <div class="n-galeria-carrusel">
          <button type="button" class="n-galeria-flecha n-galeria-flecha-izq" aria-label="Ver fotos anteriores"><i class="bi bi-chevron-left"></i></button>
          <div class="n-galeria">
            <?php foreach ($imagenes as $img): ?>
              <img src="<?= base_url($img['ruta']) ?>" alt="Foto de <?= esc($promocion['titulo']) ?>" class="img-ampliable" role="button">
            <?php endforeach ?>
          </div>
          <button type="button" class="n-galeria-flecha n-galeria-flecha-der" aria-label="Ver más fotos"><i class="bi bi-chevron-right"></i></button>
        </div>
      <?php endif ?>
    </div>

    <div class="n-ticket">
      <?php if ($promocion['precio']): ?>
        <span class="n-price-label">Precio final</span>
        <span class="n-price"><?= esc($promocion['moneda']) ?> <?= number_format($promocion['precio'], 0) ?></span>
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
        <p class="n-ticket-cta-label">¿Te interesa? Consultanos</p>
        <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $config['whatsapp']), 'attr') ?>?text=<?= rawurlencode($mensajeWpp) ?>" target="_blank" rel="noopener" class="n-btn-whatsapp">
          <i class="bi bi-whatsapp"></i> Consultar por WhatsApp
        </a>
      <?php else: ?>
        <a href="<?= site_url('contacto') ?>" class="n-btn w-100 justify-content-center">Consultar</a>
      <?php endif ?>

      <?php if (!empty($promocion['fecha_desde']) || !empty($promocion['fecha_hasta'])): ?>
        <div class="n-ticket-vigencia">
          <i class="bi bi-calendar-event"></i>
          Vigencia: <?= esc(date('d/m/Y', strtotime($promocion['fecha_desde']))) ?>
          <?php if (!empty($promocion['fecha_hasta'])): ?> al <?= esc(date('d/m/Y', strtotime($promocion['fecha_hasta']))) ?><?php endif ?>
        </div>
      <?php endif ?>
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

document.querySelectorAll('.n-galeria-carrusel').forEach(function (cont) {
  var pista = cont.querySelector('.n-galeria');
  var izq = cont.querySelector('.n-galeria-flecha-izq');
  var der = cont.querySelector('.n-galeria-flecha-der');
  if (izq) izq.addEventListener('click', function () { pista.scrollBy({ left: -240, behavior: 'smooth' }); });
  if (der) der.addEventListener('click', function () { pista.scrollBy({ left: 240, behavior: 'smooth' }); });
});
</script>

<?php $content = ob_get_clean(); echo view('layout_nueva', ['title' => $promocion['titulo'], 'config' => $config, 'content' => $content, 'ocultarWhatsappFlotante' => true]); ?>
