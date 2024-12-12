<?php
    $mensaje = "";
    $color = "red";
    if (isset($_POST["usuario"],$_POST["password"])){
        require "./conexion.php";
        $usuario=$_POST["usuario"];
        $password=$_POST["password"];
        $datosUsuario = $con->getDatosUsuario($usuario,$password); 

        if ($datosUsuario) {
            session_name('descubreMe');
            session_start();
            $_SESSION['datosSesion'] = $datosUsuario;
            header("Location:index.php");
            exit;
        } else {
            $mensaje ="Error en los datos de inicio de sesión";
        }
    }
    
require "./vistas/login.php"
?>