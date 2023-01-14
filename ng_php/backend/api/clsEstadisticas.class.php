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

    public static function get_autonomias_peninsulares_visitadas($conexion,$usuario) {
        $sql="
            select distinct autonomia 
            from provincias p inner join localidades l on l.provincia = p.id inner join usuarios_registro ur on l.id = ur.localidad 
            where ur.usuario=$usuario and not autonomia in (8,12,18,19)
        ";
        $reg = db_get_tabla($conexion,$sql,$filas);
        return $filas;
    }

    public static function get_autonomias_insulares_visitadas($conexion,$usuario) {
        $sql="
            select distinct autonomia 
            from provincias p inner join localidades l on l.provincia = p.id inner join usuarios_registro ur on l.id = ur.localidad 
            where ur.usuario=$usuario and autonomia in (8,12)
        ";
        $reg = db_get_tabla($conexion,$sql,$filas);
        return $filas;
    }

    public static function get_total_numero_autonomias($conexion) {
        $sql="select count(*) from autonomias";
        return db_get_dato($conexion,$sql);
    }

    public static function get_total_numero_autonomias_peninsulares($conexion) {
        $sql="select count(*) from autonomias where not id in (8,12,18,19)";
        return db_get_dato($conexion,$sql);
    }

    public static function get_total_numero_autonomias_insulares($conexion) {
        $sql="select count(*) from autonomias where id in (8,12)";
        return db_get_dato($conexion,$sql);
    }

    public static function autonomia_esta_visitada($conexion,$usuario,$autonomia) {
        $sql="
            select distinct autonomia 
            from provincias p inner join localidades l on l.provincia = p.id inner join usuarios_registro ur on l.id = ur.localidad 
            where ur.usuario=$usuario and autonomia=$autonomia
        ";
        $reg = db_get_tabla($conexion,$sql,$filas);
        return $filas > 0;
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

    private static function objetivo_cinco_provincias_visitadas($conexion,$usuario) {
        return self::get_provincias_visitadas($conexion, $usuario) >= 5;
    }

    private static function objetivo_diez_provincias_visitadas($conexion,$usuario) {
        return self::get_provincias_visitadas($conexion, $usuario) >= 10;
    }

    private static function objetivo_provincia_25_por_cien_visitadas($conexion,$usuario) {
        return self::get_provincias_visitadas($conexion, $usuario) >= 25;
    }

    private static function objetivo_todas_provincias_visitadas($conexion,$usuario) {
        return self::get_provincias_visitadas($conexion, $usuario) == self::get_total_numero_provincias($conexion);
    }

    /* POR COMUNIDADES AUTONOMAS */
    private static function objetivo_dos_comunidades_autonomas_visitadas($conexion,$usuario) {
        return self::get_autonomias_visitadas($conexion, $usuario) >= 2;
    }

    private static function objetivo_cinco_comunidades_autonomas_visitadas($conexion,$usuario) {
        return self::get_autonomias_visitadas($conexion, $usuario) >= 5;
    }

    private static function objetivo_diez_comunidades_autonomas_visitadas($conexion,$usuario) {
        return self::get_autonomias_visitadas($conexion, $usuario) >= 10;
    }

    private static function objetivo_todas_comunidades_autonomas_peninsulares_visitadas($conexion,$usuario) {
        return self::get_autonomias_peninsulares_visitadas($conexion, $usuario) == self::get_total_numero_autonomias_peninsulares($conexion);
    }

    private static function objetivo_1_autonomia_insular_visitada($conexion,$usuario) {
        return self::get_autonomias_insulares_visitadas($conexion, $usuario) > 0;
    }

    private static function objetivo_todas_autonomias_insulares_visitadas($conexion,$usuario) {
        return self::get_autonomias_insulares_visitadas($conexion, $usuario) == self::get_total_numero_autonomias_insulares($conexion);
    }

    private static function objetivo_ceuta_visitada($conexion,$usuario) {
        return self::autonomia_esta_visitada($conexion, $usuario,18);
    }

    private static function objetivo_melilla_visitada($conexion,$usuario) {
        return self::autonomia_esta_visitada($conexion, $usuario,19);
    }

    private static function objetivo_ceuta_y_melilla_visitadas($conexion,$usuario) {
        return self::autonomia_esta_visitada($conexion, $usuario,18) && self::autonomia_esta_visitada($conexion, $usuario,19);
    }

    /* POR CADA PROVINCIA */
    private static function get_poblaciones_de_provincia_visitadas($conexion,$usuario,$provincia) {
        $sql="select count(*) from usuarios_registro where usuario=$usuario and localidad in (select id from localidades where provincia=$provincia)";
        return db_get_dato($conexion,$sql);
    }

    private static function get_poblaciones_de_provincia($conexion,$provincia) {
        $sql="select poblaciones from provincias where id=$provincia";
        return db_get_dato($conexion,$sql);
    }

    private static function provincia_10_por_cien_visitado($conexion,$usuario,$provincia) {
        $poblaciones_visitadas = self::get_poblaciones_de_provincia_visitadas($conexion,$usuario,$provincia);
        $poblaciones_totales = self::get_poblaciones_de_provincia($conexion,$provincia);
        $porcentaje = 0;
        if ($poblaciones_totales > 0) {
            $porcentaje = $poblaciones_visitadas / $poblaciones_totales;
        }
        
        return $porcentaje >= 0.1;
    }

    private static function provincia_25_por_cien_visitado($conexion,$usuario,$provincia) {
        $poblaciones_visitadas = self::get_poblaciones_de_provincia_visitadas($conexion,$usuario,$provincia);
        $poblaciones_totales = self::get_poblaciones_de_provincia($conexion,$provincia);
        $porcentaje = 0;
        if ($poblaciones_totales > 0) {
            $porcentaje = $poblaciones_visitadas / $poblaciones_totales;
        }
        
        return $porcentaje >= 0.25;
    }

    /* POR CADA AUTONOMIA */
    private static function get_poblaciones_de_autonomia_visitadas($conexion,$usuario,$autonomia) {
        $sql="
            select count(*) 
            from usuarios_registro 
            where 
                usuario=$usuario and 
                localidad in 
                    (
                        select id from localidades where provincia in 
                            (
                                select id from provincias where autonomia=$autonomia
                            )
                    )
        ";
        return db_get_dato($conexion,$sql);
    }

    private static function get_poblaciones_de_autonomia($conexion,$autonomia) {
        $sql="select sum(poblaciones) from provincias where autonomia=$autonomia";
        return db_get_dato($conexion,$sql);
    }

    private static function objetivo_autonomia_10_por_cien_visitado($conexion,$usuario,$autonomia) {
        $poblaciones_visitadas = self::get_poblaciones_de_autonomia_visitadas($conexion,$usuario,$autonomia);
        $poblaciones_totales = self::get_poblaciones_de_autonomia($conexion,$autonomia);
        $porcentaje = 0;
        if ($poblaciones_totales > 0) {
            $porcentaje = $poblaciones_visitadas / $poblaciones_totales;
        }
        
        return $porcentaje >= 0.1;
    }

    private static function objetivo_autonomia_25_por_cien_visitado($conexion,$usuario,$autonomia) {
        $poblaciones_visitadas = self::get_poblaciones_de_autonomia_visitadas($conexion,$usuario,$autonomia);
        $poblaciones_totales = self::get_poblaciones_de_autonomia($conexion,$autonomia);
        $porcentaje = 0;
        if ($poblaciones_totales > 0) {
            $porcentaje = $poblaciones_visitadas / $poblaciones_totales;
        }
        
        return $porcentaje >= 0.25;
    }



    /* FUNCIONES PUBLICAS */

    public static function get($conexion,$usuario,$sql) {
        $v = $logros = array();

        //obtener la lista de logros
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
            $resultado = call_user_func("Estadisticas::" . $comando, $conexion, $usuario, $provincia);            
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

        return array("logros" => $logros, "total_puntos" => $total_puntos);
    }

    public static function get_global($conexion,$usuario) {
        $sql="select * from logros order by id";        
        return self::get($conexion,$usuario,$sql);
    }
 
    public static function get_general($conexion,$usuario) {
        $sql="select * from logros where tipo in (1,3,5) order by id";
        return self::get($conexion,$usuario,$sql);

        $v = $logros = array();

        //obtener la lista de logros
        
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

    public static function get_provinciales($conexion,$usuario) {
        $v = array();
        $sql="select id,nombre from autonomias";
        $autonomias = db_get_tabla($conexion,$sql,$filas);
        for($i=0; $i < $filas; $i++) {
            $o = new stdClass();
            $o->id_autonomia = pg_result($autonomias,$i,'id');
            $o->nombre_autonomia = pg_result($autonomias,$i,'nombre');
            
            $sql="select id,nombre from provincias where autonomia=" . $o->id_autonomia;
            $provincias = db_get_tabla($conexion,$sql,$filas_provincias);
            $o->provincias = array();
            //echo "filas provincias: $filas_provincias<br>";
            for($j=0; $j < $filas_provincias; $j++) {
                $p = new stdClass();
                $p->id_provincia = pg_result($provincias,$j,'id');
                $p->nombre_provincia = pg_result($provincias,$j,'nombre');
                
                $p->poblaciones = self::get_poblaciones_de_provincia($conexion,$p->id_provincia);
                $p->visitadas = self::get_poblaciones_de_provincia_visitadas($conexion,$usuario,$p->id_provincia);
                $p->porcentaje = 0;
                if ($p->poblaciones > 0) {
                    $p->porcentaje = number_format( ($p->visitadas / $p->poblaciones) * 100, 2, ",", "") ;
                }

                $logro = new stdClass();
                $logro->id = 13;
                $logro->nombre = "10 % visitado";
                $logro->tipo = 2;                
                $logro->logo = "img_13";                
                $logro->comando = "provincia_10_por_cien_visitado";
                $logro->puntos = 100;
                $resultado = Estadisticas::provincia_10_por_cien_visitado( $conexion, $usuario, $p->id_provincia);
                $logro->conseguido = false;
                if ($resultado === true) {                
                    $logro->conseguido = true;
                }                
                $p->logros[] = $logro;

                $logro = new stdClass();
                $logro->id = 14;
                $logro->nombre = "25 % visitado";
                $logro->tipo = 2;                
                $logro->logo = "img_14";                
                $logro->comando = "provincia_25_por_cien_visitado";
                $logro->puntos = 100;
                $resultado = Estadisticas::provincia_25_por_cien_visitado( $conexion, $usuario, $p->id_provincia);
                $logro->conseguido = false;
                if ($resultado === true) {                
                    $logro->conseguido = true;
                }                
                $p->logros[] = $logro;

                $o->provincias[] = $p;
            }            

            $v[] = $o;
        }
        
        return $v;        
    } 

    public static function get_autonomias($conexion,$usuario) {
        $v = array();
        $sql="select id,nombre from autonomias";
        $autonomias = db_get_tabla($conexion,$sql,$filas);
        for($i=0; $i < $filas; $i++) {
            $o = new stdClass();
            $o->id_autonomia = pg_result($autonomias,$i,'id');
            $o->nombre_autonomia = pg_result($autonomias,$i,'nombre');                        
            $o->poblaciones = self::get_poblaciones_de_autonomia($conexion,$o->id_autonomia);
            $o->visitadas = self::get_poblaciones_de_autonomia_visitadas($conexion,$usuario,$o->id_autonomia);
            $o->porcentaje = 0;
            if ($o->poblaciones > 0) {
                $o->porcentaje = number_format( ($o->visitadas / $o->poblaciones) * 100, 2, ",", "") ;
            }
            $logro = new stdClass();
            $logro->id = 23;
            $logro->nombre = "10 % visitado";
            $logro->tipo = 4;                
            $logro->logo = "img_2";                
            $logro->comando = "autonomia_10_por_cien_visitado";
            $logro->puntos = 500;
            $resultado = Estadisticas::autonomia_10_por_cien_visitado( $conexion, $usuario, $o->id_autonomia);
            $logro->conseguido = false;
            if ($resultado === true) {                
                $logro->conseguido = true;
            }                
            $o->logros[] = $logro;

            $logro = new stdClass();
            $logro->id = 24;
            $logro->nombre = "25 % visitado";
            $logro->tipo = 4;                
            $logro->logo = "img_3";                
            $logro->comando = "autonomia_25_por_cien_visitado";
            $logro->puntos = 1000;
            $resultado = Estadisticas::autonomia_25_por_cien_visitado( $conexion, $usuario, $o->id_autonomia);
            $logro->conseguido = false;
            if ($resultado === true) {                
                $logro->conseguido = true;
            }                
            $o->logros[] = $logro;

            $v[] = $o;            
        }
        
        return $v;        
    }
}