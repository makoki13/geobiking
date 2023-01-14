<?php

include_once 'utilidades.php';
include_once 'clsLocalidad.class.php';

class GPX {
    public static function procesa($conexion,$fichero,$usuario=-1) {
        $ok = true;

        $ruta='./gpx/' . $fichero;
        $gpx = simplexml_load_file($ruta);

        foreach ($gpx->trk as $trk) {    
            foreach ($trk->trkseg as $trkseg) {
                $i = 0;
                $num_tracks = count($trkseg->trkpt);    
                foreach ($trkseg->trkpt as $trkpt) {
                    $fila = $i + 1;
                    echo "** fila $fila de $num_tracks\n";
                    $i++;
                    $lat = (float) $trkpt['lat'];
                    $lon = (float) $trkpt['lon'];

                    $encontrado = true;
                    $datos = get_datos_puntos_guardados($conexion,$lat,$lon);
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

    private static function existe_punto($conexion,$id_poblacion,$lat, $lon) {
        $sql="select count(*) from puntos where id_poblacion=$id_poblacion and lat=$lat and lon=$lon";        
        $registros = db_get_dato($conexion,$sql);
        return ($registros != 0);
    }

    public static function inserta_punto($conexion,$id_poblacion,$lat, $lon) {
        $ok = true;

        $lat = trim($lat);
        $lon = trim($lon);
        
        if (self::existe_punto($conexion,$id_poblacion,$lat, $lon)==false) {
            $sql="insert into puntos (id_poblacion,punto,lat,lon) values ($id_poblacion,point($lat,$lon),$lat,$lon)";
            echo $sql."\n";
            $ok = $ok && db_inserta($conexion,$sql);
        }
        else {
            echo "hemos detectado el punto $lat, $lon de la poblacion $id_poblacion Y NO SE HA METIDO!!!! :-) \n";
            exit();
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