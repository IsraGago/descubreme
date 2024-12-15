<?php
require "conexion.php";
require "autentificar.php";

for ($i=1; $i < 6; $i++) { 
    echo "Servicio: $i";
    echo "<br>";
    if($con->estaApuntado($datosSesion->codUsuario,$i)){
        
        echo "Está apuntado";
        echo "<br>";
    } else {
        echo "NO está apuntado";
        echo "<br>";
    }
    echo "<br>";
}

?>