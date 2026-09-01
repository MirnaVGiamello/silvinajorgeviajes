<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Panel') ?> · Panel · Silvina Jorge Viajes</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Sacramento&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="icon" type="image/png" href="<?= base_url('assets/img/logoSilvina.png') ?>">
<style>
  :root{--ink:#2E4A52;--ink-soft:#587177;--lilac:#A98BC4;--gold:#C9A876;--teal:#4F7C82;--cream:#F8F4EC}
  body{background:#f5f3ee;font-family:'Montserrat',sans-serif}

  .sidebar{width:230px;min-height:100vh;background:var(--ink);flex-shrink:0;transition:transform .28s}
  .sidebar .brand{padding:18px;display:flex;align-items:center;gap:10px;color:#fff}
  .sidebar .brand img{height:46px;width:46px;border-radius:50%;background:#fff}
  .sidebar .brand-agencia{font-family:'Playfair Display',serif;font-weight:700;font-size:.8rem;letter-spacing:.03em;line-height:1.2}
  .sidebar .nav-link{color:rgba(255,255,255,.65);padding:9px 18px;border-radius:6px;margin:2px 10px;font-size:.88rem;display:flex;align-items:center;gap:8px}
  .sidebar .nav-link:hover,.sidebar .nav-link.active{color:#fff;background:rgba(255,255,255,.1)}
  .sidebar .nav-link i{font-size:1rem;opacity:.8}

  @media(min-width:768px){
    .sidebar{display:flex!important;flex-direction:column}
    .btn-menu{display:none!important}
    .sb-overlay{display:none!important}
  }
  @media(max-width:767px){
    .sidebar{position:fixed;top:0;left:0;bottom:0;z-index:1050;display:flex;flex-direction:column;transform:translateX(-100%);min-height:100%}
    .sidebar.open{transform:translateX(0)}
    .sb-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1049;display:none}
    .sb-overlay.vis{display:block}
    .btn-menu{display:flex!important}
    .main-col{width:100%}
  }

  .topbar{background:#fff;border-bottom:1px solid #e9ecef;padding:10px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px}
  .page-title{font-weight:700;font-size:1.05rem;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .content{padding:20px}
  .btn-brand{background:var(--ink);border:none;color:#fff;font-weight:600}
  .btn-brand:hover{background:var(--teal);color:#fff}
  .card{border:none;box-shadow:0 4px 16px rgba(46,74,82,.06)}
  .table-responsive{-webkit-overflow-scrolling:touch}
  .badge-perfil-admin{background:var(--lilac)}
  .badge-perfil-operador{background:var(--teal)}
</style>
</head>
<body>

<div id="sbOverlay" class="sb-overlay"></div>

<div class="d-flex">
  <div class="sidebar" id="sidebar">
    <div class="brand">
      <img src="<?= base_url('assets/img/logoSilvina.png') ?>" alt="Silvina Jorge Viajes">
      <span class="brand-agencia">Silvina Jorge<br>Viajes</span>
    </div>
    <nav class="flex-grow-1 py-2">
      <?php $u = current_url(); ?>
      <a href="<?= site_url('admin') ?>" class="nav-link <?= rtrim($u, '/') === rtrim(site_url('admin'), '/') ? 'active' : '' ?>"><i class="bi bi-speedometer2"></i> Panel</a>
      <a href="<?= site_url('admin/promociones') ?>" class="nav-link <?= str_contains($u, 'promociones') ? 'active' : '' ?>"><i class="bi bi-airplane"></i> Promociones</a>

      <?php if (session()->get('perfil') === 'admin'): ?>
        <hr style="border-color:rgba(255,255,255,.1);margin:8px 16px">
        <div style="color:rgba(255,255,255,.3);font-size:.68rem;letter-spacing:.1em;padding:4px 16px 2px">ADMINISTRACIÓN</div>
        <a href="<?= site_url('admin/usuarios') ?>" class="nav-link <?= str_contains($u, 'usuarios') ? 'active' : '' ?>"><i class="bi bi-people"></i> Usuarios</a>
        <a href="<?= site_url('admin/categorias') ?>" class="nav-link <?= str_contains($u, 'categorias') ? 'active' : '' ?>"><i class="bi bi-tags"></i> Categorías</a>
        <a href="<?= site_url('admin/configuracion') ?>" class="nav-link <?= str_contains($u, 'configuracion') ? 'active' : '' ?>"><i class="bi bi-gear"></i> Configuración</a>
      <?php endif ?>

      <hr style="border-color:rgba(255,255,255,.1);margin:8px 16px">
      <a href="<?= site_url('/') ?>" class="nav-link" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver sitio</a>
    </nav>
  </div>

  <div class="flex-grow-1 main-col" style="min-width:0">
    <div class="topbar">
      <div class="d-flex align-items-center gap-2" style="min-width:0;overflow:hidden">
        <button class="btn btn-sm btn-outline-secondary btn-menu p-1 lh-1" id="btnMenu" style="width:34px;height:34px" aria-label="Menú">
          <i class="bi bi-list fs-5"></i>
        </button>
        <span class="page-title text-muted">· <?= esc($title ?? '') ?></span>
      </div>
      <div class="d-flex align-items-center gap-2 flex-shrink-0">
        <span class="text-muted small text-nowrap"><i class="bi bi-person-circle me-1"></i><?= esc(session()->get('nombre')) ?></span>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Salir">
          <i class="bi bi-box-arrow-left"></i>
        </a>
      </div>
    </div>

    <?php if (session()->getFlashdata('ok')): ?>
      <div class="alert alert-success alert-dismissible m-3 mb-0 py-2" role="alert">
        <?= esc(session()->getFlashdata('ok')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible m-3 mb-0 py-2" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif ?>

    <div class="content">
      <?= $content ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sbOverlay');
const btnMenu = document.getElementById('btnMenu');

btnMenu.addEventListener('click', () => {
  sidebar.classList.toggle('open');
  overlay.classList.toggle('vis');
});
overlay.addEventListener('click', () => {
  sidebar.classList.remove('open');
  overlay.classList.remove('vis');
});
sidebar.querySelectorAll('.nav-link').forEach(a => {
  a.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('vis');
  });
});
</script>
</body>
</html>
