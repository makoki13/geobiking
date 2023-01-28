<?php
    $usuario = $_POST['usuario'];
    if (trim($usuario) == '') {
        $usuario = 0;
    }
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">

    <script>
        var url_server = 'http://127.0.0.1:8080/backend/api/server.php';
        var boton_anterior = null;
        function selecciona(o) {
            if (o == boton_anterior) {                
                //return;
            }            
            if (boton_anterior!=null) {
                boton_anterior.classList.remove('seleccionado');
            }
            o.classList.add('seleccionado');
            boton_anterior = o;

            if (o.id == "btn_general") {
                ver_logros_general();
            } else if (o.id == "btn_provincia") {
                ver_logros_provincia();
            } else {
                ver_logros_autonomia();
            }
        }

        function atras() {            
            document.getElementById("frm_subir").submit();
        }

        function ver_localidades(provincia) {                        
            document.getElementById("usuario").value = "<?php echo $usuario; ?>";
            document.getElementById("provincia").value = provincia;
            document.getElementById("frm_municipios").submit();
            event.stopPropagation();
            event.preventDefault();
        }
    </script>
</head>
<body>
    <table style="width:100%;height:100%;">
        <tr>
            <td style="width:50%;"></td>
            <td style="min-width:600px;">
                <table style="width:100%;border:2px solid black;" rules="none" cellpadding="10px">
                    <tr>
                        <td colspan="2">
                            <table style="width:100%;background-color:palegoldenrod;">
                                <tr>
                                    <td id="titulo_logros" class="principal_titulo" style="width:100%;" ></td>
                                    <td class="titulo_logros" style="min-width:100px;" >
                                        <button style="background-color:pink;" onclick="atras();">ATRAS</button>
                                    </td>
                                </tr>    
                            </table>    
                        </td>                           
                    </tr>
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
                            <table id="tabla_menu" style="width:100%;visibility:hidden;">
                                <tr>
                                    <td style="width:50%">&nbsp;</td>
                                    <td style="min-width:260px">
                                        <button id="btn_general" class="btn_logros" onclick="selecciona(this);">GENERAL</button>
                                    </td>
                                    <td style="min-width:260px">
                                        <button id="btn_provincia" class="btn_logros" onclick="selecciona(this);">POR PROVINCIA</button>
                                    </td>
                                    <td style="min-width:360px">
                                        <button id="btn_autonoma" class="btn_logros" onclick="selecciona(this);">POR COMUNIDAD AUTÓNOMA</button>
                                    </td>
                                    <td style="width:50%">&nbsp;</td>
                                </tr>
                            </table>
                        </td>    
                    </tr>

                    <tr>
                        <td colspan=2>
                            <table id="tbl_logros">
                            </table>    
                        </td>    
                    </tr>
                </table>
            </td>
            <td style="width:50%;"></td>
        </tr>

        <form id="frm_subir" name="frm_subir" action="./subir.php" method="post" style="display:none;"></form>

        <form id="frm_municipios" name="frm_municipios" action="./municipios.php" method="post" style="display:none;">
            <input type="hidden" id="usuario" name="usuario" value="0">
            <input type="hidden" id="provincia" name="provincia" value="0">
        </form>        
    </table>
    
    <script>
        function inicializa() {
            //boton_anterior = document.getElementById("btn_general");
            ver_logros_globales();
        }

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
            num_items_por_fila = 5;
            porc = num_items_por_fila + "%";
            if (num_item % num_items_por_fila == 0) {
                var row = document.createElement('tr');
                fila_actual = row;
            }
            else {
                row = fila_actual;
            }

            var celda_tabla = document.createElement('td');  
            var tabla =  document.createElement('table'); 
            var fila_tabla = document.createElement('tr');


            var col = document.createElement('td');  
            col.className = 'td_img';
            var clase_img = "img_logro";
            if (elemento.conseguido == false) {
                var clase_img = "img_sin_logro";
            }       

            var logo_elemento = '';            
            if ((elemento.logo != null) && (elemento.conseguido == true))  {
                logo_elemento = 'src="../backend/imagenes/' + elemento.logo + '.png"';
            }

            col.innerHTML = '<img class="'  + clase_img + '" ' + logo_elemento + '>';                        
            col.style.width = porc;        
            fila_tabla.appendChild(col); 

            var fila_tabla_2 = document.createElement('tr');
            var col = document.createElement('td');  
            col.innerHTML = elemento.nombre ;
            col.className = 'td_descripcion';
            if (elemento.conseguido == true) {
                col.className = 'td_descripcion_bold';
            }            
            fila_tabla_2.appendChild(col); 

            tabla.appendChild(fila_tabla);
            tabla.appendChild(fila_tabla_2);
            tabla.border = 2;

            celda_tabla.appendChild(tabla);
            row.appendChild(celda_tabla);
            
            var table = document.getElementById("tbl_logros");
            //var table = document.getElementById(parametros.tabla);
            table.appendChild(row);            
        }

        function add_provinciales(elemento) {
            //var tabla =  document.createElement('table'); 
            var fila_tabla = document.createElement('tr');
            var celda_tabla = document.createElement('td'); 
            
            var tabla_autonomia =  document.createElement('table'); 
            var fila_autonomia = document.createElement('tr');
            var celda_autonomia = document.createElement('td');  

            celda_autonomia.innerHTML = elemento.nombre_autonomia ;
            celda_autonomia.className = 'autonomia';
            fila_autonomia.appendChild(celda_autonomia);
            tabla_autonomia.appendChild(fila_autonomia);

            var num_items_por_fila = 5;
            var porc = num_items_por_fila + "%";
            
            elemento.provincias.forEach(function(item) {     
                console.log(item);

                fila_provincia = document.createElement('tr');
                celda_provincia = document.createElement('td');   
                
                var tabla_item_provincia =  document.createElement('table'); 
                var fila_item_provincia = document.createElement('tr');
                celda_provincia.className = "fila_provincia";
                fila_item_provincia.style.cursor="pointer";
                fila_item_provincia.onclick = function() {
                    console.log(item.nombre_provincia)
                    if (document.getElementById(item.nombre_provincia).style.display=='') {
                        document.getElementById(item.nombre_provincia).style.display="none";
                    }
                    else {
                        document.getElementById(item.nombre_provincia).style.display="";
                    }                    
                }
                
                var celda_item_provincia= document.createElement('td');                   
                celda_item_provincia.innerHTML = item.nombre_provincia ;
                celda_item_provincia.className = 'provincia';
                fila_item_provincia.appendChild(celda_item_provincia);

                var celda_item_provincia= document.createElement('td');   
                celda_item_provincia.className="celda_datos_provincia";
                celda_item_provincia.innerHTML = item.poblaciones + " poblaciones" ;                
                fila_item_provincia.appendChild(celda_item_provincia);

                var celda_item_provincia= document.createElement('td');
                celda_item_provincia.className="celda_datos_provincia";
                if (item.visitadas > 0) {
                    celda_item_provincia.innerHTML = item.visitadas + " visitadas" ;                
                }   
                else {
                    celda_item_provincia.innerHTML = "&nbsp;" ;                
                }
                fila_item_provincia.appendChild(celda_item_provincia);

                var celda_item_provincia= document.createElement('td');
                celda_item_provincia.className="celda_datos_provincia";   
                if (item.visitadas > 0) {
                    celda_item_provincia.innerHTML = item.porcentaje + "%" ;
                }
                else {
                    celda_item_provincia.innerHTML = "&nbsp;" ;
                }
                fila_item_provincia.appendChild(celda_item_provincia);

                var celda_item_provincia= document.createElement('td');
                celda_item_provincia.className="celda_datos_provincia";   
                celda_item_provincia.innerHTML = "<button style='background-color:white;' onclick='ver_localidades(" + item.id_provincia + ");'>" + 
                    "<img class='imagen_boton_localidades' src='../backend/imagenes/city.jpg'></button>" ;
                fila_item_provincia.appendChild(celda_item_provincia);

                tabla_item_provincia.appendChild(fila_item_provincia);

                var fila_item_logros = document.createElement('tr');
                fila_item_logros.style.display="none";
                fila_item_logros.id = item.nombre_provincia;

                item.logros.forEach(function(elemento,num_item) {                    
                    var celda_tabla = document.createElement('td');  
                    var tabla =  document.createElement('table'); 
                    var fila_tabla = document.createElement('tr');


                    var col = document.createElement('td');  
                    col.className = 'td_img';
                    var clase_img = "img_logro";
                    if (elemento.conseguido == false) {
                        var clase_img = "img_sin_logro";
                    }       

                    var logo_elemento = '';            
                    if ((elemento.logo != null) && (elemento.conseguido == true))  {
                        logo_elemento = 'src="./imagenes/' + elemento.logo + '.png"';
                    }

                    col.innerHTML = '<img class="'  + clase_img + '" ' + logo_elemento + '>';                        
                    col.style.width = porc;        
                    fila_tabla.appendChild(col); 

                    var fila_tabla_2 = document.createElement('tr');
                    var col = document.createElement('td');  
                    col.innerHTML = elemento.nombre ;
                    col.className = 'td_descripcion';
                    if (elemento.conseguido == true) {
                        col.className = 'td_descripcion_bold';
                    }            
                    fila_tabla_2.appendChild(col); 

                    tabla.appendChild(fila_tabla);
                    tabla.appendChild(fila_tabla_2);
                    tabla.border = 2;

                    celda_tabla.appendChild(tabla);
                    fila_item_logros.appendChild(celda_tabla);                      
                });
                tabla_item_provincia.appendChild(fila_item_logros);

                celda_provincia.appendChild(tabla_item_provincia);
                fila_provincia.appendChild(celda_provincia);
                
                tabla_autonomia.appendChild(fila_provincia);                
            });
                                    
            celda_tabla.appendChild(tabla_autonomia);
            fila_tabla.appendChild(celda_tabla);

            tbl_logros.appendChild(fila_tabla);
        }

        function add_autonomias(elemento) {
            var fila_tabla = document.createElement('tr');
            var celda_tabla = document.createElement('td'); 
            
            var tabla_autonomia =  document.createElement('table'); 
            var fila_autonomia = document.createElement('tr');
            var celda_autonomia = document.createElement('td');  

            celda_autonomia.innerHTML = elemento.nombre_autonomia ;
            celda_autonomia.className = 'autonomia_2';
            fila_autonomia.appendChild(celda_autonomia);

            celda_autonomia = document.createElement('td');   
            celda_autonomia.className="celda_datos_provincia";
            celda_autonomia.innerHTML = elemento.poblaciones + " poblaciones" ;                
            fila_autonomia.appendChild(celda_autonomia);

            celda_autonomia = document.createElement('td');
            celda_autonomia.className="celda_datos_provincia";
            if (elemento.visitadas > 0) {
                celda_autonomia.innerHTML = elemento.visitadas + " visitadas" ;                
            }   
            else {
                celda_autonomia.innerHTML = "&nbsp;" ;                
            }
            fila_autonomia.appendChild(celda_autonomia);

            celda_autonomia = document.createElement('td');
            celda_autonomia.className="celda_datos_provincia";   
            if (elemento.visitadas > 0) {
                celda_autonomia.innerHTML = elemento.porcentaje + "%" ;
            }
            else {
                celda_autonomia.innerHTML = "&nbsp;" ;
            }
            fila_autonomia.appendChild(celda_autonomia);

            tabla_autonomia.appendChild(fila_autonomia);

            celda_tabla.appendChild(tabla_autonomia);
            fila_tabla.appendChild(celda_tabla);

            tbl_logros.appendChild(fila_tabla);
        }

        var usuario = '<?php echo $usuario; ?>';

        function ver_logros_general() {
            datos_ajax = {
                funcion: 'get_logros_general',
                usuario: usuario,
            }

            $.ajax ({
                url: url_server,
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
                    /* muestra_datos_globales(
                        resultado.poblaciones_visitadas, resultado.poblaciones, resultado.porcentaje_poblaciones,
                        resultado.provincias_visitadas, resultado.provincias, resultado.porcentaje_provincias,
                        resultado.autonomias_visitadas, resultado.autonomias, resultado.porcentaje_autonomias,
                        resultado.total_puntos
                    ); */
                    
                    if (resultado.logros.length > 0) {
                        document.getElementById('tbl_logros').innerHTML = "";                    
                        var params={tabla_datos:"tbl_logros"};
                        resultado.logros.forEach(add_logro);
                    }

                    //document.getElementById("tabla_menu").style.visibility = 'visible';
                }
            });
        }

        function ver_logros_globales() {
            datos_ajax = {
                funcion: 'get_logros_globales',
                usuario: usuario,
            }

            $.ajax ({
                url: url_server,
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
                    muestra_datos_globales(
                        resultado.poblaciones_visitadas, resultado.poblaciones, resultado.porcentaje_poblaciones,
                        resultado.provincias_visitadas, resultado.provincias, resultado.porcentaje_provincias,
                        resultado.autonomias_visitadas, resultado.autonomias, resultado.porcentaje_autonomias,
                        resultado.total_puntos
                    );

                    document.getElementById('titulo_logros').innerHTML = "Logros del usuario " + resultado.nombre_usuario;

                    //ver_logros_general();
                    document.getElementById("tabla_menu").style.visibility = 'visible';
                }
            });            
        }

        function ver_logros_provincia() {
            datos_ajax = {
                funcion: 'get_logros_provincia',
                usuario: usuario,
            }

            $.ajax ({
                url: url_server,
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
                    document.getElementById('tbl_logros').innerHTML = "";                    
                    if (resultado.datos_provinciales.length > 0) {                        
                        resultado.datos_provinciales.forEach(add_provinciales);
                    }
                    document.getElementById("tabla_menu").style.visibility = 'visible';
                }
            });
        }

        function ver_logros_autonomia() {
            console.log('ver_logros_autonomia');

            datos_ajax = {
                funcion: 'get_logros_autonomia',
                usuario: usuario,
            }

            $.ajax ({
                url: url_server,
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
                    document.getElementById('tbl_logros').innerHTML = "";                    
                    if (resultado.datos_autonomicos.length > 0) {                        
                        resultado.datos_autonomicos.forEach(add_autonomias);
                    }
                    document.getElementById("tabla_menu").style.visibility = 'visible';
                }
            });
        }

        inicializa();        
    </script>
</body>
