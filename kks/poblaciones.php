<?php

//https://www.ine.es/daco/daco42/codmun/codmunmapa.htm
//https://docs.google.com/spreadsheets/d/1-pBg1SJX6-gJ6CAmM3viffBEUAS4cai8O8UMxUNWl8U/edit#gid=0

include_once './app/backend/api/clsBaseDeDatos.class.php';
include_once './app/backend/api/utilidades.php';
include_once './app/backend/api/basededatos.php';

function lista_poblaciones() {
    $conexion = BaseDeDatos::get_nueva_conexion();

    $sql="select id,nombre,poblaciones from provincias order by nombre";
    $lista = BaseDeDatos::db_get_tabla($sql,$filas);
    for ($i=0; $i < $filas; $i++) {
        $id = pg_result($lista,$i,0);
        $nombre = pg_result($lista,$i,1);
        $poblaciones = pg_result($lista,$i,2);

        $sql="select count(*) from localidades where provincia=$id";
        $poblaciones_recogidas = BaseDeDatos::db_get_dato($sql);

        $veredicto = 'OK';
        if ($poblaciones > $poblaciones_recogidas) {
            $veredicto = 'Faltan ' . ($poblaciones - $poblaciones_recogidas) . " poblaciones";
        }
        echo "provincia: $nombre - poblaciones $poblaciones - $poblaciones_recogidas => $veredicto\n";
    }
}

function vuelca_fichero_csv_a_poblaciones() {
    $conexion = BaseDeDatos::get_nueva_conexion();

    $fp = fopen('./kks/poblaciones.csv','r') or die("can't open file");    
    while($csv_line = fgetcsv($fp,1024)) {    
        $sql="insert into temporal.municipios (nombre,provincia,procesado) values ($$" . $csv_line[0] . "$$," . $csv_line[1] . ",false)";
        BaseDeDatos::db_inserta($sql);
        //echo $csv_line[0]. " : " . $csv_line[1] . "\n";
        /* for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
            echo $csv_line[$i]."\n";
        } */        
    }    
    fclose($fp) or die("can't close file");
}

function procesa_poblacion_temporal() {
    include_once './app/backend/api/clsLocalidad.class.php';

    $ok = true;

    $conexion = BaseDeDatos::get_nueva_conexion();
    //para todos los registros sin procesar
    $sql="select nombre,provincia from temporal.municipios where procesado=false";
    $lista = BaseDeDatos::db_get_tabla($sql,$filas);
    echo "filas: $filas\n";
    for($i=0; $i < $filas; $i++) {
        $nombre = pg_result($lista,$i,0);
        $provincia = pg_result($lista,$i,1);
        
        $datos_localidad = Localidad::osm_get_por_nombre($nombre);
        if ($datos_localidad===false) {
            //echo "n: $nombre p: $provincia [SIN DATOS]\n";    
            continue;
        }

        //si son validas obten el municipio segun clsGPX
        $datos = Localidad::osm_get($datos_localidad->lat, $datos_localidad->lon);
        $id = $datos['id'];
        $poblacion = $datos['poblacion'];
        $provincia = $datos['provincia'];

        if (Localidad::existe($conexion,$id) === false) {
            $resp = Localidad::inserta($conexion,$id, $poblacion, '', $provincia);
        }
        else {
            if (Localidad::nombre($conexion,$id) == '') {
                if (trim($poblacion)!= '') {
                    $ok = $ok && Localidad::set_nombre($conexion,$id,$poblacion);
                }
            }
        }
        
        $sql="update temporal.municipios set procesado=true where nombre=$$". $nombre . "$$";
        $ok = $ok && BaseDeDatos::db_actualiza($sql);

        echo "n: $nombre => $poblacion p: $provincia => $provincia [" . $datos_localidad->lat . " , " . $datos_localidad->lon . "]\n";
        
    }
}

vuelca_fichero_csv_a_poblaciones();
procesa_poblacion_temporal();
lista_poblaciones();