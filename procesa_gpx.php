<?php

function get_localidad($lat, $lon) {
    $json = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=".$lat."&lon=".$lon."&zoom=10";
    $opts = [
        'http' => [
          'method'=>"GET",
          'header'=>"User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) \r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $jsonfile = file_get_contents($json, false, $context);
        
    $RG_array = json_decode($jsonfile,true);
    //var_dump($RG_array);

    $poblacion_1 = '';
    if (isset($RG_array['address']['hamlet'])) {
        $poblacion_1 = $RG_array['address']['hamlet'];
    }
    
    $poblacion_2 = '';
    if (isset($RG_array['address']['village'])) {
        $poblacion_2 = $RG_array['address']['village'];
    }

    $poblacion = $poblacion_1;
    if (trim($poblacion_1)=='') {
        $poblacion = $poblacion_2;
    }

    return $poblacion;
}

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
                  
            $poblacion = get_localidad($lat, $lon);
            echo "lat: $lat . long: $lon -> poblacion $poblacion\n";

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
 
