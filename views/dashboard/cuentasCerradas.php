<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">🧾 Historial de Cuentas Cerradas</h2>

    <?php if (!empty($historial)): ?>
        <?php foreach ($historial as $factura): ?>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Mesa #<?= $factura['id_mesa'] ?></span>
                    <span>Total: <strong>$<?= number_format($factura['total'], 2) ?></strong></span>
                    <span><?= date('d/m/Y H:i', strtotime($factura['fecha'])) ?></span>
                </div>
                <div class="card-body bg-light">
                    <h5 class="card-title text-secondary">🛒 Detalles del Consumo</h5>
                    <pre class="bg-white p-3 rounded border"><?= json_encode(json_decode($factura['detalles']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></pre>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No hay cuentas cerradas registradas.
        </div>
    <?php endif; ?>
</div>
