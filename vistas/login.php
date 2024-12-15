<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DescubreMe | Iniciar sesión</title>
    <link rel="stylesheet" href="./vistas/css/login.css">
</head>

<body class="login">
    <div class="login-page">
        <div class="form">
            <h1>Iniciar sesión</h1>
            <form class="login-form" method="post" action="./login.php">
                <input type="text" placeholder="Usuario" name="usuario">
                <input type="password" class="password" placeholder="Contraseña" name="password">
                <button>Iniciar Sesión</button>
                <p><span style='color: red'><?=$mensaje?></span></p>
            </form>
        </div>
    </div>
</body>
