<?php

namespace Controllers;

use Exception;
use Model\Permiso;
use MVC\Router;

class PermisoController
{
    public static function index(Router $router)
    {
        $permiso = Permiso::find(2); // Cambiado a buscar un permiso
        $router->render('permiso/index', [
            'permiso' => $permiso
        ]);
    }

    public static function guardarAPI()
    {
        
        $_POST['permiso_usuario'] = filter_var($_POST['permiso_usuario'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['permiso_rol'] = filter_var($_POST['permiso_rol'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $permiso = new Permiso($_POST);    
            $resultado = $permiso->crear();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permiso guardado exitosamente',
            ]);
        } catch (Exception $e) {
           
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar permiso',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function buscarAPI()
    {
        try {
            $permisos = Permiso::obtenerPermisosconQuery(); 
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Datos encontrados',
                'detalle' => '',
                'datos' => $permisos
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al buscar permisos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        $_POST['permiso_usuario'] = filter_var($_POST['permiso_usuario'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['permiso_rol'] = filter_var($_POST['permiso_rol'], FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($_POST['permiso_id'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $permiso = Permiso::find($id);
            $permiso->sincronizar($_POST);
            $permiso->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permiso modificado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar permiso',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        $id = filter_var($_POST['permiso_id'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $permiso = Permiso::find($id);
            $permiso->sincronizar([
                'permiso_situacion' => 0
                 ]);

               $permiso->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permiso eliminado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar permiso',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
