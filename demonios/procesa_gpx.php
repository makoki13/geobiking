<?php
include_once './ng_php/backend/api/utilidades.php';
include_once './ng_php/backend/api/clsGPX.class.php';

$ok = true;

$conexion = get_nueva_conexion();

while(true) {
    echo "inicio de procesamiento --- " . date("d/m/Y H:i:s") . "\n";

    $lista = GPX::get_lista_gpx_pendientes($conexion);
    if (count($lista) > 0) foreach($lista as $registro) {
        $usuario = $registro->usuario;
        $fichero = $registro->fichero;
        echo "usuario = $usuario && fichero = $fichero\n";
        $ok = $ok && GPX::procesa($conexion,$fichero,$usuario);    
        $ok = $ok && GPX::mueve($fichero);
        $ok = $ok && GPX::marca_gpx_como_procesado($conexion,$fichero,$usuario);
    }

    echo "fin de procesamiento --- " . date("d/m/Y H:i:s") . "\n";

    sleep(60 * 5);
}

var_dump($ok);
