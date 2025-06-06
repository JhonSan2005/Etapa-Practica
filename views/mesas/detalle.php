<div class="container mt-4">
    <h2 class="text-center mb-4">Detalles de <?= htmlspecialchars($mesa['nombre_mesa']) ?></h2>
    <div class="row">
        <!-- Productos consumidos (lado izquierdo) -->
        <div class="col-md-6">
            <h4 class="text-center">Productos Consumidos</h4>
            <?php if (!empty($productosConsumidos)): ?>
                <ul class="list-group">
                    <?php foreach ($productosConsumidos as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($item['nombre_producto']) ?> 
                            <span><?= $item['cantidad'] ?> x $<?= number_format($item['precio'], 2) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-center text-muted">Nada consumido aún.</p>
            <?php endif; ?>
        </div>

        <!-- Productos disponibles y carrito temporal (lado derecho) -->
        <div class="col-md-6">
            <h4 class="text-center">Productos Disponibles</h4>
            <ul class="list-group" id="productos-disponibles">
                <?php foreach ($productosDisponibles as $producto): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center" 
                        data-id="<?= $producto['id_producto'] ?>" 
                        data-nombre="<?= htmlspecialchars($producto['nombre_producto']) ?>" 
                        data-precio="<?= $producto['precio'] ?>"
                        data-stock="<?= $producto['stock'] ?>"> <!-- Asumiendo que tienes 'stock' -->
                        <div>
                            <?= htmlspecialchars($producto['nombre_producto']) ?>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span>$<?= number_format($producto['precio'], 2) ?></span>
                            <small class="text-muted">(<?= $producto['stock'] ?> disponibles)</small>
                            <button class="btn btn-success btn-sm rounded-circle px-2 py-0 btn-agregar">+1</button>
                            <button class="btn btn-danger btn-sm rounded-circle px-2 py-0 btn-quitar">-1</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h4 class="text-center mt-4">Carrito Temporal</h4>
            <ul class="list-group" id="carrito-temporal">
                <li class="list-group-item text-center text-muted">No hay productos agregados</li>
            </ul>
        </div>
    </div>

    <div class="text-center mt-4">
        <form action="/mesas/cerrarCuenta" method="POST">
            <input type="hidden" name="id_mesa" value="<?= htmlspecialchars($mesa['id_mesa']) ?>">
            <button class="btn btn-danger">Cerrar Cuenta</button>
        </form>
    </div>
</div>

<script>
    const carrito = {};

    function actualizarCarrito() {
        const carritoLista = document.getElementById('carrito-temporal');
        carritoLista.innerHTML = '';

        const ids = Object.keys(carrito);
        if (ids.length === 0) {
            carritoLista.innerHTML = '<li class="list-group-item text-center text-muted">No hay productos agregados</li>';
            return;
        }

        ids.forEach(id => {
            const item = carrito[id];
            const subtotal = (item.precio * item.cantidad).toFixed(2);
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.textContent = `${item.nombre} x ${item.cantidad}`;
            const span = document.createElement('span');
            span.textContent = `$${subtotal}`;
            li.appendChild(span);
            carritoLista.appendChild(li);
        });
    }

    document.querySelectorAll('.btn-agregar').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const li = e.target.closest('li');
            const id = li.getAttribute('data-id');
            const nombre = li.getAttribute('data-nombre');
            const precio = parseFloat(li.getAttribute('data-precio'));
            const stock = parseInt(li.getAttribute('data-stock'));

            if (!carrito[id]) {
                carrito[id] = {nombre: nombre, precio: precio, cantidad: 0};
            }

            // Solo agregar si la cantidad no supera el stock disponible
            if (carrito[id].cantidad < stock) {
                carrito[id].cantidad++;
                actualizarCarrito();
            } else {
                alert(`No hay más stock disponible de "${nombre}".`);
            }
        });
    });

    document.querySelectorAll('.btn-quitar').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const li = e.target.closest('li');
            const id = li.getAttribute('data-id');

            if (carrito[id]) {
                carrito[id].cantidad--;
                if (carrito[id].cantidad <= 0) {
                    delete carrito[id];
                }
                actualizarCarrito();
            }
        });
    });
</script>
