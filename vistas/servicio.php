<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$servicio->titulo?></title>
    <link rel="stylesheet" href="./vistas/css/style.css">
</head>
<body>
<h1><?=$servicio->titulo?></h1>
<?php require "./vistas/nav.php" ?>
    <table>
        <tr>
            <!-- <th>Código de servicio</th> -->
            <th>Usuario creador</th>
            <th>Fecha de creación</th>
            <th>Descripción</th>
            <th>Ubicación</th>
            <th>Número de usuarios actuales</th>
            <th>Número de usuarios máximos</th>
        </tr>
        <tr>
            <!-- <td><?=$servicio->codServicio?></td> -->
            <td><?=$servicio->usuario?></td>
            <td><?=$servicio->fechaCreacion?></td>
            <td><?=$servicio->descripcion?></td>
            <td><?=$servicio->ubicacion?></td>
            <td><?=$servicio->numUsuariosActuales?></td>
            <td><?=$servicio->maxUsuarios?></td>
        </tr>
    </table>
    <?php if (isset($datosSesion->codUsuario)):?>
        <p><a href="./servicio.php?codServicio=<?=$codServicio?>&solicitarServicio=si">Solicitar este servico</a></p>
        <span style="color: <?=$color?> ;"><?=$mensaje?></span>
        <?php else:?>
        <p>Para solicitar un servicio primero debes <a href="./login.php">Iniciar Sesion</a></p>
    <?php endif?>
    <p><a href="./">Volver</a></p>
</body>
</html>