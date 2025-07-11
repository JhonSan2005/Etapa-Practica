<h2>Cuenta cerrada de la mesa #<?= htmlspecialchars($mesa) ?></h2>

<ul>
    <?php foreach ($productos as $prod): ?>
        <li><?= htmlspecialchars($prod['nombre_producto']) ?> x <?= $prod['cantidad'] ?> = $<?= number_format($prod['precio'] * $prod['cantidad'], 2) ?></li>
    <?php endforeach; ?>
</ul>

<p><strong>Total:</strong> $<?= number_format($total, 2) ?></p>
