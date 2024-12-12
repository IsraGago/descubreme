<?php
require "conexion.php";
require "auntentificar.php";

$codUsuario = $_GET["codUsuario"] ?? $datosSesion->codUsuario ?? "";
$usuario = $con->getUsuario($codUsuario);

print_r($usuario);

?>