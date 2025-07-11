<?php
require_once __DIR__ . '/../config/Conexion_db.php';

class Estadisticas extends Conexion {

    public static function ventasDiariasUltimos7Dias() {
        $conexion = self::conectar();
        $query = "
            SELECT DATE(fecha_venta) as fecha, SUM(precio_unitario * cantidad) as total
            FROM ventas
            WHERE fecha_venta >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(fecha_venta)
            ORDER BY fecha ASC
        ";
        $resultado = $conexion->query($query);
        if (!$resultado) {
            error_log("Error en ventasDiariasUltimos7Dias: " . $conexion->error);
        }
        return $resultado;
    }

    public static function topProductosVendidos($limite = 5) {
        $conexion = self::conectar();
        $limite = intval($limite); // Sanear el input
        $query = "
            SELECT p.nombre_producto, SUM(v.cantidad) as total_vendido
            FROM ventas v
            JOIN productos p ON p.id_producto = v.id_producto
            GROUP BY v.id_producto
            ORDER BY total_vendido DESC
            LIMIT $limite
        ";
        $resultado = $conexion->query($query);
        if (!$resultado) {
            error_log("Error en topProductosVendidos: " . $conexion->error);
        }
        return $resultado;
    }

    public static function totalVentasPorMesa() {
        $conexion = self::conectar();
        $query = "
            SELECT m.nombre_mesa, SUM(v.precio_unitario * v.cantidad) as total
            FROM ventas v
            JOIN mesas m ON m.id_mesa = v.id_mesa
            GROUP BY v.id_mesa
        ";
        $resultado = $conexion->query($query);
        if (!$resultado) {
            error_log("Error en totalVentasPorMesa: " . $conexion->error);
        }
        return $resultado;
    }
}
