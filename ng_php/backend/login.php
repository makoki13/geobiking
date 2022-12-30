<?php
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
    <body>
    <header>
        <link href="estilos.css" rel="stylesheet" type="text/css">
        <h1>Guide to Search Engines</h1>
    </header>
    <nav>
        <div class="contenedor">
            <div class="centrado">
                <form action="/register" method="post">
                    <label for="email">Correo electrónico:</label><br>
                    <input type="email" id="email" name="email"><br>
                    <label for="username">Nombre de usuario:</label><br>
                    <input type="text" id="username" name="username"><br>
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password"><br><br>
                    <input type="submit" value="Registrarme">
                </form>
            </div>
        </div>
    </nav>
    <footer>
        <p>Copyright Makoki Enterprises &copy;</p>
    </footer>

    <script>
        datos_ajax = {
            funcion: 'test',
        }

        $.ajax ({
            url: 'http://127.0.0.1:8080/api/database.php',
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
        });
    </script>
</body>

</html>