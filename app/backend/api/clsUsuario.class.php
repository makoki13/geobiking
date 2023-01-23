<?php

include_once 'basededatos.php';

class Usuario {
    /***** funciones de edicion ***********/
    private static function update_registro($conexion,$datos) {
        $ok = true;

        $sql="
            update usuarios 
            set 
                nombre = $$" . $datos->nombre_usuario . "$$,
                clave = $$" . $datos->clave . "$$,
                fecha_alta = current_date,
                correo = $$" . $datos->correo . "$$
            where id=" . $datos->id . "
        ";
        $ok = $ok && db_actualiza($conexion,$sql);

        if (trim($datos->ultima_actualizacion)!='') {
            $sql="update usuarios set ultima_actualizacion = $$" . $datos->ultima_actualizacion . "$$ where id=" . $datos->id;    
        }
        $ok = $ok && db_actualiza($conexion,$sql);

        return $ok;
    }
    /***** FIN funciones de edicion ***********/

    public static function get_nombre($conexion,$usuario) {
        $sql="select nombre from usuarios where id = $usuario";
        return db_get_dato($conexion,$sql);
    }

    public static function get_datos($conexion,$usuario) {
        $sql="select * from usuarios where id = $usuario";        
        $registro = db_get_tabla($conexion,$sql,$filas);

        $nombre = pg_result($registro,0,'nombre');        
        $fecha_alta = pg_result($registro,0,'fecha_alta');
        $ultima_actualizacion = pg_result($registro,0,'ultima_actualizacion');

        $datos = new stdClass();
        $datos->id = $usuario;
        $datos->nombre = $nombre;
        $datos->fecha_alta = $fecha_alta;
        $datos->ultima_actualizacion = $ultima_actualizacion;

        return $datos;
    }

    public static function set_ultima_actualizacion($conexion,$usuario) {
        $sql="update usuarios set ultima_actualizacion=LOCALTIMESTAMP where id=$usuario";
        return db_actualiza($conexion,$sql);
    }

    public static function existe($conexion,$usuario) {
        $sql="select count(*) from usuarios where upper(trim(nombre))=$$" . strtoupper($usuario) . "$$";
        $filas = db_get_dato($conexion,$sql);
        return ($filas > 0);
    }

    public static function existe_id($conexion,$id) {
        $sql="select count(*) from usuarios where id=$id";
        $filas = db_get_dato($conexion,$sql);
        return ($filas > 0);
    }

    private static function get_nuevo_id($conexion) {
        $sql="select max(id) from usuarios";
        $id = db_get_dato($conexion,$sql);
        $nuevo_id = $id + 1;
        return $nuevo_id;
    }

    public static function crea_registro($conexion,$usuario) {
        $id = self::get_nuevo_id($conexion);
        $sql="insert into usuarios (id,nombre) values ($id,$$" . trim($usuario) . "$$)";
        $ok = db_actualiza($conexion,$sql);
        
        return (object) array("ok" => $ok, "id" => $id);
    }

    public static function borra_registro($conexion,$id) {
        $sql="delete from usuarios where id=$id";
        return db_actualiza($conexion,$sql);
    }

    public static function check_formulario_registro($conexion,$datos) {        
        $ok = true;
        $msg = '';

        /* el nombre de usuario no puede estar vacio */
        if (trim($datos->nombre_usuario) == '') {            
            return (object) array("ok" => false, "msg" => 'El código de usuario está vacio', "id_error" => 1);
        }
        
        /* el nombre de usuario no puede repetirse */       
        if (self::existe($conexion,trim($datos->nombre_usuario)) == true) {
            return (object) array( "ok" => false, "msg" => 'El cdigo de usuario ya existe', "id_error" => 2);
        }

        
        /* crear el registro para ese nombre de usuario */
        $datos_registro = self::crea_registro($conexion,$datos->nombre_usuario);
        if ($datos_registro->ok == false) {            
            return (object) array("ok" => false, "msg" => 'Error al crear el registro de usuario vacio', "id_error" => 0);
        }
        $nuevo_id = $datos_registro->id;

        /* el correo no puede estar vacio */
        if (trim($datos->correo) == '') {            
            self::borra_registro($conexion,$nuevo_id);
            return (object) array("ok" => false, "msg" => 'El correo de contacto está vacío', "id_error" => 3);
        }

        /* correo y correo_2 son iguales */
        if (trim(strtoupper($datos->correo)) != trim(strtoupper($datos->correo_2))) {            
            self::borra_registro($conexion,$nuevo_id);
            return (object) array("ok" => false, "msg" => 'Los correos no son el mismo', "id_error" => 4);
        }

        /* la clave no puede ser vacia */
        if (trim($datos->clave) == '') {    
            self::borra_registro($conexion,$nuevo_id);        
            return (object) array("ok" => false, "msg" => 'La contraseña está vacía', "id_error" => 5);
        }

        /* clave y clave_2 son iguales */
        if (trim(strtoupper($datos->clave)) != trim(strtoupper($datos->clave_2))) {            
            self::borra_registro($conexion,$nuevo_id);
            return (object) array("ok" => false, "msg" => 'Las contraseñas no coinciden', "id_error" => 6);
        }
        
        return (object) array("ok" => $ok, "msg" => $msg, "id" => $nuevo_id, "id_error" => 0);
    }
    
    public static function registra($conexion,$datos) {
        $ok = true;
        $msg = '';

        /* existe el registro? (debería de existir) */
        if (self::existe_id($conexion,$datos->id) == false) {
            $datos_registro = self::crea_registro($conexion,$datos->nombre_usuario);
            if ($datos_registro->ok == false) {
                return (object) array("ok" => false, "msg" => 'Error al crear el registro de usuario vacio');
            }
            $datos->id = $datos_registro->id;
        }

        /* actualizar registro */
        $datos->ultima_actualizacion='';
        $ok = self::update_registro($conexion,$datos);
        if ($ok == false) {
            return (object) array("ok" => false, "msg" => 'Error al crear el registro de usuario');
        }

        /*Enviar correo de confirmacion */
        $ok = self::envia_correo_de_confirmacion($datos);
        if ($ok == false) {
            return (object) array("ok" => false, "msg" => 'Error al enviar correo de confirmación');
        }

        return (object) array("ok" => $ok, "msg" => $msg);
    }

    public static function envia_correo_de_confirmacion($datos) {
        $clave = sprintf("%010d",$datos->id);
        $token = md5($clave . "20182010RMA1LVT2");
        $url_verificacion = 'http://127.0.0.1:8080/frontend/verificacion.php?token=' . $token;
        $direccion = $datos->correo;
                
        $titulo = 'Por favor, verifique la cuenta de geobiking';

        $texto = '';
        $texto .= '<html>';
        $texto .= '<head>';
        $texto .= '<script>';        
        $texto .= '</script>';
        $texto .= '</head>';
        $texto .= '<body>';
        $texto .= '<hr>';
        $texto .= '<p>Gracias por registrarse con geobiking. Por favor, verifique la cuenta pulsando en el siguiente botón';
        $texto .= '<form action="'.$url_verificacion.'">';
        $texto .= '<button type="submit"></button>';
        $texto .= '</form>';
        $texto .= '<p><p>o bien copie y abra en un navegador la siguiente direccion:';
        $texto .= '<p>' . $url_verificacion;
        $texto .= '<hr>';        
        $texto .= '</body>';
        $texto .= '</html>';

        mail($direccion,$titulo,$texto);


        return true;
    }
}