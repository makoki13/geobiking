<?php

//-> Host=rtexa3j8.instances.spawn.cc;Port=32068;Username=spawn_admin_cBuT;Database=foobardb;Password=J0XccA3aXpL8T9qz

function get_nueva_conexion() {
    $cadena_conexion = "host=rtexa3j8.instances.spawn.cc port=32068 dbname=foobardb user=spawn_admin_cBuT password=J0XccA3aXpL8T9qz connect_timeout=5";
    $conexion = pg_connect($cadena_conexion, PGSQL_CONNECT_FORCE_NEW);
    return $conexion;
}