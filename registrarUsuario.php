<?php
require "conexion.php";
require "autentificar.php";

$mensaje ="";
$color = "red";

$password = $_POST["password"] ?? "";
$password2 = $_POST["password2"] ?? "";
$usuario = $_POST["usuario"] ?? "";

if(isset($_POST["password"],$_POST["password2"],$_POST["usuario"])){

    $passwordHash = "";

    if($password == $password2){
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        // $mensaje =$con->insertarUsuario($usuario,$passwordHash);
        try {
            if($con->insertarUsuario($usuario,$passwordHash)){
                $color = "green";
                $mensaje ="Usuario registrado";
            } else{
                $mensaje ="ERROR";
            }
            

        } catch (\Throwable $th) {
            $mensaje ="No se ha podido registrar al usuario.";
            print_r($th);
        }
    } else {
        $mensaje = "Las contraseñas no son iguales";
    }

}


require "./vistas/registrarUsuario.php";
?>