<?php
include_once './ng_php/backend/api/utilidades.php';
include_once './ng_php/backend/api/clsGPX.class.php';

$conexion = get_nueva_conexion();

$lat = 38.915278; $lon = -0.204444; //ador
$lat = 39.851901; $lon = -0.489554; // segorbe
$lat = 38.715278; $lon = -0.05; // Tarbena


$id_poblacion = 307721335;
$lat = 40.1840005; $lon=-2.8881113; //????

$resp = GPX::inserta_punto($conexion,$id_poblacion,$lat, $lon);
var_dump($resp);

/* 
$datos = get_datos_puntos_guardados($conexion,$lat,$lon);
if ($datos===false) {
    echo "no se ha encontrado\n";
    $datos = get_localidad($lat, $lon);
    $id = $datos['id'];
    $resp = inserta_punto($conexion,$id,$lat,$lon);
}
else {
    echo "si se ha encontrado\n";
}

$id = $datos['id'];
$poblacion = $datos['poblacion'];
$provincia = $datos['provincia'];

if (existe_localidad($conexion,$id)) {
    echo "existe $poblacion [$id] de la provincia $provincia\n";
}
else {
    $resp = inserta_localidad($conexion,$id, $poblacion, '', $provincia);
} 

var_dump($datos);*/
