<?php
require "conexion.php";
require "autentificar.php";

$codUsuario = $_GET["codUsuario"] ?? $datosSesion->codUsuario ?? "";
if($codUsuario == ""){ error();}
$usuario = $con->getUsuario($codUsuario);
if(!isset($usuario->codUsuario)){ error();}


// print_r($usuario);
require "./vistas/perfil.php"
?>