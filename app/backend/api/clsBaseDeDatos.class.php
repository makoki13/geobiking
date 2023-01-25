<?php

class BaseDeDatos {
    public static $conexion = null;
        
    public static function get_nueva_conexion() {
        if (self::$conexion!=null) {
            return  self::$conexion;
        }

        $cadena_conexion = "host=rtexa3j8.instances.spawn.cc port=32068 dbname=foobardb user=spawn_admin_cBuT password=J0XccA3aXpL8T9qz connect_timeout=5";
        self::$conexion = pg_connect($cadena_conexion, PGSQL_CONNECT_FORCE_NEW);
        return self::$conexion;
    }

    public static function get_conexion() {
        if (self::$conexion==null) {
            return self::get_nueva_conexion();
        }

        return self::$conexion;
    }

    public static function transaccion_begin() {
        self::db_actualiza("BEGIN");
    }

    public static function transaccion_end() {
        self::db_actualiza("END");
    }

    public static function transaccion_rollback() {
        self::db_actualiza("ROLLBACK");
    }

    public static function db_get_dato($sql) {
        $reg = @pg_query(self::$conexion,$sql);
        if ($reg ===  false) return false;
        $filas = @pg_num_rows($reg);
        if ($filas == 0) return false;
        $valor = pg_result($reg,0,0);    
        return $valor;
    }

    public static function db_inserta($sql) {
        return pg_query(self::$conexion,$sql);
    }

    public static function db_actualiza($sql) {
        return db_inserta(self::$conexion,$sql);
    }

    public static function db_get_registro($sql) {
        $reg = @pg_query(self::$conexion,$sql);
        if ($reg === false) return false;
        return $reg;    
    }

    public static function get_campo($reg, $indice) {
        return pg_result($reg,0,$indice);
    }

    public static function get_valor($reg, $indice, $campo) {
        return pg_result($reg,$indice,$campo);
    }

    public static function db_get_tabla($sql,&$filas) {
        $reg = @pg_query(self::$conexion,$sql);    
        if ($reg === false) return false;
        $filas = @pg_num_rows($reg);
        return $reg;    
    }

    public static function libera_conexion() {
        pg_close(self::$conexion);
    }
}