<?php
    session_name('descubreMe');
    session_start();
    // if (!isset($_SESSION['datosSesion'])){header("Location:login.php");exit;};
    $datosSesion = $_SESSION['datosSesion'] ?? "";
    // if (!$datosSesion->habilitado){fuera();}
?>