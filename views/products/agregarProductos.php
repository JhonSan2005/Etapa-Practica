<div class="container my-3">

    <?php include_once __DIR__ . "/../../views/includes/alertaTemplate.php"; ?>

    <div class="p-3 shadow-sm mx-auto container-agregar-productos bg-white">
        <form action="/admin/agregarProductos" method="POST" enctype="multipart/form-data">

            <div class="form-group mb-3">
                <label for="nombre_producto" class="form-label">Nombre Producto</label>
                <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" autocomplete="off" required>
            </div>
            <div class="form-group mb-3">
                <label for="product_price" class="form-label">Precio</label>
                <input type="number" id="product_price" name="precio" class="form-control" autocomplete="off" required>
            </div>
            <div class="form-group mb-3">
                <label for="product_tax" class="form-label">Impuesto</label>
                <input type="number" id="product_tax" name="impuesto" class="form-control" autocomplete="off" required>
            </div>
            <div class="form-group mb-3">
                <label for="product_stock" class="form-label">Stock</label>
                <input type="number" id="product_stock" name="stock" class="form-control" autocomplete="off" required>
            </div>
            <div class="form-group mb-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select id="id_categoria" name="id_categoria" class="form-control" required>
                    <option value="">-- Selecciona una categoría --</option>
                    <?php foreach ($categorias as $categoria) : ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre_categoria']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="product_description" class="form-label">Descripción</label>
                <textarea id="product_description" name="descripcion" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group mb-3 d-flex flex-column">
                <label for="product_image" class="form-label">Imagen</label>
                <label for="product_image" style="width: fit-content;">
                    <span type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 25px; height: 25px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span class="mt-2 text-base leading-normal text-blue-500 font-bold">Selecciona un archivo</span>
                    </span>
                </label>

                <input type="file" id="product_image" name="imagen" class="hidden" accept=".png, .jpg" style="display: none;">

                <p class="file-info">Tipos de archivo aceptados: Solo .png y .jpg</p>
            </div>
            <div class="form-group mb-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </form>
    </div>
</div>
                    