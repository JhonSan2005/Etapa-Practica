<?php
  require_once __DIR__ . '/../../helpers/functions.php';
  $session_activa = isAuth();
?>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #003366;">
  <div class="container-fluid">
    <a class="navbar-brand logo" href="/">
      <img src="/img/uploads/logo.png" alt="Logo Tienda" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php if ($session_activa): ?>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-light fw-medium" href="/mesas">Mesas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light fw-medium" href="/products">Inventario</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light fw-medium" href="/contabilidad">Abministracción</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link text-light fw-medium dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="/img/uploads/logo.png" alt="Perfil" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
              Perfil
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="/profile">Ver Perfil</a></li>
              <li><a class="dropdown-item" href="/misCompras">Mis Compras</a></li>
              <li><a class="dropdown-item" href="/devolucion">Devoluciones</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="/close-session">Cerrar Sesión</a></li>
            </ul>
          </li>

        </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>