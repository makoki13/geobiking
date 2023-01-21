<?php

include_once 'utilidades.php';
include_once 'clsLocalidad.class.php';

class GPX {
    public static $numero_de_segundos_de_diferencia = 10;

    public static function procesa($conexion,$fichero,$usuario=-1, $detalle = false) {
        $ok = true;

        if ($detalle==false) {
            $ruta='./gpx/' . $fichero;
        }
        else {
            $ruta='./gpx/procesados/' . $fichero;
        }
        $gpx = simplexml_load_file($ruta);

        foreach ($gpx->trk as $trk) {    
            foreach ($trk->trkseg as $trkseg) {
                $i = 0;
                $num_tracks = count($trkseg->trkpt);                        
                $ultima_fecha = "1970-01-01T";            
                foreach ($trkseg->trkpt as $trkpt) {
                    $fila = $i + 1;
                    echo "** fila $fila de $num_tracks [". date("d.m.y H:i:s") ."]\n";
                    $i++;
                    
                    $hora_gpx = $trkpt->time;                                        
                    //$momento = de_hora_gpx_a_hora_php($hora_gpx);
                    
                    $origin = new DateTime($ultima_fecha, new DateTimeZone('UTC') );
                    $target = new DateTime($hora_gpx, new DateTimeZone('UTC') );
                    $interval = $origin->diff($target);
                                        
                    if ($detalle==false) {
                        if ($interval->s < self::$numero_de_segundos_de_diferencia) {
                            continue;
                        }
                    }
                                        
                    $ultima_fecha = $hora_gpx;

                    $lat = (float) $trkpt['lat'];
                    $lon = (float) $trkpt['lon'];

                    $encontrado = true;
                    $datos = self::get_datos_puntos_guardados($conexion,$lat,$lon);                    
                    if ($datos===false) {                  
                        $datos = Localidad::osm_get($lat, $lon);
                        if (substr($datos['provincia'],0,2)!='ES') {
                            $poblacion = $datos['poblacion'];
                            $provincia = $datos['provincia'];
                            $texto = "***** extranjero!!!! $poblacion . $provincia\n";    
                            echo $texto . "\n";
                            self::inserta_en_log_puntos($conexion,$fichero,$texto);    
                            continue;
                        }
                        $id = $datos['id'];
                        $ok = $ok && self::inserta_punto($conexion,$id,$lat,$lon);
                        $encontrado = false;
                    }
                                        
                    $id = $datos['id'];
                    $poblacion = $datos['poblacion'];
                    $provincia = $datos['provincia'];

                    if ($encontrado=== false) {
                        $texto = "lat: $lat . long: $lon -> poblacion [$id] $poblacion [$provincia]\n";
                        echo $texto . "\n";
                        self::inserta_en_log_puntos($conexion,$fichero,$texto);
                    }
                    
                    if (Localidad::existe($conexion,$id) === false) {
                        $resp = Localidad::inserta($conexion,$id, $poblacion, '', $provincia);                    
                        $texto = "***** nueva $poblacion [$id] de la provincia $provincia\n";
                        echo $texto . "\n";
                        self::inserta_en_log_puntos($conexion,$fichero,$texto);
                    }
                    else {
                        if (Localidad::nombre($conexion,$id) == '') {
                            if (trim($poblacion)!= '') {
                                $ok = $ok && Localidad::set_nombre($conexion,$id,$poblacion);
                            }
                        }
                    }

                    if ($usuario != -1) {
                        $ok = $ok && guarda_en_usuarios_registro($conexion,$usuario,$id);
                    }

                    //if ($i>=10) {
                    //    break;
                    //}
                }
            }
        }

        return $ok;
    }
    
    public static function guarda_gpx_sin_procesar($conexion,$fichero,$usuario) {
        $ok = true;
        if (!self::_existe_fichero($conexion,$fichero,$usuario)) {        
            $sql="insert into gpx (usuario,fichero) values ($usuario,$$" . $fichero . "$$)";
            $ok = db_inserta($conexion,$sql);
        }

        return $ok;
    }

    private static function get_datos_puntos_guardados($conexion,$lat,$lon) {
        $lat_cuatro_decimales = sprintf("%.5f",$lat);
        $lon_cuatro_decimales = sprintf("%.5f",$lon);
        $sql="select id_poblacion from puntos where lat = $lat_cuatro_decimales and lon = $lon_cuatro_decimales";                
        $id_poblacion = db_get_dato($conexion,$sql);
                    
        if ($id_poblacion == false) {
            return false;
        }
    
        $sql="select nombre,provincia from localidades where id=$id_poblacion";
        $datos = db_get_registro($conexion,$sql);
        $poblacion = get_campo($datos, 0);
        $provincia = get_campo($datos, 1);
    
        return array("id" => $id_poblacion, "poblacion" => $poblacion, "provincia" => $provincia);
    }

    private static function _existe_fichero($conexion,$fichero,$usuario) {
        $sql="select count(*) from gpx where usuario=$usuario and fichero=$$" . $fichero . "$$";
        $registros = db_get_dato($conexion,$sql);
        return ($registros > 0);
    }

    public static function mueve($archivo) {
        $ruta='./gpx/';
        $path_destino = $ruta . "procesados/";        
        $destino = $ruta.$archivo;
        return rename($destino, $path_destino . pathinfo($destino, PATHINFO_BASENAME)); 
    }

    public static function get_lista_gpx_pendientes($conexion) {
        $sql="select * from gpx where finalizacion is null";
        $reg = db_get_tabla($conexion,$sql,$filas);
        $lista = array();        
        for ($i = 0; $i < $filas; $i++) {
            $lista[$i] = new stdClass();
            $lista[$i]->usuario = pg_result($reg,$i,'usuario');            
            $lista[$i]->fichero = pg_result($reg,$i,'fichero');
        }

        return $lista;
    }

    public static function marca_gpx_como_procesado($conexion,$fichero,$usuario) {
        $sql="update gpx set finalizacion = now() where usuario=$usuario and fichero=$$" . $fichero . "$$";
        return db_inserta($conexion,$sql);
    }

    public static function marca_gpx_como_procesado_en_detalle($conexion,$fichero,$usuario) {
        $sql="update gpx set detalle = true where usuario=$usuario and fichero=$$" . $fichero . "$$";
        return db_inserta($conexion,$sql);
    }

    private static function existe_punto($conexion,$id_poblacion,$lat, $lon) {
        $lat_cuatro_decimales = sprintf("%.5f",$lat);
        $lon_cuatro_decimales = sprintf("%.5f",$lon);
        $sql="select count(*) from puntos where id_poblacion=$id_poblacion and lat=$lat_cuatro_decimales and lon=$lon_cuatro_decimales";        
        $registros = db_get_dato($conexion,$sql);
        return ($registros != 0);
    }

    public static function inserta_punto($conexion,$id_poblacion,$lat, $lon) {
        $ok = true;

        $lat = trim($lat);
        $lon = trim($lon);
        
        if (self::existe_punto($conexion,$id_poblacion,$lat, $lon)==false) {
            $lat_cuatro_decimales = sprintf("%.5f",$lat);
            $lon_cuatro_decimales = sprintf("%.5f",$lon);
            $sql="insert into puntos (id_poblacion,punto,lat,lon) values ($id_poblacion,point($lat,$lon),$lat_cuatro_decimales,$lon_cuatro_decimales)";
            $ok = $ok && db_inserta($conexion,$sql);
        }
        else {
            //echo "hemos detectado el punto $lat, $lon de la poblacion $id_poblacion Y NO SE HA METIDO!!!! :-) \n";
            //exit();
        }

        return $ok;        
    }    

    private static function inserta_en_log_puntos($conexion,$fichero,$texto) {
        $ok = true;
        $sql="insert into logs.puntos (fichero,texto) values ($$" . $fichero . "$$,$$". $texto . "$$)";
        $ok = $ok && db_inserta($conexion,$sql);

        return $ok;
    }

    public static function inserta_en_log_gpx($conexion,$fichero,$texto) {
        $ok = true;
        $sql="insert into logs.gpx (fichero,texto) values ($$" . $fichero . "$$,$$". $texto . "$$)";
        $ok = $ok && db_inserta($conexion,$sql);

        return $ok;
    }
}