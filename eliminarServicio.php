<?php
require "conexion.php";
require "autentificar.php";

if (!isset($datosSesion->codUsuario)) { error();}
$codServicio = $_GET["codServicio"] ?? "";
if ($codServicio == ""){ error();}

try {
        $con->eliminarServicio($datosSesion->codUsuario,$codServicio);
    } 
catch (\Throwable $th) {
        echo "ERROR: No se ha podido eliminar el servicio";
    }
 header("location:index.php");
?>