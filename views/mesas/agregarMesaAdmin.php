<?php
require_once __DIR__ . "/../../helpers/functions.php";
?>

<div class="container mt-5">
    <h2 class="mb-4">Agregar Mesa</h2>

    <?php if (!empty($alertas)) : ?>
        <div class="alert-container mb-3">
            <?php foreach ($alertas as $alerta) : ?>
                <div class="alert alert-<?= $alerta['type'] ?> text-center" role="alert">
                    <?= $alerta['msg'] ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/agregarMesasAdmin">
        <div class="mb-3">
            <label for="id_mesa" class="form-label">ID de Mesa</label>
            <input type="number" class="form-control" id="id_mesa" name="id_mesa" required>
        </div>

        <div class="mb-3">
            <label for="nombre_mesa" class="form-label">Nombre de la Mesa</label>
            <input type="text" class="form-control" id="nombre_mesa" name="nombre_mesa" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar Mesa</button>
        <a href="/admin/verMesasAdmin" class="btn btn-secondary">Volver</a>
    </form>
</div>
