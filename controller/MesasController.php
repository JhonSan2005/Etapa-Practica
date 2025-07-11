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

    public static function actualizarCarrito() {
        if (!isAuth()) {
            http_response_code(401);
            echo json_encode(["error" => "No autorizado"]);
            exit;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['id_mesa'], $input['productos']) || !is_array($input['productos'])) {
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos"]);
            exit;
        }

        $id_mesa = intval($input['id_mesa']);
        $productos = $input['productos'];

        $resultado = Mesas::guardarProductosConsumidos($id_mesa, $productos);

        if ($resultado) {
            echo json_encode(["success" => "Carrito actualizado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar el carrito"]);
        }
        exit;
    }
    public static function agregarConsumo() {
    if (!isAuth()) {
        return header("Location: /404");
    }

    $id_mesa = $_POST['id_mesa'] ?? null;
    $carrito_json = $_POST['carrito_json'] ?? null;

    if (!$id_mesa || !$carrito_json) {
        return header("Location: /mesas/detalle?id=" . $id_mesa);
    }

    $productos = json_decode($carrito_json, true);

    // Formatear para que encaje con el modelo
    $productosFormateados = [];
    foreach ($productos as $id => $item) {
        $productosFormateados[] = [
            'id_producto' => intval($id),
            'cantidad' => intval($item['cantidad'])
        ];
    }

    $resultado = Mesas::guardarProductosConsumidos($id_mesa, $productosFormateados);

    if ($resultado) {
        header("Location: /mesas/detalle?id=" . $id_mesa);
        exit;
    } else {
        echo "Hubo un error al guardar el consumo.";
    }
}
public static function cerrarCuenta($router) {
    $id = $_POST['id_mesa'] ?? null;

    if ($id && is_numeric($id)) {
        $productos = Mesas::obtenerProductosConsumidos($id);
        $total = 0;

        foreach ($productos as $p) {
            $total += $p['precio'] * $p['cantidad'];
        }

        $cerrado = Mesas::cerrarConsumoMesa($id);
        $historial = Mesas::guardarHistorialCuenta($id, $productos, $total);
        $registroVentas = Mesas::registrarVentas($id, $productos);

        if ($cerrado && $historial && $registroVentas) {
            echo 'ok'; // Todo salió bien
        } else {
            http_response_code(500);
            echo 'Error al cerrar cuenta';
        }
    } else {
        http_response_code(400);
        echo 'ID de mesa inválido';
    }
}

public static function vermesasAdmin(Router $router) {
    if (!isAuth()) {
        return header("Location: /404");
    }

    $mesas = Mesas::obtenerTodasLasMesas();

    $router->render("mesas/verMesasAdmin", [
        "title" => "Mesas - Admin",
        "mesas" => $mesas
    ]);
}
// _______________________________________________________________________________
public static function agregarMesa(Router $router) {
    if (!isAuth()) {
        header("Location: /");
        exit;
    }

    $alertas = new Alerta;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_mesa = filter_input(INPUT_POST, 'id_mesa', FILTER_SANITIZE_NUMBER_INT) ?? '';
        $nombre_mesa = filter_input(INPUT_POST, 'nombre_mesa', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

        $alertas->crearAlerta(empty($id_mesa), 'danger', 'El ID de la mesa no puede ir vacío');
        $alertas->crearAlerta(empty($nombre_mesa), 'danger', 'El nombre de la mesa no puede ir vacío');

        if (!$alertas->obtenerAlertas()) {
            $resultado = Mesas::agregarMesa($id_mesa, $nombre_mesa);

            if (!$resultado) {
                $alertas->crearAlerta(true, 'danger', 'Error al agregar la mesa');
            } else {
                // ✅ Redirigir
                header("Location: /admin/verMesasAdmin");
                exit;
            }
        }
    }

    $mesas = Mesas::obtenerTodasLasMesas();
    $alertas = $alertas->obtenerAlertas();

    $router->render('mesas/agregarMesaAdmin', [
        "title" => "Agregar Mesa",
        "mesas" => $mesas,
        "alertas" => $alertas
    ]);
}

    public static function eliminarMesaAdmin(Router $router) {
        if (!isAuth()) {
            return header("Location: /404");
        }

        $id_mesa = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? null;

        if ($id_mesa === null) {
            return header("Location: /404");
        }

        $mesaConConsumo = Mesas::mesaTieneConsumo($id_mesa); // Debes tener esta función en el modelo

        if ($mesaConConsumo) {
            $error = "La mesa no se puede eliminar porque tiene consumo registrado.";
        } else {
            $resultado = Mesas::eliminarMesa($id_mesa);

            if ($resultado === false) {
                $error = "Error al eliminar la mesa.";
            } else {
                $error = null;
            }
        }

        $mesas = Mesas::obtenerTodasLasMesas();

        $router->render("mesas/verMesasAdmin", [
            "title" => "Administrar Mesas",
            "mesas" => $mesas,
            "error" => $error
        ]);
    }

    public static function actualizarMesa(Router $router) {
        if (!isAuth()) {
            header("Location: /");
            exit;
        }

        $id_mesa = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? '';
        $resultado = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero_mesa = filter_input(INPUT_POST, 'numero_mesa', FILTER_SANITIZE_NUMBER_INT) ?? '';

            if (!Mesas::mesaExiste($id_mesa)) {
                $router->render('mesas/actualizarMesa', [
                    'title' => 'Mesa no encontrada',
                    'resultado' => 'Error: La mesa especificada no existe.',
                    'mesas' => Mesas::obtenerTodasLasMesas()
                ]);
                return;
            }

            $resultado = Mesas::actualizarMesa($id_mesa, $numero_mesa);
            header('Location: /admin/mesas');
            exit;
        } else {
            $mesa = Mesas::buscarPorId($id_mesa);

            if (!is_array($mesa)) {
                $router->render('mesas/actualizarMesa', [
                    'title' => 'Mesa no encontrada',
                    'resultado' => 'Error: La mesa no fue encontrada.',
                    'mesas' => Mesas::obtenerTodasLasMesas()
                ]);
                return;
            }

            $router->render('mesas/actualizarMesa', [
                'title' => 'Actualizar Mesa',
                'resultado' => $resultado,
                'mesa' => $mesa,
                'mesas' => Mesas::obtenerTodasLasMesas()
            ]);
        }
    }


}




