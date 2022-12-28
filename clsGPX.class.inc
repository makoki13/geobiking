<?php

include_once 'utilidades.php';

class GPX {
    public static function procesa($conexion,$fichero) {
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

                    $datos = get_datos_puntos_guardados($conexion,$lat,$lon);
                    if ($datos===false) {                  
                        $datos = get_localidad($lat, $lon);
                        $id = $datos['id'];
                        $resp = inserta_punto($conexion,$id,$lat,$lon);
                    }
                    
                    $id = $datos['id'];
                    $poblacion = $datos['poblacion'];
                    $provincia = $datos['provincia'];

                    echo "lat: $lat . long: $lon -> poblacion [$id] $poblacion [$provincia]\n";

                    if (existe_localidad($conexion,$id)) {
                        echo "existe $poblacion [$id] de la provincia $provincia\n";
                    }
                    else {
                        $resp = inserta_localidad($conexion,$id, $poblacion, '', $provincia);                    
                    }

                    //if ($i>=10) {
                    //    break;
                    //}
                }
            }
        }
    }
}