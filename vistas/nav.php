<nav>
        <?php if(isset($datosSesion->codUsuario)):?>
                <p>Usuario: <a href="./perfil.php?codUsuario=<?=$datosSesion->codUsuario?>"><?=$datosSesion->usuario?></a></p>
                <p><a href="./cerrarSesion.php">Cerrar sesión</a></p>
                <p><a href="./publicarServicio.php">Publicar un nuevo servicio</a></p>
        <?php else:?>
                <p><a href="./login.php">Iniciar Sesión</a></p>
        <?php endif;?>
                <p><a href="./index.php">Volver al inicio</a></p>
</nav>
<hr>