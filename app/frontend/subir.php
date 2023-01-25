<?php

$usuario = $_POST['usuario'];
if (trim($usuario) == '') {
    $usuario = 0;
}

$funcion = $_POST['funcion'];

if ($funcion=="sube_archivo") {    
    if (trim(basename($_FILES['fichero_usuario']['name'])=='')) {
    ?>
        <script>alert("No se ha indicado ningún fichero");</script>;
    <?php    
    }
    else {
        $fichero_subido = "../../gpx/u" . $usuario .  "_" .  basename($_FILES['fichero_usuario']['name']);    
        $resp = move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido);
        if ($resp==false) {
?>
    <script>alert("Error al subir el fichero");</script>
<?php
    }
        else {
?>
    <script>alert("fichero subido correctamente. Recibirá un correo cuando el fichero haya sido procesado y actualizadas las estadísticas");</script>
<?php
        }
    }
}

?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Subir Archivos GPX</title>
    <link href="estilos.css" rel="stylesheet" type="text/css">

    <script>
        function ver_estadisticas() {
            document.getElementById("registro_logros").value = '<?php echo $usuario; ?>';
            document.getElementById("frm_logros").submit();
        }

        function atras() {
            document.getElementById("frm_inicio").submit();
        }
    </script>    
</head>

<body>
    <table style="width:100%;height:100%;">
        <tr>
            <td style="width:50%;">&nbsp;</td>
            <td style="min-width:700px;">
                <table style="width:100%;border:0px solid darkred;" rules="">
                    <tr>
                        <td>
                            <table style="height:100%;width:100%;" rules="">
                                <tr style="min-height:50px;">
                                    <td class="principal_titulo">GEOBIKING</td>
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
                                                <td class="texto_celda" style="min-width:300px;">Puntos:</td>
                                                <td style="width:100%;" id="puntos"></td>
                                            </tr>    
                                            <tr>
                                                <td class="texto_celda">Ultima actualización:</td>
                                                <td id="actualizacion"></td>
                                            </tr>    
                                        </table>
                                    </td>    
                                </tr>    
                                <tr>
                                    <td style="padding-top:20px;padding-bottom:20px;">                                        
                                        <table style="width:100%;">
                                            <tr>
                                                <td style="width:50%"></td>
                                                <td style="min-width:300px;text-align:center;">
                                                    <button type="submit" style="width:100%;" onclick="ver_estadisticas();">VER ESTADÍSTICAS</button>
                                                </td>
                                                <td class="titulo_logros" style="min-width:300px;text-align:center;" >
                                                    <button style="background-color:pink;width:100%;" onclick="atras();">SALIR</button>
                                                </td>
                                                <td style="width:50%"></td>
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
                                            <input type="hidden" name="nombre_usuario" value="" /> 
				                            <h5  class="texto_archivo"><i></i> Seleccione el archivo a subir: </h5> 
				                            <hr/>
				                            <input class="boton_fichero" name="fichero_usuario" type="file" />
                                            <hr/>
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

    <form id="frm_inicio" name="frm_inicio" action="../index.php" method="post" style="display:none;"></form>
    <form id="frm_logros" name="frm_logros" action="./logros.php" method="post" style="display:none;">
        <input type="hidden" id="registro_logros" name="logros_usuario" value="0">
    </form>        

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">

    <script>
        function get_datos() {
            datos_ajax = {
                funcion: 'get_datos_inicio',
                usuario: '<?php echo $usuario; ?>',
            }

            $.ajax ({
                url: 'http://127.0.0.1:8080/backend/api/server.php',
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