<?php

function get_localidad($lat, $lon) {
    //https://nominatim.openstreetmap.org/reverse?lat=38.91464854439443&lon=-0.26150098500160646&zoom=10&format=jsonv2
    $url = 'https://nominatim.openstreetmap.org/reverse?lat=' . $lat . '&lon=' . $lon . '&zoom=10&format=jsonv2';

    // Initialize a new cURL session
    $ch = curl_init($url);
    var_dump($ch);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
    curl_setopt($ch, CURLOPT_HEADER, 0);  // Do not include the HTTP header in the response

    // Send the request and get the response
    $response = curl_exec($ch);
    var_dump($response);

    // Close the cURL session
    curl_close($ch);

    // Parse the response string into a PHP object
    $data = json_decode($response);

    //var_dump($data);
}

function get_localidad_get($lat, $lon) {
    //$url = 'https://nominatim.openstreetmap.org/reverse?lat=' . $lat . '&lon=' . $lon . '&zoom=10&format=jsonv2';
    $url = 'http://nominatim.openstreetmap.org/reverse?lat=38.91464854439443&lon=-0.26150098500160646&zoom=10&format=jsonv2';

    // Send the HTTP request and get the response as a string
    $response = file_get_contents($url);

    // Parse the response string into a PHP object
    $data = json_decode($response);

    var_dump($data);
}

function get_localidad_json($lat, $lon) {
    $json = "https://nominatim.openstreetmap.org/reverse?format=json&lat=".$lat."&lon=".$lon."&zoom=27&addressdetails=1";

    $ch = curl_init($json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0");
    $jsonfile = curl_exec($ch);
    var_dump($jsonfile);
    curl_close($ch);

    $RG_array = json_decode($jsonfile,true);
    var_dump($RG_array);
}

function get_localidad_v4($lat, $lon) {
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
            // Process the track point      
            //get_localidad($lat, $lon);
            //get_localidad_get($lat, $lon);
            //get_localidad_json($lat, $lon);
      
            $poblacion = get_localidad_v4($lat, $lon);
            echo "lat: $lat . long: $lon -> poblacion $poblacion\n";

            $lista_poblaciones[$poblacion] = true;

            //$poblacion = get_localidad_v4(38.91464854439443,-0.26150098500160646);
            //echo "lat: $lat . long: $lon -> poblacion $poblacion\n";

            if ($i>=100) {
                exit();
            }
        }
    }
}

echo "Lista de poblaciones:\n";
if (count($lista_poblaciones) > 0) foreach($lista_poblaciones as $poblacion => $reg) {
    echo $poblacion . "\n";
}
 
