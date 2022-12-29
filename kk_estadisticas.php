<?php

include_once 'clsEstadisticas.class.php';
include_once 'basededatos.php';

$conexion = get_nueva_conexion();

$usuario = 0;

$poblaciones = Estadisticas::get_total_numero_localidades($conexion);
$poblaciones_visitadas = Estadisticas::get_localidades_visitadas($conexion, $usuario);

$porcentaje = sprintf("%.2f", ($poblaciones_visitadas / $poblaciones) * 100);
echo "poblaciones visitadas: $poblaciones_visitadas de un total de $poblaciones ($porcentaje %)\n";

$lista_logros = Estadisticas::get($conexion,$usuario);
//var_dump($lista_logros);
echo "\n";
if (count($lista_logros['logros']) > 0) foreach($lista_logros['logros'] as $logro) {
    echo "   * " . $logro->nombre . " (" . $logro->puntos . " puntos)\n";
}
echo "--------------------------------------------------------------------\n";
echo "Número de puntos: " . $lista_logros['total_puntos'] . "\n\n";
