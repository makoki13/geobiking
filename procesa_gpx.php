<?php
//-> Host=rtexa3j8.instances.spawn.cc;Port=32068;Username=spawn_admin_cBuT;Database=foobardb;Password=J0XccA3aXpL8T9qz

include_once 'utilidades.php';

$fichero = "fichero.gpx";

$gpx = simplexml_load_file($fichero);

$lista_poblaciones = array();

echo "empezamos....\n";

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
                  
            $datos = get_localidad($lat, $lon);

            $id = $datos['id'];
            $poblacion = $datos['poblacion'];
            $provincia = $datos['provincia'];

            echo "lat: $lat . long: $lon -> poblacion [$id] $poblacion [$provincia]\n";

            $lista_poblaciones[$poblacion] = true;

            if ($i>=10) {
                break;
            }
        }
    }
}

echo "Lista de poblaciones:\n";
if (count($lista_poblaciones) > 0) foreach($lista_poblaciones as $poblacion => $reg) {
    echo $poblacion . "\n";
}
 
