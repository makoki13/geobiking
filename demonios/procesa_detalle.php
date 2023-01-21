<?php
include_once './app/backend/api/utilidades.php';
include_once './app/backend/api/clsGPX.class.php';
include_once './app/backend/api/clsBaseDeDatos.class.php';
include_once './app/backend/api/clsUsuario.class.php';

function recoge_gpx_sin_detalle(&$filas) {
    $sql="select fichero from gpx where detalle=false";
    $lista = BaseDeDatos::db_get_tabla($sql,$filas);
    return $lista;
}

function procesa_gpx($fichero) {
    $ok = true;

    $usuario = substr($fichero,1,strpos($fichero,"_")-1);        
    $texto = "procesando en detalle gpx usuario = $usuario && fichero = $fichero\n";
    echo $texto . "\n";
    $ok = $ok && GPX::inserta_en_log_gpx(BaseDeDatos::get_conexion(),$fichero,$texto);
    $ok = $ok && GPX::procesa(BaseDeDatos::get_conexion(),$fichero,$usuario,true);    
    $ok = $ok && GPX::marca_gpx_como_procesado_en_detalle(BaseDeDatos::get_conexion(),$fichero,$usuario);
    
    return $ok;
}

$ok = true;

BaseDeDatos::get_nueva_conexion();

while(true) {    
    echo "inicio de procesamiento --- " . date("d/m/Y H:i:s") . "\n";

    $lista = recoge_gpx_sin_detalle($filas);

    for ($i=0; $i < $filas; $i++) {
        $fichero = BaseDeDatos::get_valor($lista, $i,0);
        $ok = $ok && procesa_gpx($fichero);
    }

    var_dump($ok);
    
    echo "fin de procesamiento --- " . date("d/m/Y H:i:s") . "\n";
    
    sleep(60 * 5);
}