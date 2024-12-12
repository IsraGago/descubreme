<?php if(isset($datosSesion->codUsuario)):?>
        <p>Usuario: <a href="./perfil.php?codUsuario=<?=$datosSesion->codUsuario?>"><?=$datosSesion->usuario?></a></p>
        <p><a href="./cerrarSesion.php">Cerrar sesión</a></p>
<?php else:?>
        <p><a href="./login.php">Iniciar Sesión</a></p>
<?php endif;?>