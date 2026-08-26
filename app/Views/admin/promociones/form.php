<?php $content = ob_start() ?: ''; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
<style>
  /* Quill solo trae etiquetas para sus 4 tamanios por defecto (small/normal/
     large/huge); como usamos pixeles propios, sin esto el menu muestra
     "Normal" en todas las opciones. */
  .ql-toolbar.ql-snow .ql-picker.ql-size .ql-picker-label::before,
  .ql-toolbar.ql-snow .ql-picker.ql-size .ql-picker-item::before {
    content: attr(data-value);
  }
</style>

<form method="post" enctype="multipart/form-data"
      action="<?= $promocion ? site_url('admin/promociones/actualizar/' . $promocion['id']) : site_url('admin/promociones/guardar') ?>">
  <?= csrf_field() ?>

  <div class="card mb-3">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-12 col-md-8">
          <label class="form-label small mb-1">Título</label>
          <input type="text" name="titulo" class="form-control" required value="<?= esc($promocion['titulo'] ?? '') ?>">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small mb-1">Destino</label>
          <input type="text" name="destino" class="form-control" required placeholder="Ej: Brasil" value="<?= esc($promocion['destino'] ?? '') ?>">
        </div>

        <div class="col-12 col-md-4">
          <label class="form-label small mb-1">Categoría</label>
          <input type="text" name="categoria" class="form-control" placeholder="Ej: Playa, Aventura, Cultural" value="<?= esc($promocion['categoria'] ?? '') ?>">
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Precio</label>
          <input type="number" step="0.01" name="precio" class="form-control" value="<?= esc($promocion['precio'] ?? '') ?>">
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Moneda</label>
          <select name="moneda" class="form-select">
            <?php foreach (['ARS', 'USD'] as $m): ?>
              <option value="<?= $m ?>" <?= ($promocion['moneda'] ?? 'ARS') === $m ? 'selected' : '' ?>><?= $m ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Vigencia desde</label>
          <input type="date" name="fecha_desde" class="form-control" value="<?= esc($promocion['fecha_desde'] ?? '') ?>">
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Vigencia hasta</label>
          <input type="date" name="fecha_hasta" class="form-control" value="<?= esc($promocion['fecha_hasta'] ?? '') ?>">
        </div>

        <div class="col-12">
          <label class="form-label small mb-1">Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4"><?= esc($promocion['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="col-6 col-md-2">
          <label class="form-label small mb-1">Orden</label>
          <input type="number" name="orden" class="form-control" value="<?= esc($promocion['orden'] ?? 0) ?>">
          <div class="form-text">Del 1 al 5: prioridad (1 primero) y su foto de portada rota en el fondo de Inicio. En 0: sin prioridad, aparece al final.</div>
        </div>

        <div class="col-12">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="activa" id="activa" value="1" <?= (!$promocion || $promocion['activa']) ? 'checked' : '' ?>>
            <label class="form-check-label small" for="activa">Promoción activa (visible en el sitio)</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <label class="form-label small mb-1">Imagen de portada</label>
      <?php if (!empty($promocion['imagen_portada'])): ?>
        <div class="mb-2"><img src="<?= base_url($promocion['imagen_portada']) ?>" style="max-width:180px;border-radius:10px" alt="Portada actual"></div>
      <?php endif ?>
      <input type="file" name="imagen_portada" class="form-control" accept="image/*" data-comprimir>
      <div class="form-text">Se muestra en las tarjetas de promoción y en el detalle. Usá una foto horizontal (apaisada, ej. 16:9) para que se vea completa y sin recortes. Dejá vacío para no cambiarla.</div>

      <label class="form-label small mb-1 mt-3">Destacado en la foto</label>
      <input type="text" name="destacado_foto" class="form-control" maxlength="50" placeholder="Ej: 2x1, Últimos lugares, USD 500" value="<?= esc($promocion['destacado_foto'] ?? '') ?>">
      <div class="form-text">Texto corto para la placa sobre la foto de portada. Si lo dejás vacío, se muestra el precio.</div>

      <label class="form-label small mb-1 mt-3">Destacado con formato (opcional)</label>
      <div id="editorDestacadoHtml" style="background:#fff"></div>
      <textarea name="destacado_html" id="inputDestacadoHtml" hidden><?= $promocion['destacado_html'] ?? '' ?></textarea>
      <div class="form-text">Texto con formato (negrita, tamaños, colores) que se superpone sobre toda la foto de portada, con un velo oscuro abajo para que se lea bien — para armar algo tipo flyer sin tener que diseñar la imagen aparte. Si completás esto, reemplaza la placa simple de arriba.</div>
    </div>
  </div>

  <?php if ($promocion): ?>
  <div class="card mb-3">
    <div class="card-body">
      <label class="form-label small mb-1">Galería de fotos</label>
      <?php if (!empty($imagenes)): ?>
        <div class="d-flex flex-wrap gap-2 mb-3">
          <?php foreach ($imagenes as $img): ?>
            <div class="position-relative">
              <img src="<?= base_url($img['ruta']) ?>" style="width:100px;height:100px;object-fit:cover;border-radius:10px" alt="Foto">
              <button type="submit" form="form-eliminar-img-<?= $img['id'] ?>" class="btn btn-sm btn-danger py-0 px-1 position-absolute top-0 end-0 m-1"><i class="bi bi-x"></i></button>
            </div>
          <?php endforeach ?>
        </div>
      <?php endif ?>
      <input type="file" name="galeria[]" class="form-control" accept="image/*" multiple data-comprimir>
      <div class="form-text">Podés seleccionar varias fotos a la vez para agregarlas a la galería.</div>
    </div>
  </div>
  <?php endif ?>

  <div class="d-flex gap-2">
    <button class="btn btn-brand"><i class="bi bi-check-lg me-1"></i>Guardar</button>
    <a href="<?= site_url('admin/promociones') ?>" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>

<?php if ($promocion && !empty($imagenes)): ?>
  <?php foreach ($imagenes as $img): ?>
    <form id="form-eliminar-img-<?= $img['id'] ?>" method="post" class="d-none"
          action="<?= site_url('admin/promociones/imagen/eliminar/' . $img['id']) ?>"
          onsubmit="return confirm('¿Eliminar esta foto?')">
      <?= csrf_field() ?>
    </form>
  <?php endforeach ?>
<?php endif ?>

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
    if (boton) { boton.disabled = true; boton.innerHTML = 'Optimizando fotos...'; }

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
      // si algo falla, se envia igual con las fotos originales
      form.dataset.comprimido = '1';
      form.submit();
    });
  });
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
(function () {
  var contenedor = document.getElementById('editorDestacadoHtml');
  var oculto = document.getElementById('inputDestacadoHtml');
  if (!contenedor || !oculto) return;

  // Tamanios en pixeles guardados como estilo inline (no como clase), asi
  // se ven igual en el editor y en la home sin depender del CSS de Quill.
  var TAMANIOS = ['12px', '14px', '16px', '18px', '20px', '24px', '28px', '36px', '48px'];
  var SizeStyle = Quill.import('attributors/style/size');
  SizeStyle.whitelist = TAMANIOS;
  Quill.register(SizeStyle, true);

  var quill = new Quill(contenedor, {
    theme: 'snow',
    placeholder: 'Ej: 2x1 en cabañas\nSalidas todos los sábados',
    modules: {
      toolbar: [
        ['bold', 'italic', 'underline'],
        [{ color: [] }],
        [{ size: TAMANIOS }],
        [{ align: [] }],
        ['clean'],
      ],
    },
  });

  var htmlInicial = <?= json_encode($promocion['destacado_html'] ?? '') ?>;
  if (htmlInicial) {
    quill.clipboard.dangerouslyPasteHTML(htmlInicial);
  }

  quill.on('text-change', function () {
    oculto.value = quill.getText().trim().length === 0 ? '' : quill.root.innerHTML;
  });
})();
</script>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => $promocion ? 'Editar promoción' : 'Nueva promoción', 'content' => $content]); ?>
