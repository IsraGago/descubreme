<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis servicios solicitados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./vistas/css/style.css">
</head>
<body>
    <main>
        <h1>Mis servicios solicitados</h1>
        <?php require "./vistas/nav.php" ?>
        <?php if (count($servicios)>0):?>
            <table class="table table-striped">
            <tr>
                <th>Usuario creador</th>
                <th>Titulo</th>
                <th>Fecha de creación</th>
                <th>Usuarios actuales</th>
                <th>Usuarios Maximos</th>
                <?php if(isset($datosSesion->codUsuario)):?>
                    <th>Desapuntarse</th>
                <?php endif;?>
            </tr>
            <?php foreach ($servicios as $clave => $servicio):?>
                <tr>
                    <td><?=$servicio->usuario?></td>
                    <td><a href="./servicio.php?codServicio=<?=$servicio->codServicio?>"><?=$servicio->titulo?></a></td>
                    <td><?=$servicio->fechaCreacion?></td>
                    <td><?=$servicio->numUsuariosActuales?></td>
                    <td><?=$servicio->maxUsuarios?></td>
                    <?php if(isset($datosSesion->codUsuario)):?>
                        <td><a href="./desapuntarUsuario.php?codServicio=<?=$servicio->codServicio?>" onclick="return confirm('¿Está seguro de que desea desapuntarse del servicio: <?=$servicio->titulo?>?')"><?=$chars["eliminar"]?></a></td>                            
                    <?php endif;?>
                </tr>
            <?php endforeach?>
        </table>
        <?php else:?>
            <p>Aún no has solicitado ningún servicio.</p>
        <?php endif;?>
        <p><a href="./perfil.php">Volver</a></p>
    </main>
</body>
</html>