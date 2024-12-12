<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?=$usuario->usuario?></title>
    <link rel="stylesheet" href="./vistas/css/style.css">
</head>
<body>
    <h1>Perfil de <?=$usuario->usuario?></h1>
    <?php require "./vistas/nav.php" ?>

    <p><a href="./verServiciosPublicados.php">Ver servicios publicados</a></p>
    <?php if($datosSesion->codUsuario = $codUsuario || $datosSesion->admin): ?>
        <p><a href="./verServiciosSolicitados.php">Ver servicios solicitados</a></p>
    <?php endif;?>
</body>
</html>