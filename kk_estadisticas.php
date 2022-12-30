<?php

include_once 'clsEstadisticas.class.php';
include_once 'basededatos.php';

$conexion = get_nueva_conexion();

$usuario = 0;

echo "\n";
echo "                          INFORME\n";
echo "--------------------------------------------------------------------\n";

$poblaciones = Estadisticas::get_total_numero_localidades($conexion);
$poblaciones_visitadas = Estadisticas::get_localidades_visitadas($conexion, $usuario);
$porcentaje = sprintf("%.2f", ($poblaciones_visitadas / $poblaciones) * 100);
echo "    Poblaciones visitadas: $poblaciones_visitadas de un total de $poblaciones ($porcentaje %)\n";

$provincias = Estadisticas::get_total_numero_provincias($conexion);
$provincias_visitadas = Estadisticas::get_provincias_visitadas($conexion,$usuario);
$porcentaje = sprintf("%.2f", ($provincias_visitadas / $provincias) * 100);
echo "    Provincias visitadas: $provincias_visitadas de un total de $provincias ($porcentaje %)\n";

$autonomias = Estadisticas::get_total_numero_autonomias($conexion);
$autonomias_visitadas = Estadisticas::get_autonomias_visitadas($conexion,$usuario);
$porcentaje = sprintf("%.2f", ($autonomias_visitadas / $autonomias) * 100);
echo "    Comunidades autonomas visitadas: $autonomias_visitadas de un total de $autonomias ($porcentaje %)\n";

$lista_logros = Estadisticas::get($conexion,$usuario);
echo "\n";
if (count($lista_logros['logros']) > 0) foreach($lista_logros['logros'] as $logro) {
    echo "    * " . $logro->nombre . " (" . $logro->puntos . " puntos)\n";
}
echo "--------------------------------------------------------------------\n";
echo "                          Número de puntos: " . $lista_logros['total_puntos'] . "\n\n";
