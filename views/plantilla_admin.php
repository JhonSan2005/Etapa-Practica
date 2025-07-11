<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Repuestos JJ | <?php echo $title ?? ''; ?></title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">

  <style>
    .contenido-admin {
      padding: 2rem;
      flex-grow: 1;
    }

    @media (max-width: 768px) {
      .main-content {
        margin-left: 0 !important;
      }
    }
  </style>
</head>
<body>
    <?php include_once __DIR__ . '../includes/header-admin.php'; ?>

 
  
  <main class="contenedor-centrado">
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-body-secondary text-center mb-4"><?php echo $title; ?></h2>
      <?php echo $contenido; ?>
    </div>
  </main>

  </div> <!-- Cierra .main-content -->
  </div> <!-- Cierra .admin-wrapper -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
