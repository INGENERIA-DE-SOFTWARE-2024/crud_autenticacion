<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\AplicacionController;
use Controllers\UsuarioController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

//Aplicación
$router->get('/', [AppController::class,'index']);
$router->get('/aplicacion', [AplicacionController::class, 'index']);
$router->post('/API/aplicacion/guardar', [AplicacionController::class, 'guardarAPI']);
$router->get('/API/aplicacion/buscar', [AplicacionController::class, 'buscarAPI']);
$router->post('/API/aplicacion/modificar', [AplicacionController::class, 'modificarAPI']);
$router->post('/API/aplicacion/eliminar', [AplicacionController::class, 'eliminarAPI']);

//Usuario
$router->get('/usuario', [UsuarioController::class, 'index']);
$router->post('/API/usuario/guardar', [UsuarioController::class, 'guardarAPI']);
$router->get('/API/usuario/buscar', [UsuarioController::class, 'buscarAPI']);
$router->post('/API/usuario/modificar', [UsuarioController::class, 'modificarAPI']);
$router->post('/API/usuario/eliminar', [UsuarioController::class, 'eliminarAPI']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
