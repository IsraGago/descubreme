<?php
class Conexion extends PDO
{
    private const SERVIDOR_BD = '6gpe8.h.filess.io:3305';
    private const USUARIO_BD = 'appConjunta_turndance';
    private const PASSWORD_BD = '6264969cbd635585af7ef3ea17a3b74b1348774d';
    private const BD = 'appConjunta_turndance';
    private const DSN = 'mysql:host=' . self::SERVIDOR_BD . ';dbname=' . self::BD . ';charset=UTF8';
    public function __construct()
    {
        parent::__construct(self::DSN, self::USUARIO_BD, self::PASSWORD_BD);
    }
    function getDatosUsuario(string $usuario, string $password) // : object|null No se por que me lo subraya
    {
        $sql = "SELECT * FROM usuarios WHERE usuario=:usuario";

        $stmt = $this->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        if ($datosUsuario = $stmt->fetchObject())
            if (password_verify($password, $datosUsuario->password))
                return $datosUsuario;
        return null;
    }

    function getHashUsuario($codUsuario){
        $sql="SELECT fechaUltimaModificacion from usuarios where codUsuario=$codUsuario";
        $stmt=$this->prepare($sql);
        $stmt->execute();
        if ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $fechaUltimaModificacion=$fila->fechaUltimaModificacion;
        }
        
        return hash("sha512",$codUsuario."X"."$fechaUltimaModificacion"."XD");
    }

    function getServicios(){
        $sql="Select u.usuario,s.codServicio,u.codUsuario,s.titulo,s.fechaCreacion,s.descripcion,s.numUsuariosActuales,s.maxUsuarios from servicios s inner join usuarios u on s.codUsuario = u.codUsuario";
        $stmt=$this->prepare($sql);
        $stmt->execute();
        $servicios=[];
        while ($servicio = $stmt->fetch(PDO::FETCH_OBJ)) {
        $servicios[] = $servicio;
        }
        return $servicios;

    }

    function getServiciosSolicitados($codUsuario){
        // $sql="Select u.usuario,s.codServicio,u.codUsuario,s.titulo,s.fechaCreacion,s.numUsuariosActuales,s.maxUsuarios from servicios s inner join usuarios u on s.codUsuario = u.codUsuario where u.codUsuario = :codUsuario";
        
        $sql = "SELECT s.codServicio,s.usuario,s.titulo,s.fechaCreacion,s.numUsuariosActuales,s.maxUsuarios FROM usuarios_servicios us inner join servicios s on s.codServicio = us.codServicio inner join usuarios u on u.codUsuario = us.codUsuario where us.codUsuario =:codUsuario";      
        $stmt=$this->prepare($sql);
        $stmt->bindParam(":codUsuario",$codUsuario);
        $stmt->execute();
        $servicios=[];
        while ($servicio = $stmt->fetch(PDO::FETCH_OBJ)) {
        $servicios[] = $servicio;
        }
        return $servicios;
    }
    function getServiciosUsuario($codUsuario){
        $sql="Select u.usuario,s.codServicio,u.codUsuario,s.titulo,s.fechaCreacion,s.descripcion,s.numUsuariosActuales,s.maxUsuarios from servicios s inner join usuarios u on s.codUsuario = u.codUsuario where u.codUsuario = :codUsuario";
        $stmt=$this->prepare($sql);
        $stmt->bindParam(":codUsuario",$codUsuario);
        $stmt->execute();
        $servicios=[];
        while ($servicio = $stmt->fetch(PDO::FETCH_OBJ)) {
        $servicios[] = $servicio;
        }
        return $servicios;

    }

    function getServicio($codServicio){
        $sql="SELECT s.*,u.usuario from servicios s inner join usuarios u on s.codUsuario=u.codUsuario where codServicio=:codServicio";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codServicio", $codServicio);
        $stmt->execute();
        if ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            return $fila;
        }
    }

    function solicitarServicio($codUsuario,$codServicio){
        $sql="INSERT INTO usuarios_servicios (codUsuario,codServicio) VALUES ($codUsuario,:codServicio)";
        $stmt=$this->prepare($sql);
        $stmt->bindParam(":codServicio", $codServicio);

        return $stmt->execute();
    }

    function estaApuntado($codUsuario, $codServicio) {
        $sql = "SELECT codUsuario FROM usuarios_servicios WHERE codUsuario = :codUsuario AND codServicio = :codServicio";
        $stmt = $this->prepare($sql);
    
        $stmt->bindParam(':codUsuario', $codUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':codServicio', $codServicio, PDO::PARAM_INT);
    
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_OBJ);
    
        return  $fila !== false;
    }

    function getUsuario($codUsuario){
        $sql = "SELECT * FROM usuarios WHERE codUsuario=:codUsuario";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codUsuario", $codUsuario);
        $stmt->execute();
        if ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            return $fila;
        }
        return false;
    }

    function insertarServicio($codUsuario,$titulo,$ubicacion,$maxUsuarios,$descripcion){
        $sql="INSERT into servicios(codUsuario,titulo,ubicacion,maxUsuarios,descripcion)
              values (:codUsuario,:titulo,:ubicacion,:maxUsuarios,:descripcion)";
              $stmt=$this->prepare($sql);
              $stmt->bindParam(":codUsuario", $codUsuario);
              $stmt->bindParam(":titulo", $titulo);
              $stmt->bindParam(":ubicacion", $ubicacion);
              $stmt->bindParam(":maxUsuarios", $maxUsuarios);
              $stmt->bindParam(":descripcion", $descripcion);

            return $stmt->execute();
    }

    function eliminarServicio($codUsuario,$codServicio){
        $sql="DELETE from servicios where codUsuario=$codUsuario AND codServicio=:codServicio ";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codServicio", $codServicio);
        return $stmt->execute();
    }

    function desapuntarUsuario($codUsuario,$codServicio){
        $sql="DELETE from usuarios_servicios where codUsuario=$codUsuario AND codServicio=:codServicio ";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codServicio", $codServicio);
        return $stmt->execute();
    }

    function insertarUsuario($usuario, $passwordHash) {
        $sql = 'INSERT INTO usuarios(usuario, password) VALUES (:usuario, :passwordHash)';
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":usuario", $usuario); 
        $stmt->bindParam(":passwordHash", $passwordHash);
        return $stmt->execute();
    }
    

}

$con = new Conexion();

function fuera(){
    header("location:cerrarSesion.php");
    exit;
};

$chars=['altavoz'=>"\u{1F4E3}",'añadir'=>"\u{2795}",'eliminar'=>"\u{274C}",'editar'=>"✏",'visualizar'=>'👁'];

function esEntero($numero){
    return preg_match("/^\d+$/",$numero);
}

function error(){
    header('Location:404.php');
}
function noAdmin(){
    header('Location:noAdmin.php');
}