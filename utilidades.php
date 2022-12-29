<?php
/*
Host=rtexa3j8.instances.spawn.cc;Port=32068;Username=spawn_admin_cBuT;Database=foobardb;Password=J0XccA3aXpL8T9qz

truncate puntos; truncate usuarios_registro; truncate logros;
*/

include_once 'basededatos.php';


function get_id_provincia_por_idgeo($conexion,$idgeo) {
    $sql="select id from provincias where id_geo=$$" . $idgeo . "$$";    
    $valor = db_get_dato($conexion,$sql);
    return $valor;
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

function existe_en_usuarios_registro($conexion,$usuario,$localidad) {
    $sql="select count(*) from usuarios_registro where usuario=$usuario and localidad=$localidad";    
    $valor = db_get_dato($conexion,$sql);
    return ($valor > 0);
}

function guarda_en_usuarios_registro($conexion,$usuario,$localidad) {
    if (existe_en_usuarios_registro($conexion,$usuario,$localidad) == false) {
        $sql="insert into usuarios_registro (usuario,localidad) values ($usuario,$localidad)";
        return db_inserta($conexion,$sql);
    }

    return true;
}