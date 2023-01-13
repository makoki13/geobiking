<?php

$usuario = $_POST['usuario'];
if (trim($usuario) == '') {
    $usuario = 0;
}

$funcion = $_POST['funcion'];

if ($funcion=="sube_archivo") {    
    $fichero_subido = "../../gpx/" . basename($_FILES['fichero_usuario']['name']);    
    $resp = move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido);
    if ($resp==false) {
?>
        <sript>alert("Error al subir el fichero");</script>
<?php
    }
    else {
?>
        <script>alert("fichero subido correctamente");</script>
<?php
    }
}

?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Subir Archivos GPX</title>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
    <table rules="all">
        <tr>
            <td style="width:50%;">&nbsp;</td>
            <td style="min-width:600px;">
                <table style="width:100%;border:2px solid darkred;" rules="all">
                    <tr>
                        <td>
                            <table style="background-color:palegreen;height:100%;width:100%;" rules="all">
                                <tr style="min-height:50px;">
                                    <td class="titulo">
                                        GEOBICKING
                                    </td>    
                                </tr>
                                <tr style="min-height:100px;">
                                    <td style="border:2px solid black;">
                                        <table style="height:100%;width:100%;">
                                            <tr>
                                                <td id="nombre_usuario">&nbsp;</td>
                                            </tr>                                            
                                        </table>
                                    </td>    
                                </tr>    
                                <tr style="height:100%;">
                                    <td style="border:2px solid black;">
                                        <table style="height:100%;width:100%;">
                                            <tr>
                                                <td class="texto_celda" style="min-width:260px;">Puntos:</td>
                                                <td style="width:100%;" id="puntos"></td>
                                            </tr>    
                                            <tr>
                                                <td class="texto_celda">Ultima actualización:</td>
                                                <td id="actualizacion"></td>
                                            </tr>    
                                        </table>
                                    </td>    
                                </tr>    
                                <tr style="min-height:550px;">
                                    <td style="padding-top:20px;padding-bottom:20px;">                                        
                                        <table style="width:100%;">
                                            <tr>
                                                <td style="text-align:center;">
                                                    <button type="submit">VER ESTADÍSTICAS</button>
                                                </td>
                                            </tr>
                                        </table>                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style="background-color:palegoldenrod;height:100%;width:100%;">
                                <tr>
                                    <td>
                                        <form enctype="multipart/form-data" action="subir.php" method="POST"> 
			                                <input type="hidden" name="MAX_FILE_SIZE" value="30000000" /> 
                                            <input type="hidden" name="funcion" value="sube_archivo" /> 
                                            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>" /> 
                                            <input type="hidden" name="nombre_usuario" value="<?php echo $nombre_usuario; ?>" /> 
				                            <h5  class="texto_archivo"><i></i> Seleccione el archivo a subir: </h5> 
				                            <hr/>
				                            <input name="fichero_usuario" type="file" />
				                            <button class="submit" type="submit">Subir Archivo</button> 
			                            </form> 
                                    </td>    
                                </tr>                                
                            </table>
                        </td>    
                    </tr>  
                    
                    <tr>
                        <td>
                            <table style="background-color:pink;height:100%;width:100%;">
                                <tr>
                                    <td class="anyo" style="width:100%;text-align:center;">
                                        <?php echo date("d-m-Y"); ?>
                                    </td>    
                                </tr>                                
                            </table>
                        </td>
                    </tr>
                </table>    
            </td>
            <td style="width:50%;">&nbsp;</td>
        </tr>    
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">

    <script>
        function get_datos() {
            datos_ajax = {
                funcion: 'get_datos_inicio',
                usuario: '<?php echo $usuario; ?>',
            }

            $.ajax ({
                url: 'http://127.0.0.1:8080/api/server.php',
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(datos_ajax),
                dataType: "json",
                processData: false,
                method: "POST",
                success: function (data) {
                    
                },
                error: function (data) {
                    console.log('error', data);
                }
            }).done( function (resultado) {
                if (resultado.ok === true ) {
                    document.getElementById("nombre_usuario").innerHTML = resultado.nombre_usuario;
                    document.getElementById("puntos").innerHTML = resultado.total_puntos;
                    document.getElementById("actualizacion").innerHTML = resultado.ultima_actualizacion;
                }
            });
        }

        get_datos();
    </script>    
</body>
</html>