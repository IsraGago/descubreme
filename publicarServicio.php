<?php
require "conexion.php";
require "autentificar.php";

if(!isset($datosSesion->codUsuario)){ error();}

$titulo = $_POST["titulo"] ?? "";
$ubicacion = $_POST["ubicacion"] ?? "";
$maxUsuarios = $_POST["maxUsuarios"] ?? "";
$descripcion = $_POST["descripcion"] ?? "";
$mensaje ="";
$color = "red";

if(isset($_POST["titulo"],$_POST["ubicacion"],$_POST["maxUsuarios"],$_POST["descripcion"])){

    if(esEntero($maxUsuarios)){
        try {
            $con->insertarServicio($datosSesion->codUsuario,$titulo,$ubicacion,$maxUsuarios,$descripcion);
            $mensaje ="Servicio insertado con éxito";
            $color = "green";
        } catch (\Throwable $th) {
            //throw $th;
            $mensaje ="ERROR: no se ha podido insertar el servicio.";
        }
    } else {
        $mensaje ="ERROR: el campo de usuarios máximos debe ser un número entero.";
    }
}

require "./vistas/publicarServicio.php";
?>