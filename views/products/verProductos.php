<style>
    .inventario-container {
        background: #f9fafb;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }

    .inventario-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 25px;
        color: #333;
    }

    .table thead {
        background: #343a40;
        color: #fff;
        border-radius: 10px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table tbody tr:hover {
        background-color: #f1f3f5;
        transition: 0.3s ease;
    }

    .table-bordered {
        border-color: #dee2e6;
    }

    .table td, .table th {
        border-color: #dee2e6;
    }
</style>

<div class="container mt-5 inventario-container">
    <h3 class="inventario-title text-center">📦 Lista de Inventario</h3>

    <?php if (!empty($productos)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle rounded">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Valor</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) : ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['id_producto']) ?></td>
                            <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                            <td>$<?= number_format($producto['precio'], 2) ?></td>
                            <td><?= htmlspecialchars($producto['stock']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="alert alert-warning text-center">No hay productos en el inventario.</p>
    <?php endif; ?>
</div>
