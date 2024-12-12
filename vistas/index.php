<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="./vistas/css/style.css">
</head>
<body>
    <h1>Servicios</h1>
    <?php require "./vistas/nav.php" ?>
    <table>
        <tr>
            <th>Usuario</th>
            <th>Titulo</th>
            <th>Fecha de creación</th>
            <th>Usuarios actuales</th>
            <th>Usuarios Maximos</th>
        </tr>
        <?php foreach ($servicios as $clave => $servicio):?>
            <tr>
                <td><?=$servicio->usuario?></td>
                <td><a href="./servicio.php?codServicio=<?=$servicio->codServicio?>"><?=$servicio->titulo?></a></td>
                <td><?=$servicio->fechaCreacion?></td>
                <td><?=$servicio->numUsuariosActuales?></td>
                <td><?=$servicio->maxUsuarios?></td>
            </tr>
        <?php endforeach?>
    </table>
</body>
</html>