<?php
?>

<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="./frontend/estilos.css" rel="stylesheet" type="text/css">

        <script>
            function entrar() {
                var usuario = document.getElementById("usuario").value;
                if ($.trim(usuario) == '') {
                    alert("El usuario no puede quedar en blanco");
                    document.getElementById('usuario').focus();
                    return;
                }
                
                var clave = document.getElementById("pass").value;                
                if ($.trim(clave) == '') {
                    alert("La clave no puede quedar en blanco");
                    document.getElementById('pass').focus();
                    return;
                }
                
                datos_ajax = {
                    funcion: 'check_registro',                    
                    usuario: usuario,
                    clave: clave,
                }

                $.ajax ({
                    url: 'http://127.0.0.1:8080/backend/api/server.php',
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
                    if (resultado.ok === true) {
                        //entra_logros(resultado.id_usuario);
                        entra_subir(resultado.id_usuario);
                    }
                    else {
                        muestra_mensaje_error(resultado.msg);
                        document.getElementById('usuario').focus();
                        document.getElementById('usuario').select();                    
                    }
                });
            }

            function registrarse() {
                document.getElementById("registro_usuario").value = "0";
                document.getElementById("frm_registro").submit();
            }

            function entra_logros(id_usuario) {
                document.getElementById("registro_logros").value = id_usuario;
                document.getElementById("frm_logros").submit();
            }

            function entra_subir(id_usuario) {
                document.getElementById("registro_subir").value = id_usuario;
                document.getElementById("frm_subir").submit();
            }

            function muestra_mensaje_error(mensaje) {
                alert(mensaje);
            }
        </script>    
    </head>
    <body onload="document.getElementById('usuario').focus();">
        <table style="width:100%;height:100%;">
            <tr>
                <td style="width:50%;"></td>
                <td style="min-width:600px;">
                    <table>
                        <tr>
                            <td class="principal_titulo">GEOBIKING</td>
                        </tr>
                        
                        <tr>
                            <td class="principal_leyenda_1">Determinar por cual de los municipios de España has pasado a partir de los ficheros <b>GPX</b> que subas al sistema</td>
                        </tr>
                        
                        <tr>
                            <td style="padding-top:20px;">
                                <table style="width:100%;border:2px solid black;">
                                    <tr>
                                        <td class="principal_seccion" colspan="2">Entrar al sistema</td>                            
                                    </tr>    
                                    <tr>
                                        <td>
                                            <table style="width:100%;">
                                                <tr>
                                                    <td class="principal_campo" style="min-width:100px;">Usuario:</td>
                                                    <td style="width:100%;"><input type="text" id="usuario" placeholder="Nombre de usuario"></td>
                                                </tr>
                                                <tr>
                                                    <td class="principal_campo">Contraseña:</td>
                                                    <td><input type="password"  id="pass" placeholder="Contraseña"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="principal_celda_entrar">
                                                        <button class="principal_entrar" onclick="entrar();">ENTRAR</button>
                                                    </td>
                                                </tr>
                                            </table>    
                                        </td>    
                                    </tr>    
                                </table>
                            </td>                        
                        </tr>

                        <tr>
                            <td class="principal_celda_registrar">
                                <button class="inicio_boton_pie" onclick="registrarse();">No estoy registrado y quiero registrarme</button>
                            </td>
                        <tr>

                        <tr>
                            <td class="principal_celda_registrar"><button class="inicio_boton_pie">A Y U D A</button></td>
                        <tr>
                    </table>
                </td>    
                <td style="width:50%;"></td>
            </tr>
        </table>
        
        <form id="frm_registro" name="frm_registro" action="frontend/registro.php" method="post" style="display:none;">
            <input type="hidden" id="registro_usuario" name="registro_usuario" value="0">
        </form>
        <form id="frm_logros" name="frm_logros" action="frontend/logros.php" method="post" style="display:none;">
            <input type="hidden" id="registro_logros" name="logros_usuario" value="0">
        </form>        
        <form id="frm_subir" name="frm_subir" action="frontend/subir.php" method="post" style="display:none;">
            <input type="hidden" id="registro_subir" name="usuario" value="0">
        </form>
        <script>

        </script>    
    </body>
</html>