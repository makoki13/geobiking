<?php
/*
Host=rtexa3j8.instances.spawn.cc;Port=32068;Username=spawn_admin_cBuT;Database=foobardb;Password=J0XccA3aXpL8T9qz

truncate puntos; truncate usuarios_registro; truncate logros;
*/



@include_once './basededatos.php';

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

function get_nombre_mes($mes) {
    switch(intval($mes)) {
        case 1:
            return "enero";
            break;
        case 2:
            return "febrero";
            break;
        case 3:
            return "marzo";
            break;
        case 4:
            return "abril";
            break;
        case 5:
            return "mayo";
            break;
        case 6:
            return "junio";
            break;
        case 7:
            return "julio";
            break;
        case 8:
            return "agosto";
            break;
        case 9:
            return "septiembre";
            break;
        case 10:
            return "octubre";
            break;
        case 7:
            return "noviembre";
            break;
        case 8:
            return "diciembre";
            break;


        default:
            return "mes desconocido";
            break;
    }
}

function de_hora_gpx_a_hora_php($hora_gpx = 0) {
    if (trim($hora_gpx)=='') return 0;

    $elementos = explode("T",$hora_gpx);
    $fecha = $elementos[0];
    $elementos_fecha = explode("-",$fecha);
    $anyo = intval($elementos_fecha[0]);
    $mes = intval($elementos_fecha[1]);
    $dia = intval($elementos_fecha[2]);    
    if (count($elementos) > 1) {        
        $hora = $elementos[1];
        $elementos_hora = explode(":",$hora);
        $hora = intval($elementos_hora[0]);
        $minutos = intval($elementos_hora[1]);
        $segundos = intval($elementos_hora[2]);
    }
    return mktime($hora, $minutos, $segundos, $mes, $dia, $anyo);
}