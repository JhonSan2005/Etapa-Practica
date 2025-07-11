<?php

require_once __DIR__ . "/../Router.php";
require_once __DIR__ . '/../model/Estadisticas.php';
require_once __DIR__ . "/../model/mesas.php";

class DashboardController {

    public static function index( Router $router ) {

        $router->render('dashboard/dashboard', [
            "title" => "Dashboard"
        ]);

    }
    public static function tablaUser( Router $router ) {

        $router->render('dashboard/tablaUser', [
            "title" => "Dashboard"
        ]);

    }
    public static function historialCuentas(Router $router) {
    $historial = Mesas::obtenerHistorialCuentas();
    $router->render("dashboard/cuentasCerradas", [
        "title" => "Historial de Cuentas",
        "historial" => $historial
    ]);
}


public static function graficas(Router $router) {
    $ventasDiarias = Estadisticas::ventasDiariasUltimos7Dias();
    $topProductos = Estadisticas::topProductosVendidos();
    $ventasPorMesa = Estadisticas::totalVentasPorMesa();

    $router->render('dashboard/graficas', [
        "title" => "Gráficas",
        "ventasDiarias" => $ventasDiarias,
        "topProductos" => $topProductos,
        "ventasPorMesa" => $ventasPorMesa
    ]);
}




    
    

}

?>