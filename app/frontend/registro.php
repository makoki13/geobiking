<?php
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script>  
        document.addEventListener('focusin', function() {
            console.log('focused: ', document.activeElement)
        }, true);

        function todo_ok() {
            alert("Registrado!\nBusque en su cliente de correo el correo electrónico que le hemos enviado para confirmar su registro. Gracias.");
        }

        function muestra_mensaje_error(mensaje) {
            alert(mensaje);
        }

        function test_formulario() {
            var ok = true;

            console.log('paso 1');

            ok = test_usuario();
            if (!ok) return false;

            console.log('paso 2');

            ok = test_email_1();
            if (!ok) return false;

            console.log('paso 3');

            ok = test_email_2();
            if (!ok) return false;

            console.log('paso 4');

            ok = test_clave_1();
            if (!ok) return false;

            console.log('paso 5');

            ok = test_clave_2();
            if (!ok) return false;

            console.log('paso final');

            return ok;
        }

        function test_usuario() {            
            var o = document.getElementById('username');
            if ($.trim(o.value) == "") {                        
                muestra_mensaje_error("El usuario no puede estar vacio");
                if (!event.currentTarget.contains(event.relatedTarget)) {                    
                    event.stopPropagation();
                    event.preventDefault();                    
                    o.focus();
                    return false;
                }
            }
            return true;
        }

        function test_mail(o) {     
            if ($.trim(o.value) == '') {                
                muestra_mensaje_error("La dirección de correo no puede quedar vacia");
                if (!event.currentTarget.contains(event.relatedTarget)) {                    
                    event.stopPropagation();
                    event.preventDefault();                                        
                    o.focus();
                    o.select();
                    return false;
                }
            }

            const res = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var ok = res.test(String(o.value).toLowerCase());
            if (ok === false) {
                muestra_mensaje_error("La dirección de correo no parece correcta");
                if (!event.currentTarget.contains(event.relatedTarget)) {                    
                    event.stopPropagation();
                    event.preventDefault();                                        
                    o.focus();
                    o.select();
                    return false;
                }
            }

            return true;
        }

        function test_email_1() {
            var o = document.getElementById('email');                        
            var resp = test_mail(o);            
            if (!resp) {                
                return false;
            }

            return true;
        }

        function test_email_2() {            
            var o = document.getElementById('email2');
            var resp = test_mail(o);            
            if (!resp) {                
                return false;
            }

            email = document.getElementById('email').value;
            email2 = document.getElementById('email2').value;

            if ($.trim(email) != $.trim(email2)) {
                muestra_mensaje_error("La dirección de correo y su comprobación no coinciden");
                o.focus();
                o.select();
                return false;
            }

            return true;
        }

        function test_clave(o) {
            if ($.trim(o.value) == '') {                
                muestra_mensaje_error("La clave no puede quedar vacia");
                if (!event.currentTarget.contains(event.relatedTarget)) {                    
                    event.stopPropagation();
                    event.preventDefault();                                        
                    o.focus();
                    o.select();
                    return false;
                }
            }

            return true;
        }

        function test_clave_1() {
            var o = document.getElementById('password');
            var resp = test_clave(o);
            if (!resp) {                
                return false;
            }

            return true;
        }

        function test_clave_2() {
            var o = document.getElementById('password2');
            var resp = test_clave(o);
            if (!resp) {                
                return false;
            }

            clave = document.getElementById('password').value;
            clave2 = document.getElementById('password2').value;

            if ($.trim(clave) != $.trim(clave2)) {
                muestra_mensaje_error("La clave y su comprobación no coinciden");
                o.focus();
                o.select();
                return false;
            }

            return true;
        }

        function pre_registro(o) {            
            o.disabled = true;
            if (test_formulario()===true) {
                registra();
            }
            o.disabled = false;
            
            return false;
        }
    </script>
</head>
    <body onload = "javascript:document.getElementById('username').focus();">
    <header>
        <link href="estilos.css" rel="stylesheet" type="text/css">
    </header>
    <nav>
        <div>
            <div>
                <table style="width:100%;">                    
                    <tr>
                        <td style="width:50%;"></td>
                        <td style="min-width:600px;">
                            <table style="width:100%;border:2px solid black;" rules="none">
                                <tr>
                                    <td colspan="2" class="titulo">ALTA DE NUEVO USUARIO</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:50px;"></td>
                                </tr>

                                <tr>
                                    <td class="etiqueta_registro">Nombre de usuario (max. 30 caracteres)</td>
                                </tr>    
                                <tr>
                                    <td style=padding-left:15px;padding-right:15px;">
                                        <input type="text" id="username" name="username" maxlength="25" class="input_registro" 
                                            onchange="test_usuario();">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:15px;"></td>
                                </tr>

                                <tr>
                                    <td class="etiqueta_registro">Correo electrónico</td>
                                </tr>    
                                <tr>
                                    <td style=padding-left:15px;padding-right:15px;">
                                        <input type="text" id="email" name="email" class="input_registro"
                                            onchange="test_email_1();">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:15px;"></td>
                                </tr>

                                <tr>
                                    <td class="etiqueta_registro">Repita el correo electrónico</td>
                                </tr>    
                                <tr>
                                    <td style=padding-left:15px;padding-right:15px;">
                                        <input type="text" id="email2" name="email2" class="input_registro"
                                        onchange="test_email_2();">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:15px;"></td>
                                </tr>

                                <tr>
                                    <td class="etiqueta_registro">Contraseña</td>
                                </tr>    
                                <tr>
                                    <td style=padding-left:15px;padding-right:15px;">
                                        <input type="password" id="password" name="password" class="input_registro"
                                            onchange="test_clave_1();">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:15px;"></td>
                                </tr>

                                <tr>
                                    <td class="etiqueta_registro">Repita la contraseña</td>
                                </tr>    
                                <tr>
                                    <td style=padding-left:15px;padding-right:15px;">
                                        <input type="password" id="password2" name="password2" class="input_registro"
                                        onchange="test_clave_2();">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:50px;"></td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align:center;">
                                        <button onclick="pre_registro(this);">Registrarme</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:15px;"></td>
                                </tr>
                            </table>                            
                        </td>    
                        <td style="width:50%;"></td>
                    <tr>    
                </table>
            </div>
        </div>
    </nav>    

    <script>
        function registra() {
        datos_ajax = {
            funcion: 'registra',
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
                todo_ok();
            }
            else {
                muestra_mensaje_error(resultado.msg);
            }
        });
        }
    </script>
</body>

</html>