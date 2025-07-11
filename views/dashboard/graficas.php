<div class="container my-5">
  <h2 class="mb-4 text-center text-primary">📊 Panel de Gráficas Circulares</h2>

  <div class="row">
    <!-- Ventas Diarias -->
    <div class="col-md-6 mb-4 d-flex">
      <div class="card shadow p-3 w-100 d-flex flex-row align-items-center">
        <div class="w-50">
          <canvas id="ventasDiarias"></canvas>
        </div>
        <div class="w-50 ps-3">
          <h6>🗓️ Ventas Diarias</h6>
          <p class="small text-muted">
            Aquí se muestran las ventas por cada día registrado. Esta gráfica te permite analizar el rendimiento diario del negocio.
          </p>
        </div>
      </div>
    </div>

    <!-- Productos más vendidos -->
    <div class="col-md-6 mb-4 d-flex">
      <div class="card shadow p-3 w-100 d-flex flex-row align-items-center">
        <div class="w-50">
          <canvas id="topProductos"></canvas>
        </div>
        <div class="w-50 ps-3">
          <h6>📦 Productos Más Vendidos</h6>
          <p class="small text-muted">
            Visualiza los productos que más se han vendido. Esto ayuda a planificar el stock y promociones.
          </p>
        </div>
      </div>
    </div>

    <!-- Ventas por mesa -->
    <div class="col-md-6 mb-4 d-flex">
      <div class="card shadow p-3 w-100 d-flex flex-row align-items-center">
        <div class="w-50">
          <canvas id="ventasPorMesa"></canvas>
        </div>
        <div class="w-50 ps-3">
          <h6>🍽️ Ventas por Mesa</h6>
          <p class="small text-muted">
            Muestra cuánto se ha vendido por cada mesa. Ideal para evaluar la rotación y rendimiento por área.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
function coloresAleatorios($cantidad) {
    $colores = [];
    for ($i = 0; $i < $cantidad; $i++) {
        $colores[] = 'rgba(' . rand(50,255) . ',' . rand(50,255) . ',' . rand(50,255) . ',0.7)';
    }
    return $colores;
}

// Ventas Diarias
$labelsDiarias = $totalesDiarios = [];
while ($row = $ventasDiarias->fetch_assoc()) {
    $labelsDiarias[] = $row['fecha'];
    $totalesDiarios[] = $row['total'];
}
$coloresDiarias = coloresAleatorios(count($labelsDiarias));

// Productos Más Vendidos
$labelsTopProductos = $datosTopProductos = [];
while ($row = $topProductos->fetch_assoc()) {
    $labelsTopProductos[] = $row['nombre_producto'];
    $datosTopProductos[] = $row['total_vendido'];
}
$coloresProductos = coloresAleatorios(count($labelsTopProductos));

// Ventas por Mesa
$labelsMesas = $datosMesas = [];
while ($row = $ventasPorMesa->fetch_assoc()) {
    $labelsMesas[] = $row['nombre_mesa'];
    $datosMesas[] = $row['total'];
}
$coloresMesas = coloresAleatorios(count($labelsMesas));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const generarGraficaCircular = (id, etiquetas, datos, colores, titulo) => {
        new Chart(document.getElementById(id).getContext('2d'), {
            type: 'pie',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: titulo,
                    data: datos,
                    backgroundColor: colores,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.formattedValue}`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });
    };

    // Renderizar gráficas
    generarGraficaCircular(
        'ventasDiarias',
        <?= json_encode($labelsDiarias) ?>,
        <?= json_encode($totalesDiarios) ?>,
        <?= json_encode($coloresDiarias) ?>,
        'Ventas Diarias'
    );

    generarGraficaCircular(
        'topProductos',
        <?= json_encode($labelsTopProductos) ?>,
        <?= json_encode($datosTopProductos) ?>,
        <?= json_encode($coloresProductos) ?>,
        'Productos Más Vendidos'
    );

    generarGraficaCircular(
        'ventasPorMesa',
        <?= json_encode($labelsMesas) ?>,
        <?= json_encode($datosMesas) ?>,
        <?= json_encode($coloresMesas) ?>,
        'Ventas por Mesa'
    );
</script>
