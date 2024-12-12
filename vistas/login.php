<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DescubreMe</title>
    <link rel="stylesheet" href="./vistas/css/style.css">
</head>
<body>
    <h1>Login para DescubreMe</h1>
    <form action="./login.php" method="POST">
        <input type="text" name="usuario" placeholder="Nombre de usuario">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="submit" value="Iniciar sesión">
        <br />
        <br />
        <span style="color : <?=$color?>;"><?=$mensaje?></span>
    </form>
</body>
</html>