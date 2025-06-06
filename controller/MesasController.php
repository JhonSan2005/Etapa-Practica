<?php

require_once __DIR__ . "/../Router.php";
require_once __DIR__ . "/../model/Mesas.php";
require_once __DIR__ . "/../model/Category.php";
require_once __DIR__ . "/../model/Usuario.php";
require_once __DIR__ . "/../helpers/functions.php";

class MesasController {
    public static function verMesas(Router $router) {
        if (!isAuth()) {
            return header("Location: /404");
        }

        $mesas = Mesas::obtenerMesas();

        $router->render("mesas/verMesas", [
            "title" => "Mesas",
            "mesas" => $mesas
        ]);
  }

public static function detalleMesa(Router $router) {
    if (!isAuth()) {
        return header("Location: /404");
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        return header("Location: /mesas");
    }

    $mesa = Mesas::buscarPorId($id);
    $productosDisponibles = Mesas::obtenerProductosDisponibles();
    $productosConsumidos = Mesas::obtenerProductosConsumidos($id);

    $router->render("mesas/detalle", [
        "mesa" => $mesa,
        "productosDisponibles" => $productosDisponibles,
        "productosConsumidos" => $productosConsumidos
   ]);
}

}

