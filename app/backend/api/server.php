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

if ($funcion == "get_logros_general") {
    $o = new stdClass();

    $conexion = connect();

    include_once 'clsEstadisticas.class.php';
        
    $datos_logros = Estadisticas::get_general($conexion,$usuario);
    $o->logros = $datos_logros['logros'];
    
    $o->ok = true;
    $o->msg = "mensaje";
    $o->usuario = $usuario;

    die(json_encode($o));    
}

if ($funcion == "get_logros_globales") {
    $o = new stdClass();

    $conexion = connect();

    include_once 'clsEstadisticas.class.php';
    
    $o->poblaciones = Estadisticas::get_total_numero_localidades($conexion);    
    $o->poblaciones_visitadas = Estadisticas::get_localidades_visitadas($conexion, $usuario);
    $o->porcentaje_poblaciones = sprintf("%.2f", ($o->poblaciones_visitadas / $o->poblaciones) * 100);

    $o->provincias = Estadisticas::get_total_numero_provincias($conexion);
    $o->provincias_visitadas = Estadisticas::get_provincias_visitadas($conexion,$usuario);
    $o->porcentaje_provincias = sprintf("%.2f", ($o->provincias_visitadas / $o->provincias) * 100);

    $o->autonomias = Estadisticas::get_total_numero_autonomias($conexion);
    $o->autonomias_visitadas = Estadisticas::get_autonomias_visitadas($conexion,$usuario);
    $o->porcentaje_autonomias = sprintf("%.2f", ($o->autonomias_visitadas / $o->autonomias) * 100);

    $datos_logros = Estadisticas::get_global($conexion,$usuario);
    $o->total_puntos = $datos_logros['total_puntos'];
    //var_dump($o->logros);
    
    $o->ok = true;
    $o->msg = "mensaje";
    $o->usuario = $usuario;

    die(json_encode($o));    
}

if ($funcion == "get_logros_provincia") {
    $o = new stdClass();

    $conexion = connect();

    include_once 'clsEstadisticas.class.php';
    $o->datos_provinciales = Estadisticas::get_provinciales($conexion,$usuario);
        
    $o->ok = true;
    $o->msg = "mensaje";
    $o->usuario = $usuario;

    die(json_encode($o));    
}

if ($funcion == "get_logros_autonomia") {
    $o = new stdClass();

    $conexion = connect();

    include_once 'clsEstadisticas.class.php';
    $o->datos_autonomicos = Estadisticas::get_autonomias($conexion,$usuario);
            
    $o->ok = true;
    $o->msg = "mensaje";
    $o->usuario = $usuario;

    die(json_encode($o));    
}

if ($funcion == "get_datos_inicio") {    
    $o = new stdClass();

    $conexion = connect();

    include_once 'utilidades.php';
    include_once 'clsEstadisticas.class.php';
    include_once 'clsUsuario.class.php';
    
    $datos_usuario = Usuario::get_datos($conexion,$usuario);
    $nombre_usuario = $datos_usuario->nombre;
    $ultima_actualizacion = $datos_usuario->ultima_actualizacion;
    $str_ultima_actualizacion = substr($ultima_actualizacion,8,2) . " de " . get_nombre_mes(substr($ultima_actualizacion,5,2)) .  " del " . substr($ultima_actualizacion,0,4);

    $datos_logros = Estadisticas::get_global($conexion,$usuario);    

    $o->ok = true;
    $o->total_puntos = $datos_logros['total_puntos'];
    $o->nombre_usuario = strtoupper($nombre_usuario);
    $o->ultima_actualizacion = $str_ultima_actualizacion;

    die(json_encode($o));    
}

if ($funcion=="registra") {
    $o = new stdClass();

    $o->ok = true;

    die(json_encode($o));
}



