<?php
    require "conexion.php";
    require "autentificar.php";
    $servicios=$con->getServicios();
    // print_r($servicios);

    require "./vistas/index.php"
?>