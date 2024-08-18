<?php

namespace Controllers;

use Exception;
use Model\Aplicacion;
use MVC\Router;

class AplicacionController
{
    public static function index(Router $router)
    {
        $aplicaciones = Aplicacion::find(2);
        $router->render('aplicacion/index', [
            'aplicaciones' => $aplicaciones
        ]);
    }

    public static function guardarAPI()
    {
        $_POST['app_nombre'] = htmlspecialchars($_POST['app_nombre']);
        try {
            $aplicacion = new Aplicacion($_POST);
            $resultado = $aplicacion->crear();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Aplicación guardado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar aplicación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            // ORM - ELOQUENT
            // $productos = Producto::all();
            $aplicaciones = Aplicacion::obtenerAplicacionesconQuery();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Datos encontrados',
                'detalle' => '',
                'datos' => $aplicaciones
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al buscar aplicaciones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        $_POST['app_nombre'] = htmlspecialchars($_POST['app_nombre']);
        $id = filter_var($_POST['app_id'], FILTER_SANITIZE_NUMBER_INT);
        try {

            $aplicacion = Aplicacion::find($id);
            $aplicacion->sincronizar($_POST);
            $aplicacion->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Aplicación modificado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar aplicación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {

        $id = filter_var($_POST['app_id'], FILTER_SANITIZE_NUMBER_INT);
        try {

            $aplicacion = Aplicacion::find($id);
            // $producto->sincronizar([
            //     'situacion' => 0
            // ]);
            // $producto->actualizar();
            $aplicacion->eliminar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Aplicación eliminado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminado aplicación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
