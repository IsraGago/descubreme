<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DescubreMe | Registrate</title>
    <link rel="stylesheet" href="./vistas/css/login.css">
</head>

<body class="login">
    <div class="login-page">
        <div class="form">
            <h1>Registrate</h1>
            <form class="login-form" method="post" action="./registrarUsuario.php">
                <input type="text" placeholder="Usuario" name="usuario">
                <input type="password" class="password" placeholder="Contraseña" name="password">
                <input type="password" class="password" placeholder="Confirmar contraseña" name="password2">
                <button>Registrate</button>
                <p><span style='color: <?=$color?>'><?=$mensaje?></span></p>
                <p>¿Ya tienes una cuenta? <a href="./login.php">Inicia sesión</a></p>
            </form>
        </div>
    </div>
</body>
