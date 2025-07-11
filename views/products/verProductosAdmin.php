<?php
    require_once __DIR__ . "/../../helpers/functions.php";
    // debugguear($productos);
?>

<div class="container">
    <a class="btn btn-success mt-5 mb-3" href="/admin/agregarProductos">Agregar Producto</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos) && is_array($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td><?php echo (int)$producto['stock']; ?></td>
                            <td>
                                <img class="img-thumbnail" style="width: 100px; height: 100px;" 
                                     src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" 
                                     alt="Imagen del producto">
                            </td>
                            <td>
                                <form action="/admin/actualizarProducto" method="GET" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">
                                    <button type="submit" class="btn btn-warning">Editar</button>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal<?php echo $producto['id_producto']; ?>">
                                    Eliminar
                                </button>

                                <!-- Modal de confirmación -->
                                <div class="modal fade" 
                                     id="deleteModal<?php echo $producto['id_producto']; ?>" 
                                     tabindex="-1" 
                                     aria-labelledby="deleteModalLabel<?php echo $producto['id_producto']; ?>" 
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?php echo $producto['id_producto']; ?>">
                                                    Confirmar Eliminación
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar el producto 
                                                "<strong><?php echo htmlspecialchars($producto['nombre_producto']); ?></strong>"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="/admin/products" method="POST" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay productos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
