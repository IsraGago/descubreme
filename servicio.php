<?php
require "conexion.php";
require "autentificar.php";

$codServicio = $_GET["codServicio"] ?? "";
if (!(preg_match("/^[0-9]+$/",$codServicio))) {error();}


$mensaje ="";
$color = "red";

$servicio = $con->getServicio($codServicio);

$estaApuntadoAlServicio = $con->estaApuntado($datosSesion->codUsuario,$servicio->codServicio) ?? $estaAutentificado;

if(!isset($servicio->codServicio)){error();}

if (isset($_GET["solicitarServicio"],$datosSesion->codUsuario)) {
    if(!((int)$servicio->codUsuario === (int)$datosSesion->codUsuario)){ // son diferentes
        try {
            if(!$estaApuntadoAlServicio){
                $con->solicitarServicio($datosSesion->codUsuario,$codServicio);
                $mensaje ="Servicio solicitado con exito!";
                $color = "green";
                $estaApuntadoAlServicio = true;
            } else {
                $mensaje ="Ya has solicitado este servicio anteriormente.";
            }
            
        } catch (\Throwable $th) {
            $mensaje ="ERROR al solicitar el servicio. Comprueba si ya estás apuntado.";
        }
    } else { // son iguales
        $mensaje ="ERROR, no puedes solicitar tus propios servicios";
        
    }
}



require "./vistas/servicio.php";
?>