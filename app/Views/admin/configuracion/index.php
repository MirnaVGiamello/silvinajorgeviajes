<?php $content = ob_start() ?: ''; ?>

<div class="card" style="max-width:640px">
  <div class="card-body">
    <form method="post" action="<?= site_url('admin/configuracion') ?>" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="row g-3">
        <div class="col-12 col-md-8">
          <label class="form-label small mb-1">Nombre de la agencia</label>
          <input type="text" name="nombre_agencia" class="form-control" required value="<?= esc($config['nombre_agencia'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small mb-1">Eslogan</label>
          <input type="text" name="eslogan" class="form-control" value="<?= esc($config['eslogan'] ?? '') ?>">
        </div>

        <div class="col-12">
          <label class="form-label small mb-1">Texto "Sobre mí"</label>
          <textarea name="texto_nosotros" class="form-control" rows="5"><?= esc($config['texto_nosotros'] ?? '') ?></textarea>
        </div>

        <div class="col-12">
          <label class="form-label small mb-1">Foto de "Sobre mí"</label>
          <?php if (!empty($config['foto_nosotros'])): ?>
            <div class="mb-2"><img src="<?= base_url($config['foto_nosotros']) ?>" style="max-width:220px;border-radius:10px" alt="Foto actual de Sobre mí"></div>
          <?php endif ?>
          <input type="file" name="foto_nosotros" class="form-control" accept="image/jpeg" data-comprimir>
          <div class="form-text">Se muestra en la página "Sobre mí". Solo formato JPG, hasta 5 MB. Dejá vacío para no cambiarla.</div>
        </div>

        <div class="col-12"><hr class="my-1"></div>

        <div class="col-12">
          <label class="form-label small mb-1 d-block">Diseño del sitio</label>
          <div class="d-flex gap-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="tema_home" id="temaActual" value="actual" <?= ($config['tema_home'] ?? 'actual') === 'actual' ? 'checked' : '' ?>>
              <label class="form-check-label small" for="temaActual">Actual</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="tema_home" id="temaNueva" value="nueva" <?= ($config['tema_home'] ?? 'actual') === 'nueva' ? 'checked' : '' ?>>
              <label class="form-check-label small" for="temaNueva">Propuesta nueva</label>
            </div>
          </div>
          <div class="form-text">Cambia el diseño de Inicio, Promociones y la ficha de cada promoción. Nosotros, Contacto y el panel no se modifican.</div>
        </div>

        <div class="col-12"><hr class="my-1"></div>

        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">WhatsApp (con código de país, ej: 5491122334455)</label>
          <input type="text" name="whatsapp" class="form-control" value="<?= esc($config['whatsapp'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Teléfono</label>
          <input type="text" name="telefono" class="form-control" value="<?= esc($config['telefono'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Email</label>
          <input type="email" name="email" class="form-control" value="<?= esc($config['email'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Dirección</label>
          <input type="text" name="direccion" class="form-control" value="<?= esc($config['direccion'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Instagram (usuario, sin @)</label>
          <input type="text" name="instagram" class="form-control" value="<?= esc($config['instagram'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small mb-1">Facebook (usuario o página)</label>
          <input type="text" name="facebook" class="form-control" value="<?= esc($config['facebook'] ?? '') ?>">
        </div>
      </div>

      <div class="d-flex gap-2 mt-3">
        <button class="btn btn-brand"><i class="bi bi-check-lg me-1"></i>Guardar</button>
      </div>
    </form>
  </div>
</div>

<script>
(function () {
  var form = document.querySelector('form[enctype="multipart/form-data"]');
  var inputs = form ? form.querySelectorAll('input[type="file"][data-comprimir]') : [];
  if (!form || !inputs.length) return;

  var ANCHO_MAXIMO = 1600;
  var CALIDAD = 0.82;
  var MIN_PARA_COMPRIMIR = 400 * 1024; // no vale la pena tocar fotos ya livianas

  function comprimir(archivo) {
    return new Promise(function (resolve) {
      if (!archivo.type.startsWith('image/') || archivo.size < MIN_PARA_COMPRIMIR) {
        resolve(archivo);
        return;
      }
      var img = new Image();
      var url = URL.createObjectURL(archivo);
      img.onload = function () {
        URL.revokeObjectURL(url);
        var ancho = img.width, alto = img.height;
        if (ancho > ANCHO_MAXIMO) {
          alto = Math.round(alto * ANCHO_MAXIMO / ancho);
          ancho = ANCHO_MAXIMO;
        }
        var canvas = document.createElement('canvas');
        canvas.width = ancho;
        canvas.height = alto;
        canvas.getContext('2d').drawImage(img, 0, 0, ancho, alto);
        canvas.toBlob(function (blob) {
          if (!blob) { resolve(archivo); return; }
          var nombre = archivo.name.replace(/\.[^.]+$/, '') + '.jpg';
          resolve(new File([blob], nombre, { type: 'image/jpeg' }));
        }, 'image/jpeg', CALIDAD);
      };
      img.onerror = function () { URL.revokeObjectURL(url); resolve(archivo); };
      img.src = url;
    });
  }

  form.addEventListener('submit', function (ev) {
    if (form.dataset.comprimido === '1') return;
    ev.preventDefault();

    var boton = form.querySelector('.btn-brand');
    var textoOriginal = boton ? boton.innerHTML : '';
    if (boton) { boton.disabled = true; boton.innerHTML = 'Optimizando foto...'; }

    var tareas = Array.from(inputs).map(function (input) {
      if (!input.files.length) return Promise.resolve();
      return Promise.all(Array.from(input.files).map(comprimir)).then(function (archivos) {
        var dt = new DataTransfer();
        archivos.forEach(function (a) { dt.items.add(a); });
        input.files = dt.files;
      });
    });

    Promise.all(tareas).then(function () {
      form.dataset.comprimido = '1';
      form.submit();
    }).catch(function () {
      form.dataset.comprimido = '1';
      form.submit();
    });
  });
})();
</script>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => 'Configuración del sitio', 'content' => $content]); ?>
