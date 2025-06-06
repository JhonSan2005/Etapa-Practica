<style>
    .mesa-card {
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        text-align: center;
    }

    .mesa-card:hover {
        transform: translateY(-5px);
    }

    .mesa-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: #333;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Mesas Registradas</h2>

    <div class="row justify-content-center">
        <?php if (!empty($mesas)): ?>
            <?php foreach ($mesas as $mesa): ?>
                <div class="col-md-4 col-lg-3 d-flex justify-content-center">
                    <div class="mesa-card w-100">
                        <div class="mesa-title"><?= htmlspecialchars($mesa['nombre_mesa']) ?></div>
                       <a href="/mesas/detalle?id=<?= $mesa['id_mesa'] ?>" class="btn btn-primary mt-3 w-100">Ver</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="alert alert-warning text-center">No hay mesas registradas.</p>
        <?php endif; ?>
    </div>
</div>
