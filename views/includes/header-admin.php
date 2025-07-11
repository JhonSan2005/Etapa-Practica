<?php
require_once __DIR__ . '/../../helpers/functions.php';
$session_activa = isAuth();
?>

<?php if ($session_activa): ?>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
    }

    .admin-wrapper {
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #1d2127;
      color: white;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding-top: 1rem;
      z-index: 1000;
    }

    .sidebar .logo {
      text-align: center;
      margin-bottom: 2rem;
    }

    .sidebar .logo img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
    }

    .sidebar a {
      color: white;
      padding: 0.8rem 1.5rem;
      text-decoration: none;
      display: block;
      transition: background-color 0.2s ease;
    }

    .sidebar a:hover {
      background-color: #2c3036;
    }

    .main-content {
      margin-left: 250px;
      width: calc(100% - 250px);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: #f9f9f9;
    }

    .topbar {
      background-color: #003366;
      color: white;
      padding: 0.8rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .topbar .admin-profile {
      display: flex;
      align-items: center;
    }

    .topbar .admin-profile img {
      width: 35px;
      height: 35px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 10px;
    }

    .topbar .admin-profile span {
      font-weight: 500;
    }

    /* Ajuste para que todo el contenido del main se expanda correctamente */
    .contenido-principal {
      width: 100%;
      padding: 2rem;
    }
  </style>

  <div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <a href="/admin/dashboard">
          <img src="/img/uploads/logo.png" alt="Logo Tienda">
        </a>
      </div>

      <a href="/admin/dashboard">🏠 Dashboard</a>
      <a href="/admin/tablaUser">👥 Tabla</a>
      <a href="/admin/graficas">📈 Graficas</a>
      <a href="/admin/products">📦 Productos</a>
      <a href="/admin/categories">🏷️ Categorías</a>
      <!-- <a href="/admin/verHistorial">📜 Historial</a> -->
      <a href="/admin/cuentasCerradas">🔒 Cuentas</a>
      <a href="/admin/verMesasAdmin">🍽️ Mesas</a>
      <a href="/admin/adminPerfil">⚙️ Perfil</a>
      <a href="/close-session" style="color: red;">🚪 Cerrar sesión</a>
    </aside>
    

    <!-- Contenido -->
    <div class="main-content">
      <div class="topbar">
        <span class="fw-bold fs-5">Panel de Administración</span>
      
      </div>

      <!-- Aquí inicia tu contenido principal -->
      <div class="contenido-principal">
<?php endif; ?>
