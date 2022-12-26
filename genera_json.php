<?php
$max_latitud = 43.790278;
$min_latitud = 36.004167;
$max_longitud = 3.332014;
$min_longitud = -9.298889;

$v_max_latitud = sprintf("%.3f",$max_latitud);
$v_min_latitud = sprintf("%.3f",$min_latitud);
$v_max_longitud = sprintf("%.3f",$max_longitud);
$v_min_longitud = sprintf("%.3f",$min_longitud);

echo "max lat: $v_max_latitud * min lat: $v_min_latitud * max long: $v_max_longitud * min long: $v_min_longitud\n";

/* $n = 0;
   for ($longitud=$v_min_longitud; $longitud <= $v_max_longitud; $longitud = $longitud + 0.001) {
    $fila = $n + 1;
        for ($latitud=$v_min_latitud; $latitud <= $v_max_latitud; $latitud = $latitud + 0.001) {
            $v_latitud = sprintf("%.3f",$latitud);
            $v_longitud = sprintf("%.3f",$longitud);
            $n++;
            echo "coordenadas $fila -> $v_latitud , $v_longitud \n";
        }    
    } */

$num_longitud = 0;
for ($longitud=$v_min_longitud; $longitud <= $v_max_longitud; $longitud = $longitud + 0.001) {
    $num_longitud++;    
}

$num_latitud = 0;
for ($latitud=$v_min_latitud; $latitud <= $v_max_latitud; $latitud = $latitud + 0.001) {
    $num_latitud++;        
}

echo "num latitud: $num_latitud * num_longitud: $num_longitud ==> " . $num_latitud * $num_longitud. "\n";