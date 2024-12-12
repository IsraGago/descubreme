<?php
require "conexion.php";
require "autentificar.php";

$servicios = $con->getServiciosSolicitados($datosSesion->codUsuario);

require "./vistas/verServiciosSolicitados.php"
?>