<?php

require_once __DIR__ . '/../config/Conexion_db.php';

class Mesas extends Conexion {
    public static function obtenerMesas() {
        $conexion = self::conectar();
        $sql = "SELECT * FROM mesas";
        $resultado = $conexion->query($sql)->fetch_all(MYSQLI_ASSOC);

        return $resultado ?: [];
    }

    public static function buscarPorId($id) {
        $conexion = self::conectar();
        $stmt = $conexion->prepare("SELECT * FROM mesas WHERE id_mesa = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function obtenerProductosDisponibles() {
        $conexion = self::conectar();
        return $conexion->query("SELECT * FROM productos")->fetch_all(MYSQLI_ASSOC);
    }

    public static function obtenerProductosConsumidos($id_mesa) {
        $conexion = self::conectar();
        $sql = "SELECT p.id_producto, p.nombre_producto, p.precio, mp.cantidad 
                FROM mesa_productos mp 
                JOIN productos p ON mp.id_producto = p.id_producto 
                WHERE mp.id_mesa = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_mesa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function guardarProductosConsumidos($id_mesa, $productos) {
        $conexion = self::conectar();
        $conexion->begin_transaction();

        try {
            foreach ($productos as $item) {
                $id_producto = $item['id_producto'];
                $cantidad = $item['cantidad'];

                // Verificar si ya existe ese producto para esa mesa
                $stmt = $conexion->prepare("SELECT cantidad FROM mesa_productos WHERE id_mesa = ? AND id_producto = ?");
                $stmt->bind_param("ii", $id_mesa, $id_producto);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    // Ya existe, actualizar sumando cantidad
                    $stmt = $conexion->prepare("UPDATE mesa_productos SET cantidad = cantidad + ? WHERE id_mesa = ? AND id_producto = ?");
                    $stmt->bind_param("iii", $cantidad, $id_mesa, $id_producto);
                    $stmt->execute();
                } else {
                    // No existe, insertar nuevo
                    $stmt = $conexion->prepare("INSERT INTO mesa_productos (id_mesa, id_producto, cantidad) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $id_mesa, $id_producto, $cantidad);
                    $stmt->execute();
                }

                // Descontar del stock en productos (ya no hay trigger)
                $stmt = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ? AND stock >= ?");
                $stmt->bind_param("iii", $cantidad, $id_producto, $cantidad);
                $stmt->execute();
            }

            $conexion->commit();
            return true;
        } catch (Exception $e) {
            $conexion->rollback();
            return false;
        }
    }
public static function cerrarConsumoMesa($idMesa) {
    $conexion = self::conectar();
    $stmt = $conexion->prepare("DELETE FROM mesa_productos WHERE id_mesa = ?");
    $stmt->bind_param("i", $idMesa);
    return $stmt->execute();
}

public static function obtenerConsumoMesa($idMesa) {
    $conexion = self::conectar();
    $sql = "SELECT p.nombre_producto, v.cantidad, p.precio
            FROM ventas v
            JOIN productos p ON v.id_producto = p.id_producto
            WHERE v.id_mesa = ? AND v.estado_de_factura = 'cerrado'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idMesa);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public static function guardarHistorialCuenta($idMesa, $productos, $total) {
    $conexion = self::conectar();
    $sql = "INSERT INTO historial_cuentas (id_mesa, detalles, total, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql);
    $detalles = json_encode($productos);
    $stmt->bind_param("isd", $idMesa, $detalles, $total);
    return $stmt->execute();
}
    public static function obtenerHistorialCuentas() {
    $conexion = self::conectar();
    $sql = "SELECT * FROM historial_cuentas ORDER BY fecha DESC";
    return $conexion->query($sql)->fetch_all(MYSQLI_ASSOC);
}
public static function obtenerTodasLasMesas() {
    $conexion = self::conectar();
    $sql = "SELECT * FROM mesas ORDER BY id_mesa ASC";
    return $conexion->query($sql)->fetch_all(MYSQLI_ASSOC) ?: [];
}
public static function buscarMesaPorNumero($numero_mesa) {
    $conexion = self::conectar();
    $stmt = $conexion->prepare("SELECT * FROM mesas WHERE numero_mesa = ?");
    $stmt->bind_param("i", $numero_mesa);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public static function agregarMesa($id_mesa, $nombre_mesa) {
    $conexion = self::conectar();
    $stmt = $conexion->prepare("INSERT INTO mesas (id_mesa, nombre_mesa) VALUES (?, ?)");
    $stmt->bind_param("is", $id_mesa, $nombre_mesa);
    return $stmt->execute();
}
// __________________________________________________________________________________



    public static function eliminarMesa($id_mesa) {
        $conexion = self::conectar();
        $consulta = $conexion->prepare("DELETE FROM mesas WHERE id_mesa = ?");
        $consulta->bind_param('i', $id_mesa);
        return $consulta->execute();
    }

    public static function mesaExiste($id_mesa) {
        $conexion = self::conectar();
        $consulta = $conexion->prepare("SELECT COUNT(*) FROM mesas WHERE id_mesa = ?");
        $consulta->bind_param('i', $id_mesa);
        $consulta->execute();
        $consulta->bind_result($count);
        $consulta->fetch();
        return $count > 0;
    }



    public static function actualizarMesa($id_mesa, $nombre_mesa) {
        $conexion = self::conectar();
        $consulta = $conexion->prepare("UPDATE mesas SET nombre_mesa = ? WHERE id_mesa = ?");
        $consulta->bind_param('si', $nombre_mesa, $id_mesa);
        return $consulta->execute();
    }

    public static function mesaTieneConsumo($id_mesa) {
        // Suponiendo que haya una tabla de pedidos/ventas con `id_mesa`
        $conexion = self::conectar();
        $consulta = $conexion->prepare("SELECT COUNT(*) FROM ventas WHERE id_mesa = ?");
        $consulta->bind_param('i', $id_mesa);
        $consulta->execute();
        $consulta->bind_result($count);
        $consulta->fetch();
        return $count > 0;
    }
    public static function registrarVentas($id_mesa, $productos) {
    $conexion = self::conectar();
    $todoBien = true;

    foreach ($productos as $producto) {
        $id_producto = $producto['id_producto'];
        $cantidad = $producto['cantidad'];
        $precio_unitario = $producto['precio'];

        $stmt = $conexion->prepare("INSERT INTO ventas (id_mesa, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_mesa, $id_producto, $cantidad, $precio_unitario);
        if (!$stmt->execute()) {
            $todoBien = false;
            break;
        }
    }

    return $todoBien;
}
}





