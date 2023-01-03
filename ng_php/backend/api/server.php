<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

function connect()
{
    $cadena_conexion = "host=rtexa3j8.instances.spawn.cc port=32068 dbname=foobardb user=spawn_admin_cBuT password=J0XccA3aXpL8T9qz connect_timeout=5";
    $conexion = pg_connect($cadena_conexion, PGSQL_CONNECT_FORCE_NEW);

    return $conexion;
}

$json = file_get_contents('php://input');
$datos = json_decode($json);

$funcion = $datos->funcion;
$usuario = $datos->usuario;

if ($funcion == "get_logros") {
    $o = new stdClass();

    $conexion = connect();

    include_once 'clsEstadisticas.class.php';
    $datos = Estadisticas::get($conexion,$usuario);

    $o->poblaciones = Estadisticas::get_total_numero_localidades($conexion);    
    $o->poblaciones_visitadas = Estadisticas::get_localidades_visitadas($conexion, $usuario);
    $o->porcentaje_poblaciones = sprintf("%.2f", ($o->poblaciones_visitadas / $o->poblaciones) * 100);

    $o->provincias = Estadisticas::get_total_numero_provincias($conexion);
    $o->provincias_visitadas = Estadisticas::get_provincias_visitadas($conexion,$usuario);
    $o->porcentaje_provincias = sprintf("%.2f", ($o->provincias_visitadas / $o->provincias) * 100);

    $o->autonomias = Estadisticas::get_total_numero_autonomias($conexion);
    $o->autonomias_visitadas = Estadisticas::get_autonomias_visitadas($conexion,$usuario);
    $o->porcentaje_autonomias = sprintf("%.2f", ($o->autonomias_visitadas / $o->autonomias) * 100);

    $datos_logros = Estadisticas::get($conexion,$usuario);
    $o->logros = $datos_logros['logros'];
    $o->total_puntos = $datos_logros['total_puntos'];
    //var_dump($o->logros);
    
    $o->ok = true;
    $o->msg = "mensaje";
    $o->usuario = $usuario;

    die(json_encode($o));    
}



