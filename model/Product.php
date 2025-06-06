<?php

require_once __DIR__ . '/../config/Conexion_db.php';

class Product extends Conexion{
   
    

    public static function agregarproductos($nombre_producto, $precio, $impuesto, $stock, $id_categoria, $descripcion, $imagen_url) {
        $conexion = self::conectar();
        $consulta = $conexion->prepare("INSERT INTO productos (nombre_producto, precio, impuesto, stock, id_categoria, descripcion, imagen_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $consulta->bind_param('ssddiss', $nombre_producto, $precio, $impuesto, $stock, $id_categoria, $descripcion, $imagen_url);
        $resultado = $consulta->execute();

        return $resultado;
    }



    public static function mostrarproductos( int $limit = 0 ) {
        $conexion = self::conectar();
        $consulta = "SELECT * from productos";
        if( $limit && $limit > 0 ) {
            $consulta .= " Limit $limit";
        }
        $consulta .= "";

        $resultado = $conexion->query($consulta)->fetch_all(MYSQLI_ASSOC);

        if (!$resultado) return false;

        return $resultado;
    }

    public static function buscarProducto( $campo, $datoABuscar ) {
        $conexion = Conexion::conectar();
        $consulta = "SELECT * FROM `productos` WHERE `$campo` = '$datoABuscar'";
        $resultado = $conexion->query($consulta)->fetch_all(MYSQLI_ASSOC);

        if (!$resultado) return false;

        return $resultado;
    }

    public static function buscarPorParametro($parametro) {
        // Suponiendo que tienes una conexión a la base de datos
        $conexion = Conexion::conectar(); // Cambié $db a $conexion
        $parametro = "%" . $parametro . "%"; // Para hacer una búsqueda de tipo LIKE
    
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE nombre_producto LIKE ? OR descripcion LIKE ?");
        $stmt->bind_param("ss", $parametro, $parametro); // Uniendo el parámetro en ambas columnas
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }


   
    public static function contarProductos() {
        $conexion = Conexion::conectar(); // Asegúrate de que la conexión esté configurada correctamente
        $resultado = $conexion->query("SELECT COUNT(*) AS total FROM productos"); // Cambia 'productos' por el nombre de tu tabla de productos
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }



    public static function encontrarProducto($id_producto) {
        $conexion = self::conectar();
        $consulta = $conexion->prepare("SELECT * FROM `productos` WHERE `id_producto` = ?");
        $consulta->bind_param('s', $id_producto);
        $consulta->execute();
        $resultado = $consulta->get_result()->fetch_assoc();
        return $resultado;
        }
        public static function actualizarProducto($nombre_producto, $precio, $impuesto, $stock, $id_categoria, $descripcion, $imagen_url, $id_producto) {
            $conexion = self::conectar();
            $consulta = $conexion->prepare("UPDATE productos SET nombre_producto=?, precio=?, impuesto=?, stock=?, id_categoria=?, descripcion=?, imagen_url=? WHERE id_producto=?");
            $consulta->bind_param('sdiiisss', $nombre_producto, $precio, $impuesto, $stock, $id_categoria, $descripcion, $imagen_url, $id_producto);
            $resultado = $consulta->execute();
            return $resultado;
        }
        public static function eliminarProductosAdmin($id_producto) {
            $conexion = self::conectar();
            
            // Eliminar las ventas relacionadas con el producto
            $consultaVentas = $conexion->prepare("DELETE FROM ventas WHERE id_producto = ?");
            $consultaVentas->bind_param('i', $id_producto);
            $consultaVentas->execute();
            
            // Ahora eliminar el producto
            $consultaProducto = $conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
            $consultaProducto->bind_param('i', $id_producto);
            $resultado = $consultaProducto->execute();
        
            return $resultado;
        }
        
    
        public static function actualizarProductoPorColumna($columnaDB, $datoAActualizar, $id_producto) {
            $conexion = self::conectar();
            $consulta = $conexion->query("UPDATE `productos` SET `$columnaDB` = '$datoAActualizar' WHERE id_producto = $id_producto");
            return $consulta;
        }
        
        
    
}


?>
