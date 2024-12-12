<?php
    require "conexion.php";
    require "autentificar.php";
    $servicios=$con->getServicios();

    require "./vistas/index.php"
    
?>