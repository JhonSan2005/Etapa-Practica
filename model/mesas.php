<?php

require_once __DIR__ . '/../config/Conexion_db.php';

class Mesas extends Conexion{
   public static function obtenerMesas()
{
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
    $sql = "SELECT p.nombre_producto, p.precio, mp.cantidad 
            FROM mesa_productos mp 
            JOIN productos p ON mp.id_producto = p.id_producto 
            WHERE mp.id_mesa = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_mesa);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



}