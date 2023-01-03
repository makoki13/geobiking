<?php
//-> Host=rtexa3j8.instances.spawn.cc;Port=32068;Username=spawn_admin_cBuT;Database=foobardb;Password=J0XccA3aXpL8T9qz

include_once 'utilidades.php';
include_once 'clsGPX.class.php';

$conexion = get_nueva_conexion();

$fichero = "fichero.gpx";
$fichero = "fichero_2.gpx";
//$fichero = "fichero_3.gpx";
$usuario = 0;

GPX::procesa($conexion,$fichero,$usuario); 
