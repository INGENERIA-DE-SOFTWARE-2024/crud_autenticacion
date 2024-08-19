<?php

namespace Model;

class Permiso extends ActiveRecord
{
    
    protected static $tabla = 'permiso';
    protected static $idTabla = 'permiso_id';
    protected static $columnasDB = ['permiso_usuario', 'permiso_rol', 'permiso_situacion'];

    public $permiso_id;
    public $permiso_usuario;
    public $permiso_rol;
    public $permiso_situacion;

    // Constructor para inicializar los valores del objeto
    public function __construct($args = [])
    {
        $this->permiso_id = $args['permiso_id'] ?? null;
        $this->permiso_usuario = $args['permiso_usuario'] ?? null;
        $this->permiso_rol = $args['permiso_rol'] ?? null;
        $this->permiso_situacion = $args['permiso_situacion'] ?? 1;
    }

    // Método para obtener las aplicaciones activas (situación = 1)
    public static function obtenerPermisosconQuery()
    {
        $sql = "SELECT 
    p.permiso_id,
    u.usu_nombre AS nombre_usuario,
    r.rol_nombre AS nombre_rol,
    p.permiso_situacion
FROM 
    permiso p
LEFT JOIN 
    usuario u ON p.permiso_usuario = u.usu_id
LEFT JOIN 
    rol r ON p.permiso_rol = r.rol_id
WHERE 
    p.permiso_situacion = 1;
";

        return self::fetchArray($sql);
    }

}



