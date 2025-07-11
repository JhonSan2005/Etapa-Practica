<?php require_once __DIR__ . "/../../helpers/functions.php"; ?>

<div class="container">
    <h2 class="mt-5 mb-4 text-center">Actualizar Mesa</h2>

    <?php if (!empty($resultado)) : ?>
        <div class="alert alert-info"><?php echo $resultado; ?></div>
    <?php endif; ?>

    <?php if (!empty($mesa)) : ?>
        <form method="POST" class="mb-5">
            <div class="mb-3">
                <label for="numero_mesa" class="form-label">Nombre o Número de Mesa</label>
                <input type="text" class="form-control" id="numero_mesa" name="numero_mesa" value="<?= $mesa['nombre_mesa']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Mesa</button>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">La mesa no fue encontrada.</div>
    <?php endif; ?>
</div>