<?php
//-> Host=rtexa3j8.instances.spawn.cc;Port=32068;Username=spawn_admin_cBuT;Database=foobardb;Password=J0XccA3aXpL8T9qz

include_once 'utilidades.php';
include_once 'clsGPX.class.php';

$conexion = get_nueva_conexion();

$fichero = "./gpx/fichero.gpx";
$fichero = "./gpx/fichero_2.gpx";
$fichero = "./gpx/fichero_3.gpx";
$fichero = "./gpx/fichero_4.gpx";
$usuario = 0;

GPX::procesa($conexion,$fichero,$usuario); 
