<?php

include_once 'basededatos.php';

class Estadisticas {
    public static function get_localidades_visitadas($conexion, $usuario) {
        $sql="select count(*) from usuarios_registro where usuario = $usuario";
        return db_get_dato($conexion,$sql);
    }

    public static function get_total_numero_localidades($conexion) {
        $sql="select sum(poblaciones) from provincias";
        return db_get_dato($conexion,$sql);
    }

    public static function objetivo_una_localidad_visitada($conexion, $usuario) {
        //echo "executing objetivo_una_localidad_visitada\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 1;
    }

    public static function objetivo_dos_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_dos_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 2;
    }

    public static function objetivo_cinco_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 5;
    }

    public static function objetivo_diez_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 10;
    }

    public static function get($conexion,$usuario) {
        $v = $logros = array();

        //obtener la lista de logros
        $sql="select * from logros order by id";
        $lista = db_get_tabla($conexion,$sql, $filas);
        if ($filas > 0) {            
            for ($i=0; $i < $filas; $i++) {
                $o = new stdClass();
                $o->id = pg_result($lista,$i,'id');
                $o->nombre = pg_result($lista,$i,'nombre');
                $o->tipo = pg_result($lista,$i,'tipo');
                $o->logo = pg_result($lista,$i,'logo');
                $o->comando = pg_result($lista,$i,'comando');
                $o->puntos = pg_result($lista,$i,'puntos');
                                
                $v[] = $o;
            }
        }

        if (count($v) > 0) foreach($v as $reg) {
            $comando = $reg->comando;
            $resultado = call_user_func("Estadisticas::" . $comando, $conexion, $usuario);
            if ($resultado === true) {
                $logros[] = $reg;
            }
        }

        $total_puntos = 0;
        if (count($logros) > 0) foreach($logros as $logro) {
            $total_puntos += $logro->puntos;
        }

        return array("logros" => $logros, "total_puntos" => $total_puntos);
    }
}