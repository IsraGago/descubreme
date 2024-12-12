<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis servicios publicados</title>
    <link rel="stylesheet" href="./vistas/css/style.css">
</head>
<body>
    <h1>Mis servicios publicados</h1>
    <?php require "./vistas/nav.php" ?>
    <?php if (count($servicios)>0):?>
    <table>
        <tr>
            <th>Titulo</th>
            <th>Fecha de creación</th>
            <th>Usuarios actuales</th>
            <th>Usuarios Maximos</th>
            <?php if(isset($datosSesion->codUsuario)):?>
                <th>Eliminar</th>
            <?php endif;?>
        </tr>
        <?php foreach ($servicios as $clave => $servicio):?>
            <tr>
                <td><a href="./servicio.php?codServicio=<?=$servicio->codServicio?>"><?=$servicio->titulo?></a></td>
                <td><?=$servicio->fechaCreacion?></td>
                <td><?=$servicio->numUsuariosActuales?></td>
                <td><?=$servicio->maxUsuarios?></td>
                <?php if(isset($datosSesion->codUsuario)):?>
                    <?php if( (int)$datosSesion->codUsuario === (int)$servicio->codUsuario || $datosSesion->admin):?>
                        <td><a  href="./eliminarServicio.php?codServicio=<?=$servicio->codServicio?>" onclick="return confirm('¿Está seguro de que desea eliminar el servicio: <?=$servicio->titulo?>?')"><?=$chars["eliminar"]?></a></td>                            
                    <?php endif;?>
                <?php endif;?>
            </tr>
        <?php endforeach?>
    </table>
    <?php else:?>
        <p>Aún no has publicado ningún servicio.</p>
    <?php endif;?>
    <p><a href="./perfil.php">Volver</a></p>
</body>
</html>