<?php

require_once __DIR__ . "/../Router.php";
require_once __DIR__ . "/../model/Category.php";
require_once __DIR__ . "/../helpers/functions.php";

class CategoryController {

    public static function index(Router $router) {
        $isAuth = isAuth();

        if (!$isAuth) {
            return header("Location: /");
        }

        $categories = Category::verCategorias();

        $router->render('categories/verCategorias', [
            "title" => "Categorías",
            "categories" => $categories
        ]);
    }

    public static function agregarcategoria(Router $router) {
        if (!isAuth()) {
            header("Location: /");
            exit;
        }

        $alertas = new Alerta;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
            $nombre_categoria = filter_input(INPUT_POST, 'nombre_categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

            $alertas->crearAlerta(empty($id_categoria), 'danger', 'El ID no puede ir vacío');
            $alertas->crearAlerta(empty($nombre_categoria), 'danger', 'El nombre no puede ir vacío');

            if (!$alertas->obtenerAlertas()) {
                $resultado = Category::agregarcategorias($id_categoria, $nombre_categoria);

                if (!$resultado) {
                    $alertas->crearAlerta(true, 'danger', 'Error al agregar la categoría');
                } else {
                    $alertas->crearAlerta(false, 'success', 'Categoría agregada exitosamente');
                    // Puedes redirigir a la vista de categorías si lo deseas
                    // header("Location: /admin/categories");
                }
            }
        }

        $categories = Category::verCategorias();
        $alertas = $alertas->obtenerAlertas();

        $router->render('categories/agregarCategoria', [
            "title" => "Agregar Categoria",
            "categories" => $categories
        ]);
    }

    public static function verCategorias(Router $router) {
        $isAuth = isAuth();

        if (!$isAuth) {
            return header("Location: /404");
        }

        $categorias = Category::verCategorias();

        $router->render("categories/verCategorias", [
            "title" => "Administrar Categorías",
            "categorias" => $categorias
        ]);
    }
    public static function eliminarCategoriaAdmin(Router $router) {
        if (!isAuth()) {
            return header("Location: /404");
        }
    
        $id_categoria = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? null;
    
        if ($id_categoria === null) {
            return header("Location: /404");
        }
    
        $tieneProductos = Category::tieneProductos($id_categoria);
    
        if ($tieneProductos) {
            $error = "La categoría no se puede eliminar porque tiene productos asociados.";
        } else {
            $resultado = Category::eliminarCategoriaAdmin($id_categoria);
    
            if ($resultado === false) {
                $error = "Error al eliminar la categoría.";
            } else {
                $error = null; // La eliminación fue exitosa
            }
        }
    
        $categorias = Category::verCategorias();
    
        $router->render("categories/verCategorias", [
            "title" => "Administrar Categorías",
            "categorias" => $categorias,
            "error" => $error
        ]);
    }
    
    
    
    public static function actualizarCategoria(Router $router) {
        if (!isAuth()) {
            header("Location: /");
            exit;
        }
    
        $id_categoria = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? '';
        $resultado = '';
    
        // Si el método de solicitud es POST, se actualiza la categoría
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_categoria = filter_input(INPUT_POST, 'nombre_categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    
            // Verificar si la categoría existe
            if (!Category::categoriaExiste($id_categoria)) {
                $router->render('categories/actualizarCategoria', [
                    'title' => 'Categoría no encontrada',
                    'resultado' => 'Error: La categoría especificada no existe.',
                    'categorias' => Category::verCategorias() // Pasar las categorías al formulario
                ]);
                return;
            }
    
            // Actualizar la categoría y redirigir
            $resultado = Category::actualizarCategoria($id_categoria, $nombre_categoria);
            header('Location: /admin/categories'); // Redirigir a la página de administración después de actualizar
            exit;
        } else {
            // Cargar la categoría para mostrarla en el formulario
            $categoria = Category::encontrarCategoria($id_categoria);
    
            if (!is_array($categoria)) {
                $router->render('categories/actualizarCategoria', [
                    'title' => 'Categoría no encontrada',
                    'resultado' => 'Error: La categoría no fue encontrada.',
                    'categorias' => Category::verCategorias() // Pasar las categorías al formulario
                ]);
                return;
            }
    
            $router->render('categories/actualizarCategoria', [
                'title' => 'Actualizar Categoría',
                'resultado' => $resultado,
                'categoria' => $categoria,
                'categorias' => Category::verCategorias() // Pasar las categorías al formulario
            ]);
        }
    }
    

    
    
}
?>
