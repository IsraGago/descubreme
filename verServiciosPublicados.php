<?php
require "conexion.php";
require "autentificar.php";

$servicios = $con->getServiciosUsuario($datosSesion->codUsuario);

// print_r($servicios);
require "./vistas/verServiciosPublicados.php"
?>