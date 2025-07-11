<div class="container mt-4">
    <h2 class="text-center mb-4">Detalles de <?= htmlspecialchars($mesa['nombre_mesa']) ?></h2>
    <div class="row">
       <!-- Productos consumidos -->
<div class="col-md-6">
    <h4 class="text-center">Productos Consumidos</h4>
    <?php if (!empty($productosConsumidos)): ?>
        <ul class="list-group">
            <?php 
                $totalConsumido = 0;
                foreach ($productosConsumidos as $item): 
                    $subtotal = $item['cantidad'] * $item['precio'];
                    $totalConsumido += $subtotal;
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($item['nombre_producto']) ?> 
                    <span><?= $item['cantidad'] ?> x $<?= number_format($item['precio'], 2) ?></span>
                </li>
            <?php endforeach; ?>
            <!-- Total -->
            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                Total consumido:
                <span>$<?= number_format($totalConsumido, 2) ?></span>
            </li>
        </ul>
    <?php else: ?>
        <p class="text-center text-muted">Nada consumido aún.</p>
    <?php endif; ?>
</div>

        <!-- Productos disponibles y carrito -->
        <div class="col-md-6">
            <h4 class="text-center">Productos Disponibles</h4>
            <ul class="list-group" id="productos-disponibles">
                <?php foreach ($productosDisponibles as $producto): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center" 
                        data-id="<?= $producto['id_producto'] ?>" 
                        data-nombre="<?= htmlspecialchars($producto['nombre_producto']) ?>" 
                        data-precio="<?= $producto['precio'] ?>"
                        data-stock="<?= $producto['stock'] ?>">
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
            <ul class="list-group mb-3" id="carrito-temporal">
                <li class="list-group-item text-center text-muted">No hay productos agregados</li>
            </ul>

            <!-- Botón de añadir al consumo -->
            <form action="/mesas/agregarConsumo" method="POST" id="form-carrito">
                <input type="hidden" name="id_mesa" value="<?= htmlspecialchars($mesa['id_mesa']) ?>">
                <input type="hidden" name="carrito_json" id="carrito-json">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Añadir al consumo</button>
                </div>
            </form>
        </div>
    </div>

<div class="text-center mt-4">
    <form id="form-cerrar-cuenta">
        <input type="hidden" name="id_mesa" value="<?= htmlspecialchars($mesa['id_mesa']) ?>">
        <button type="submit" class="btn btn-danger" id="btn-cerrar-cuenta">Cerrar Cuenta</button>
    </form>

    <div id="mensaje-exito" class="mt-3" style="display:none;">
        <span class="text-success fs-1">✓</span>
        <p class="text-success">Cuenta cerrada exitosamente</p>
    </div>
</div>

<script>
document.getElementById('form-cerrar-cuenta').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita recarga

    const form = e.target;
    const formData = new FormData(form);
    const boton = document.getElementById('btn-cerrar-cuenta');
    boton.disabled = true;

    fetch('/mesas/cerrarCuenta', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        if (res.ok) {
            document.getElementById('mensaje-exito').style.display = 'block';
        } else {
            alert('Error al cerrar la cuenta');
            boton.disabled = false;
        }
    })
    .catch(() => {
        alert('Error de red al cerrar la cuenta');
        boton.disabled = false;
    });
});
</script>

<script>
    const carrito = {};

    function actualizarCarrito() {
        const carritoLista = document.getElementById('carrito-temporal');
        carritoLista.innerHTML = '';
        const ids = Object.keys(carrito);

        if (ids.length === 0) {
            carritoLista.innerHTML = '<li class="list-group-item text-center text-muted">No hay productos agregados</li>';
            document.getElementById('carrito-json').value = '';
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

        // Guardamos el carrito en JSON para enviarlo por el formulario
        document.getElementById('carrito-json').value = JSON.stringify(carrito);
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
