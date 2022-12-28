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
    $valor = db_get_dato($conexion,$sql);
    return ($valor > 0);
}

function get_id_provincia_por_idgeo($conexion,$idgeo) {
    $sql="select id from provincias where id_geo=$$" . $idgeo . "$$";    
    $valor = db_get_dato($conexion,$sql);
    return $valor;
}

function inserta_localidad($conexion,$id, $nombre, $ine, $provincia) {
    $id_provincia = get_id_provincia_por_idgeo($conexion,$provincia);
    $sql="insert into localidades (id,nombre,ine,provincia) values ($id,$$" . trim($nombre) . "$$,$$" . trim($ine) . "$$,$id_provincia)";
    return db_inserta($conexion,$sql);
}

function inserta_punto($conexion,$id_poblacion,$lat, $lon) {
    $sql="insert into puntos (id_poblacion,punto,lat,lon) values ($id_poblacion,point($lat,$lon),$lat,$lon)";
    return db_inserta($conexion,$sql);
}

function get_datos_puntos_guardados($conexion,$lat,$lon) {
    $sql="select id_poblacion from puntos where punto[0] = $lat and punto[1] = $lon";
    
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
