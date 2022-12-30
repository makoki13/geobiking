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
            </table>
        </div>
    </div>

    <script>
        function muestra_datos_globales(
            poblaciones, total_poblaciones, porcentaje_poblaciones,
            provincias, total_provincias, porcentaje_provincias,
            autonomias, total_autonomias, porcentaje_autonomias
        ) {
            document.getElementById("poblaciones_visitadas").innerHTML = poblaciones + " de un total de " + total_poblaciones + 
                " (" + porcentaje_poblaciones + " %)";
            document.getElementById("provincias_visitadas").innerHTML = provincias + " de un total de " + total_provincias + 
                " (" + porcentaje_provincias + " %)";
                document.getElementById("autonomias_visitadas").innerHTML = autonomias + " de un total de " + total_autonomias + 
                " (" + porcentaje_autonomias + " %)";
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
                    resultado.autonomias_visitadas, resultado.autonomias, resultado.porcentaje_autonomias
                );
            }
        });
    </script>
</body>
