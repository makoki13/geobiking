<?php
    $usuario = $_POST['usuario'];
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1 style='text-align:center;'>logros de usuario <?php echo $usuario; ?> V.1.1</h1>
    <div class="contenedor">
        <div class="centrado">
            <table style="width:100%;border:2px solid black;" rules="all" cellpadding="10px">
                <tr>
                    <td class="titulo_campo" style="min-width:280px;">Poblaciones visitadas</td>
                    <td class="dato_campo" style="width:100%;" id="poblaciones_visitadas"></td>
                </tr>
                <tr>
                    <td class="titulo_campo">Provincias visitadas</td>
                    <td class="dato_campo" id="provincias_visitadas"></td>
                </tr>
                <tr>
                    <td class="titulo_campo">Comunidades autónomas visitadas</td>
                    <td class="dato_campo" id="autonomias_visitadas"></td>
                </tr>
                <tr>
                    <td colspan=2 class="titulo_total_puntos" id="total_puntos"></td>                    
                </tr>

                <tr>
                    <td colspan=2>
                        <table id="tbl_logros">
                        </table>    
                    </td>    
                </tr>
            </table>
        </div>
    </div>

    <script>
        function muestra_datos_globales(
            poblaciones, total_poblaciones, porcentaje_poblaciones,
            provincias, total_provincias, porcentaje_provincias,
            autonomias, total_autonomias, porcentaje_autonomias,
            total_puntos
        ) {
            document.getElementById("poblaciones_visitadas").innerHTML = poblaciones + " de un total de " + total_poblaciones + 
                " (" + porcentaje_poblaciones + " %)";
            document.getElementById("provincias_visitadas").innerHTML = provincias + " de un total de " + total_provincias + 
                " (" + porcentaje_provincias + " %)";
            document.getElementById("autonomias_visitadas").innerHTML = autonomias + " de un total de " + total_autonomias + 
                " (" + porcentaje_autonomias + " %)";
            document.getElementById("total_puntos").innerHTML = "TOTAL PUNTOS " + total_puntos + " puntos";
        }

        var fila_actual = null;
        function add_logro(elemento,num_item) {         
            console.log(elemento);

            num_items_por_fila = 5;
            porc = num_items_por_fila + "%";
            if (num_item % num_items_por_fila == 0) {            
                var row = document.createElement('tr');
                fila_actual = row;
            }
            else {
                row = fila_actual;
            }
            var col = document.createElement('td');  
            col.className = 'td_img';
            var clase_img = "img_logro";                
            if (elemento.conseguido == false) {
                var clase_img = "img_sin_logro";
            }       
            col.innerHTML = '<img class="'  + clase_img + '">';            
            col.style.width = porc;        
            row.appendChild(col);            
            var table = document.getElementById("tbl_logros");
            table.appendChild(row);
            
        }

        var usuario = '<?php echo $usuario; ?>';

        datos_ajax = {
            funcion: 'get_logros',
            usuario: usuario,
        }

        $.ajax ({
            url: 'http://127.0.0.1:8080/api/server.php',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(datos_ajax),
            dataType: "json",
            processData: false,
            method: "POST",
            success: function (data) {
                console.log('success', data);
            },
            error: function (data) {
                console.log('error', data);
            }
        }).done( function (resultado) {
            console.log(resultado);

            if (resultado.ok === true ) {
                muestra_datos_globales(
                    resultado.poblaciones_visitadas, resultado.poblaciones, resultado.porcentaje_poblaciones,
                    resultado.provincias_visitadas, resultado.provincias, resultado.porcentaje_provincias,
                    resultado.autonomias_visitadas, resultado.autonomias, resultado.porcentaje_autonomias,
                    resultado.total_puntos
                );
                
                if (resultado.logros.length > 0) {
                    console.log('numero logros',resultado.logros.length);                    
                    console.log(typeof resultado.logros);
                    
                    resultado.logros.forEach(add_logro);
                }
            }
        });
    </script>
</body>
