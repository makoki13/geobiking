<?php

include_once './ng_php/backend/api/utilidades.php';
include_once './ng_php/backend/api/clsGPX.class.php';

$conexion = get_nueva_conexion();

$usuario = 0;


$ruta='./gpx/';
$path_destino = $ruta . "procesados/";
 
$directorio = opendir($ruta); //ruta actual
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (is_dir($archivo)===false)//verificamos si es o no un directorio
    {
        if (trim($archivo)=='procesados') continue;
        GPX::guarda_gpx_sin_procesar($conexion,$archivo,$usuario);
    }
    
    /* $destination_path = 'bar/';
    $destino = $ruta.$archivo;
    rename($destino, $path_destino . pathinfo($destino, PATHINFO_BASENAME)); */
}

//GPX::procesa($conexion,$fichero,$usuario); 