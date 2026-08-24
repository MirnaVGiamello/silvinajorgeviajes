<?php $content = ob_start() ?: ''; ?>

<div class="card" style="max-width:480px">
  <div class="card-body">
    <form method="post" action="<?= $usuario ? site_url('admin/usuarios/actualizar/' . $usuario['id']) : site_url('admin/usuarios/guardar') ?>">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label class="form-label small mb-1">Nombre</label>
        <input type="text" name="nombre" class="form-control" required value="<?= esc($usuario['nombre'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label small mb-1">Usuario</label>
        <input type="text" name="usuario" class="form-control" required value="<?= esc($usuario['usuario'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label small mb-1">Contraseña <?= $usuario ? '(dejar vacío para no cambiarla)' : '' ?></label>
        <input type="password" name="password" class="form-control" <?= $usuario ? '' : 'required' ?>>
      </div>
      <div class="mb-3">
        <label class="form-label small mb-1">Perfil</label>
        <select name="perfil" class="form-select">
          <option value="operador" <?= ($usuario['perfil'] ?? 'operador') === 'operador' ? 'selected' : '' ?>>Operador (solo promociones)</option>
          <option value="admin" <?= ($usuario['perfil'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador (todo el sistema)</option>
        </select>
      </div>
      <div class="mb-3 form-check form-switch">
        <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" <?= (!$usuario || $usuario['activo']) ? 'checked' : '' ?>>
        <label class="form-check-label small" for="activo">Activo</label>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-brand"><i class="bi bi-check-lg me-1"></i>Guardar</button>
        <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-outline-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>

<?php $content = ob_get_clean(); echo view('admin/layout', ['title' => $usuario ? 'Editar usuario' : 'Nuevo usuario', 'content' => $content]); ?>
