<?php
include_once 'utilidades.php';

$conexion = get_nueva_conexion();

$lat = 38.915278; $lon = -0.204444; //ador
$lat = 39.851901; $lon = -0.489554; // segorbe
$lat = 38.715278; $lon = -0.05; // Tarbena

$datos = get_localidad($lat, $lon);

$id = $datos['id'];
$poblacion = $datos['poblacion'];
$provincia = $datos['provincia'];

if (existe_localidad($conexion,$id)) {
    echo "existe $poblacion [$id] de la provincia $provincia";
}

var_dump($datos);