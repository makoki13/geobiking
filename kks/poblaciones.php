<?php

//https://www.ine.es/daco/daco42/codmun/codmunmapa.htm

include_once './app/backend/api/clsBaseDeDatos.class.php';

$conexion = BaseDeDatos::get_nueva_conexion();

$sql="select id,nombre,poblaciones from provincias order by nombre";
$lista = BaseDeDatos::db_get_tabla($sql,$filas);
for ($i=0; $i < $filas; $i++) {
    $id = pg_result($lista,$i,0);
    $nombre = pg_result($lista,$i,1);
    $poblaciones = pg_result($lista,$i,2);

    $sql="select count(*) from localidades where provincia=$id";
    $poblaciones_visitadas = BaseDeDatos::db_get_dato($sql);

    $veredicto = 'OK';
    if ($poblaciones > $poblaciones_visitadas) {
        $veredicto = 'Faltan ' . ($poblaciones - $poblaciones_visitadas) . " poblaciones";
    }
    echo "provincia: $nombre - poblaciones $poblaciones - $poblaciones_visitadas => $veredicto\n";
}