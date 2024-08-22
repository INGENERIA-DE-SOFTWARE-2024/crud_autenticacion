<?php

namespace Controllers;

use Exception;
use Model\Rol;
use MVC\Router;

class RolController
{
    public static function index(Router $router)
    {

        $rol = Rol::find(2);
        $router->render('rol/index', [
            'rol' => $rol
        ]);
    }

    public static function guardarAPI()
    {
        // Sanitizar el nombre del usuario
        $_POST['rol_nombre'] = htmlspecialchars($_POST['rol_nombre']);
    
        try {
            $rol = new Rol($_POST);    
            $resultado = $rol->crear();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Rol guardado exitosamente',
            ]);
        } catch (Exception $e) {
            // Responder con un error si ocurre una excepción
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar rol',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function buscarAPI()
    {
        try {
            $roles = Rol::obtenerRolesconQuery();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Datos encontrados',
                'detalle' => '',
                'datos' => $roles
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al buscar roles',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        $_POST['rol_nombre'] = htmlspecialchars($_POST['rol_nombre']);
        
        $id = filter_var($_POST['rol_id'], FILTER_SANITIZE_NUMBER_INT);
        try {
            $rol = Rol::find($id);
            $rol->sincronizar($_POST);
            $rol->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Rol modificado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar usuario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        $id = filter_var($_POST['rol_id'], FILTER_SANITIZE_NUMBER_INT);
        try {

            $rol = Rol::find($id);
            $rol->sincronizar([
                'rol_situacion' => 0
                 ]);

                 $rol->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Rol eliminado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar rol',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
