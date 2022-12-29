<?php

class Localidad {
    public static function osm_get($lat, $lon) {
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

        $poblacion_3 = '';
        if (isset($RG_array['address']['city'])) {
            $poblacion_3 = $RG_array['address']['city'];
        }
    
        $poblacion = $poblacion_1;
        if (trim($poblacion)=='') {
            $poblacion = $poblacion_2;
        }
        if (trim($poblacion)=='') {
            $poblacion = $poblacion_3;
        }
    
        if (isset($RG_array['address']['ISO3166-2-lvl6'])) {
            $provincia = $RG_array['address']['ISO3166-2-lvl6'];
        }
    
        return array("id" => $place_id, "poblacion" => $poblacion, "provincia" => $provincia);
    }
    
    public static function existe($conexion,$id) {
        $sql="select count(*) from localidades where id=$id";    
        $valor = db_get_dato($conexion,$sql);
        return ($valor > 0);
    }

    public static function inserta($conexion,$id, $nombre, $ine, $provincia) {
        $id_provincia = get_id_provincia_por_idgeo($conexion,$provincia);
        $sql="insert into localidades (id,nombre,ine,provincia) values ($id,$$" . trim($nombre) . "$$,$$" . trim($ine) . "$$,$id_provincia)";
        return db_inserta($conexion,$sql);
    }

    public static function nombre($conexion,$id) {
        $sql="select nombre from localidades where id=$id";    
        $valor = db_get_dato($conexion,$sql);
        return trim($valor);
    }

    public static function set_nombre($conexion,$id,$nombre) {
        $sql="update localidades set nombre=$$" . trim($nombre) . "$$ where id=$id";
        return db_actualiza($conexion,$sql);
    }
    
    
}