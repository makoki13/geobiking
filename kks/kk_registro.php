<?php
include_once './app/backend/api/clsBaseDeDatos.class.php';
include_once './app/backend/api/clsUsuario.class.php';

$datos = new stdClass();


$o = new stdClass();
    
$datos->nombre_usuario = 'makoki';
$datos->correo = 'elcorreodepabloprieto@gmail.com';
$datos->correo_2 = 'elcorreodepabloprieto@gmail.com';
$datos->clave = "makokis";
$datos->clave_2 = "makokis";
$datos->id = 1;

Usuario::envia_correo_de_confirmacion($datos);
    
/* $o->ok = true;

$conexion = BaseDeDatos::get_nueva_conexion();

$respuesta = Usuario::check_formulario_registro($conexion,$datos);
$o->ok = $respuesta->ok;
$o->msg = $respuesta->msg;
    
if ($o->ok == true) {        
    $datos->id = $respuesta->id;
    $respuesta = new stdClass();
    $respuesta = Usuario::registra($conexion,$datos);        
    $o->ok = $respuesta->ok;
    $o->msg = $respuesta->msg;
}

die(json_encode($o)); */