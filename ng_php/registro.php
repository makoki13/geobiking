<?php
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    function todo_ok() {
        alert("Registrado!\nBusque en su cliente de correo el correo electrónico que le hemos enviado para confirmar su registro. Gracias.");
    }

    function muestra_mensaje_error(mensaje) {
        alert(mensaje);
    }
</head>
    <body>
    <header>
        <link href="estilos.css" rel="stylesheet" type="text/css">
        <h1>Alta de nuevo usuario</h1>
    </header>
    <nav>
        <div class="contenedor">
            <div class="centrado">
                <form action="registra(this)" method="post">
                    <label for="username">Nombre de usuario:</label><br>
                    <input type="text" id="username" name="username"><br>

                    <label for="email">Correo electrónico:</label><br>
                    <input type="email" id="email" name="email"><br>

                    <label for="email">Repita el correo electrónico:</label><br>
                    <input type="email" id="email_2" name="email_2"><br>
                    
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password"><br><br>

                    <label for="password">Repita la contraseña:</label><br>
                    <input type="password" id="password_2" name="password_2"><br><br>

                    <input type="submit" value="Registrarme">
                </form>
            </div>
        </div>
    </nav>
    <footer>
        <p>Copyright Makoki Enterprises &copy;</p>
    </footer>

    <script>
        function registra() {
        datos_ajax = {
            funcion: 'registra',
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