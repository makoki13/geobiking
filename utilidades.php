<?php

include_once 'basededatos.php';

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
    
    if (isset($RG_array['place_id'])) {
        $place_id = $RG_array['place_id'];
    }
    
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

    if (isset($RG_array['address']['ISO3166-2-lvl6'])) {
        $provincia = $RG_array['address']['ISO3166-2-lvl6'];
    }

    return array("id" => $place_id, "poblacion" => $poblacion, "provincia" => $provincia);
}

function existe_localidad($conexion,$id) {
    $sql="select count(*) from localidades where id=$id";
    $valor = @pg_query($conexion,$sql);
    return ($valor > 0);
}