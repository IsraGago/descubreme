<?php
require "conexion.php";
require "autentificar.php";

if (!isset($datosSesion->codUsuario)) { error();}
$codServicio = $_GET["codServicio"] ?? "";
if ($codServicio == ""){ error();}

try {
        $con->desapuntarUsuario($datosSesion->codUsuario,$codServicio);
    } 
catch (\Throwable $th) {
        echo "ERROR: No se ha podido desapuntar al usuario del servicio";
    }
 header("location:verServiciosSolicitados.php");
?>