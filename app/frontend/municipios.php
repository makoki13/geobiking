<?php

$usuario = $_POST['usuario'];
if (trim($usuario) == '') {
    die("Error: falta el usuario");
}

$provincia = $_POST['provincia'];
if (trim($provincia) == '') {
    die("Error: falta la provincia");
}

?>

<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="./estilos.css" rel="stylesheet" type="text/css">

        <script>
            var usuario = '<?php echo $usuario; ?>';
            var provincia = '<?php echo $provincia; ?>';
            
            function muestra_mensaje_error(mensaje) {
                alert(mensaje);
            }

            function atras() {
                document.getElementById("registro_logros").value = usuario;
                document.getElementById("frm_logros").submit();
            }

            function xchg_boton(o) {                
                boton_pulsado.style.backgroundColor = 'white';
                o.style.backgroundColor = 'pink';
                boton_pulsado = o;                
            }

            function todos(o) {
                if (boton_pulsado != o) {
                    xchg_boton(o);                    
                    $(".todos").show()
                }
                
            }

            function visitados(o) {
                $(".todos").hide()
                if (boton_pulsado != o) {
                    xchg_boton(o);
                    $(".visitados").show()
                }                
            }

            function pendientes(o) {
                $(".todos").hide()
                if (boton_pulsado != o) {
                    xchg_boton(o);
                    $(".pendientes").show()
                }
            }
        </script>    
    </head>

    <body>
        <table style="width:100%;height:100%;">
            <tr>
                <td style="width:50%;"></td>
                <td style="min-width:1200px;">
                    <table style="width:100%;border:0px solid darkred;" rules="all">
                        <tr style="background-color:palegreen;">
                            <td>
                                <table style="width:100%;">
                                    <tr>
                                        <td class="principal_titulo" id="titulo"></td>
                                        <td class="titulo_logros" style="min-width:100px;" >
                                            <button style="background-color:pink;" onclick="atras();">ATRAS</button>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            
                        </tr>
                        <tr style="background-color:palegreen;">
                            <td>
                                <table style="width:100%;">
                                    <tr>
                                        <td style="width:50%;"></td>
                                        <td class="titulo_logros" style="min-width:200px;" >
                                            <button id="btn_todos" style="background-color:pink;width:100%;" onclick="todos(this);">TODOS</button>
                                        </td>
                                        <td class="titulo_logros" style="min-width:200px;" >
                                            <button id="btn_visitados" style="background-color:white;width:100%;" onclick="visitados(this);">VISITADOS</button>
                                        </td>
                                        <td class="titulo_logros" style="min-width:200px;" >
                                            <button id="btn_pendientes" style="background-color:white;width:100%;" onclick="pendientes(this);">PENDIENTES</button>
                                        </td>
                                        <td style="width:50%;"></td>
                                    </tr>
                                </table>
                            </td>    
                            
                        </tr>
                        <tr>
                            <td>
                                <table id="tabla" rules="all">
                                </table>    
                            </td>
                        </tr>
                    </table>        
                </td>
                <td style="width:50%;"></td>
            </tr>
        </table>

        <form id="frm_logros" name="frm_logros" action="./logros.php" method="post" style="display:none;">
            <input type="hidden" id="registro_logros" name="logros_usuario" value="0">
        </form>

        <script>
            function carga_datos() {
                datos_ajax = {
                    funcion: 'carga_municipios',                    
                    usuario: usuario,
                    provincia: provincia,
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
                        document.getElementById('tabla').innerHTML = resultado.datos;
                        document.getElementById('titulo').innerHTML = "LISTADO DE POBLACIONES DE LA PROVINCIA DE " + resultado.nombre_provincia;

                    }
                    else {
                        muestra_mensaje_error(resultado.msg);
                    }
                });
            }

            var boton_pulsado = document.getElementById('btn_todos');
            carga_datos();
        </script>    
    </body>
</html>
