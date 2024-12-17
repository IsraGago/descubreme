<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar servicio</title>
    <link rel="stylesheet" href="./vistas/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <main>
        <h1>Publicar servicio</h1>
        <p><a href="./">Inicio</a></p>
        <form action="./publicarServicio.php" method="POST" id="publicarServicio">
            <input type="text" name="titulo" placeholder="Título" value="<?=$titulo?>"> <br>
            <input type="text" name="ubicacion" placeholder="Ubicación" value="<?=$ubicacion?>"><br>
            <input type="number" name="maxUsuarios" placeholder="Número máximo de personas"value="<?=$maxUsuarios?>"><br>
            <textarea name="descripcion" placeholder="Descripción" value="<?=$descripcion?>"></textarea><br>
            <input type="submit" value="Publicar servicio" >
        </form>
        <p><span sytle="color : <?=$color?>;"><?=$mensaje?></span></p>
    </main>
</body>

</html>