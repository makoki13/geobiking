<?php

include_once 'utilidades.php';
include_once 'clsLocalidad.class.php';

class GPX {
    public static function procesa($conexion,$fichero,$usuario=-1) {
        $ok = true;

        $gpx = simplexml_load_file($fichero);

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
                        $id = $datos['id'];
                        $ok = $ok && inserta_punto($conexion,$id,$lat,$lon);
                        $encontrado = false;
                    }
                    
                    $id = $datos['id'];
                    $poblacion = $datos['poblacion'];
                    $provincia = $datos['provincia'];

                    if ($encontrado=== false) {
                        echo "lat: $lat . long: $lon -> poblacion [$id] $poblacion [$provincia]\n";
                    }
                    
                    if (Localidad::existe($conexion,$id) === false) {
                        $resp = Localidad::inserta($conexion,$id, $poblacion, '', $provincia);                    
                        echo "***** nueva $poblacion [$id] de la provincia $provincia\n";
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

        var_dump($ok);
    }
}