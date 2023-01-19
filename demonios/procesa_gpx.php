<?php
include_once './ng_php/backend/api/utilidades.php';
include_once './ng_php/backend/api/clsGPX.class.php';
include_once './ng_php/backend/api/basededatos.php';
include_once './ng_php/backend/api/clsUsuario.class.php';

function recoge_nuevos_gpx($conexion) {
    $ok = true;

    $ruta='./gpx/';
    $path_destino = $ruta . "procesados/";
 
    $directorio = opendir($ruta); //ruta actual
    while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
    {
        if (is_dir($archivo)===false)//verificamos si es o no un directorio
        {
            if (trim($archivo)=='procesados') continue;
            $usuario = substr($archivo,1,strpos($archivo,"_")-1);
            $texto = "recogiendo archivo $archivo usuario: $usuario\n";            
            echo $texto . "\n";
            $ok = $ok && GPX::inserta_en_log_gpx($conexion,$archivo,$texto);
            GPX::guarda_gpx_sin_procesar($conexion,$archivo,$usuario);
        }
    }

    return $ok;
}

function procesa_gpx($conexion,$registro) {
    $ok = true;
    $usuario = $registro->usuario;
    $fichero = $registro->fichero;
    $texto = "procesando gpx usuario = $usuario && fichero = $fichero\n";
    echo $texto . "\n";
    $ok = $ok && GPX::inserta_en_log_gpx($conexion,$fichero,$texto);
    $ok = $ok && GPX::procesa($conexion,$fichero,$usuario);    
    $ok = $ok && GPX::mueve($fichero);
    $ok = $ok && GPX::marca_gpx_como_procesado($conexion,$fichero,$usuario);
    $ok = $ok && Usuario::set_ultima_actualizacion($conexion,$usuario);

    return $ok;
}

$ok = true;

$conexion = get_nueva_conexion();

while(true) {    
    echo "inicio de procesamiento --- " . date("d/m/Y H:i:s") . "\n";

    $ok = $ok && recoge_nuevos_gpx($conexion);

    $lista = GPX::get_lista_gpx_pendientes($conexion);
    if (count($lista) > 0) foreach($lista as $registro) {
        $ok = $ok && procesa_gpx($conexion,$registro);
    }

    echo "fin de procesamiento --- " . date("d/m/Y H:i:s") . "\n";

    var_dump($ok);

    sleep(60 * 5);
}