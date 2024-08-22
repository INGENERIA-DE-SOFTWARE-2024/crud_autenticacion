<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;

class UsuarioController
{
    public static function index(Router $router)
    {

        $usuario = Usuario::find(2);
        $router->render('usuario/index', [
            'usuario' => $usuario
        ]);
    }

    public static function guardarAPI()
    {
        // Sanitizar el nombre del usuario
        $_POST['usu_nombre'] = htmlspecialchars($_POST['usu_nombre']);
    
        // Hashear la contraseña antes de crear el usuario
        if (isset($_POST['usu_password']) && !empty($_POST['usu_password'])) {
            $_POST['usu_password'] = password_hash($_POST['usu_password'], PASSWORD_BCRYPT);
        } else {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La contraseña es requerida',
            ]);
            return;
        }
    
        try {
            // Crear el usuario con los datos del formulario
            $usuario = new Usuario($_POST);
    
            // Guardar el usuario en la base de datos
            $resultado = $usuario->crear();
    
            // Responder con éxito
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuario guardado exitosamente',
            ]);
        } catch (Exception $e) {
            // Responder con un error si ocurre una excepción
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar usuario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function buscarAPI()
    {
        try {
            $usuarios = Usuario::obtenerUsuariosActivos();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Datos encontrados',
                'detalle' => '',
                'datos' => $usuarios
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al buscar usuarios',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        $_POST['usu_nombre'] = htmlspecialchars($_POST['usu_nombre']);
        $id = filter_var($_POST['usu_id'], FILTER_SANITIZE_NUMBER_INT);
        try {
            $usuario = Usuario::find($id);
            $usuario->sincronizar($_POST);
            $usuario->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuario modificado exitosamente',
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
        $id = filter_var($_POST['usu_id'], FILTER_SANITIZE_NUMBER_INT);
        try {

            $usuario = Usuario::find($id);
            $usuario->sincronizar([
                'usu_situacion' => 0
                 ]);
                 
                 $usuario->actualizar();
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuario eliminado exitosamente',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar usuario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}
