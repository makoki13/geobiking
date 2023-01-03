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

    public static function get_provincias_visitadas($conexion,$usuario) {
        $sql="select distinct provincia from localidades l inner join usuarios_registro ur on l.id = ur.localidad where ur.usuario=$usuario";
        $reg = db_get_tabla($conexion,$sql,$filas);
        return $filas;
    }

    public static function get_total_numero_provincias($conexion) {
        $sql="select count(*) from provincias";
        return db_get_dato($conexion,$sql);
    }

    public static function get_autonomias_visitadas($conexion,$usuario) {
        $sql="
            select distinct autonomia 
            from provincias p inner join localidades l on l.provincia = p.id inner join usuarios_registro ur on l.id = ur.localidad 
            where ur.usuario=$usuario
        ";
        $reg = db_get_tabla($conexion,$sql,$filas);
        return $filas;
    }

    public static function get_total_numero_autonomias($conexion) {
        $sql="select count(*) from autonomias";
        return db_get_dato($conexion,$sql);
    }

    /* POR LOCALIDADES */

    private static function objetivo_una_localidad_visitada($conexion, $usuario) {
        //echo "executing objetivo_una_localidad_visitada\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 1;
    }

    private static function objetivo_dos_localidades_visitadas($conexion,$usuario) {
        return self::get_localidades_visitadas($conexion, $usuario) >= 2;
    }

    private static function objetivo_cinco_localidades_visitadas($conexion,$usuario) {
        return self::get_localidades_visitadas($conexion, $usuario) >= 5;
    }

    private static function objetivo_diez_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 10;
    }

    private static function objetivo_50_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 50;
    }

    private static function objetivo_100_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 100;
    }

    private static function objetivo_200_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 200;
    }

    private static function objetivo_500_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 500;
    }

    private static function objetivo_1000_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 1000;
    }

    private static function objetivo_2000_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 2000;
    }

    private static function objetivo_5000_localidades_visitadas($conexion,$usuario) {
        //echo "executing objetivo_cinco_localidades_visitadas\n";
        return self::get_localidades_visitadas($conexion, $usuario) >= 5000;
    }

    private static function objetivo_todas_las_localidades_visitadas($conexion,$usuario) {
        return self::get_localidades_visitadas($conexion, $usuario) == self::get_total_numero_localidades($conexion);
    }

    /* POR PROVINCIAS */

    private static function objetivo_dos_provincias_visitadas($conexion,$usuario) {
        return self::get_provincias_visitadas($conexion, $usuario) >= 2;
    }

    /* POR COMUNIDADES AUTONOMAS */
    private static function objetivo_dos_comunidades_autonomas_visitadas($conexion,$usuario) {
        return self::get_autonomias_visitadas($conexion, $usuario) >= 2;
    }


    /* FUNCIONES PUBLICAS */

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
            $reg->conseguido = false;
            if ($resultado === true) {                
                $reg->conseguido = true;
            }
            $logros[] = $reg;
        }

        $total_puntos = 0;
        if (count($logros) > 0) foreach($logros as $logro) {
            if ($logro->conseguido== true) {
                $total_puntos += $logro->puntos;
            }
        }

        //var_dump($logros);

        return array("logros" => $logros, "total_puntos" => $total_puntos);
    }
}