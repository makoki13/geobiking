<?php

include_once 'basededatos.php';

class Usuario {
    public static function get_nombre($conexion,$usuario) {
        $sql="select nombre from usuarios where id = $usuario";
        return db_get_dato($conexion,$sql);
    }

    public static function get_datos($conexion,$usuario) {
        $sql="select * from usuarios where id = $usuario";        
        $registro = db_get_tabla($conexion,$sql,$filas);

        $nombre = pg_result($registro,0,'nombre');        
        $fecha_alta = pg_result($registro,0,'fecha_alta');
        $ultima_actualizacion = pg_result($registro,0,'ultima_actualizacion');

        $datos = new stdClass();
        $datos->id = $usuario;
        $datos->nombre = $nombre;
        $datos->fecha_alta = $fecha_alta;
        $datos->ultima_actualizacion = $ultima_actualizacion;

        return $datos;
    }
}