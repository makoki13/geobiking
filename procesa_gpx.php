<?php
//-> Host=rtexa3j8.instances.spawn.cc;Port=32068;Username=spawn_admin_cBuT;Database=foobardb;Password=J0XccA3aXpL8T9qz

include_once 'utilidades.php';
include_once 'clsGPX.class.php';

$conexion = get_nueva_conexion();

//$fichero = "./gpx/fichero.gpx";
//$fichero = "./gpx/fichero_2.gpx";
//$fichero = "./gpx/fichero_3.gpx";
//$fichero = "./gpx/fichero_4.gpx";
$fichero = "./gpx/fichero_5.gpx";
//$fichero = "./gpx/fichero_6.gpx";
//$fichero = "./gpx/fichero_7.gpx";
//$fichero = "./gpx/fichero_8.gpx";
//$fichero = "./gpx/fichero_9.gpx";
//$fichero = "./gpx/fichero_10.gpx";
//$fichero = "./gpx/fichero_11.gpx";
//$fichero = "./gpx/fichero_12.gpx";

$usuario = 0;

GPX::procesa($conexion,$fichero,$usuario); 
