<?php

namespace Model;

class Aplicacion extends ActiveRecord
{
    
    protected static $tabla = 'aplicacion';
    protected static $idTabla = 'app_id';
    protected static $columnasDB = ['app_nombre', 'app_situacion'];

    public $app_id;
    public $app_nombre;
    public $app_situacion;

    // Constructor para inicializar los valores del objeto
    public function __construct($args = [])
    {
        $this->app_id = $args['app_id'] ?? null;
        $this->app_nombre = $args['app_nombre'] ?? '';
        $this->app_situacion = $args['app_situacion'] ?? 1;
    }

    // Método para obtener las aplicaciones activas (situación = 1)
    public static function obtenerAplicacionesconQuery()
    {
        $sql = "SELECT * FROM " . self::$tabla . " WHERE app_situacion = 1";
        return self::fetchArray($sql);
    }

}



