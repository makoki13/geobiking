<?php

include_once 'basededatos.php';

class Usuario {
    public static function get_nombre($conexion,$usuario) {
        $sql="select nombre from usuarios where id = $usuario";
        return db_get_dato($conexion,$sql);
    }
}