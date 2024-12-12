<?php
require "conexion.php";
require "autentificar.php";

$codServicio = $_GET["codServicio"] ?? "";
if (!(preg_match("/^[123456789]+$/",$codServicio))) {error();}

$mensaje ="";
$color = "red";

$servicio = $con->getServicio($codServicio);
if(!isset($servicio->codServicio)){error();}

if (isset($_GET["solicitarServicio"],$datosSesion->codUsuario)) {
    if(!((int)$servicio->codUsuario === (int)$datosSesion->codUsuario)){ // son diferentes
        try {
            $con->solicitarServicio($datosSesion->codUsuario,$codServicio);
            $mensaje ="Servicio solicitado con exito!";
            $color = "green";
        } catch (\Throwable $th) {
            $mensaje ="ERROR al solicitar el servicio, comprueba si ya lo habías solicitado.";
        }
    } else { // son iguales
        $mensaje ="ERROR, no puedes solicitar tus propios servicios";
        
    }
}

require "./vistas/servicio.php";
?>