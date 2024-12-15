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
    function editarUsuario($codUsuario,$nombre,$apellido1,$apellido2,$telefono,$admin,$habilitado){

        $sql="UPDATE usuarios set nombre=:nombre,apellido1=:apellido1,apellido2=:apellido2,telefono=:telefono,admin=:admin,habilitado=:habilitado,fechaUltimaModificacion=now() WHERE codUsuario=:codUsuario";
        // $sql="UPDATE usuarios set nombre=:nombre,apellido1=:apellido1,apellido2=:apellido2,telefono=:telefono WHERE codUsuario=:codUsuario";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellido1", $apellido1);
        $stmt->bindParam(":apellido2", $apellido2);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":admin", $admin);
        $stmt->bindParam(":habilitado", $habilitado);
        $stmt->bindParam(":codUsuario", $codUsuario);
        if($stmt->execute()){
            return true;
        } else {
            // Captura el error de la base de datos
            $errorInfo = $stmt->errorInfo();
            // Devuelve el mensaje de error
            return $errorInfo[2];
        }

    }
    function deshabilitarUsuario($codUsuario){
        $sql="UPDATE usuarios set habilitado=0 where codUsuario=:codUsuario";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codUsuario", $codUsuario);
        if($stmt->execute()){
            return true;
        } else {
            // Captura el error de la base de datos
            $errorInfo = $stmt->errorInfo();
            // Devuelve el mensaje de error
            return $errorInfo[2];
        }
    }
    function getUsuarios($habilitados=null){
        if(is_null($habilitados)){
            $WHERE="";
        }
        elseif($habilitados){
            $WHERE="WHERE habilitado=1";
        }
        elseif(!$habilitados){
            $WHERE="WHERE habilitado=0";
        }
        $sql="SELECT * from usuarios $WHERE ORDER BY fechaAlta";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        $usuarios=[];
        while ($usuario = $stmt->fetch(PDO::FETCH_OBJ)) {
            $usuarios[] = $usuario;
        }
        if($usuarios[0]->codUsuario==0){
            unset($usuarios[0]);
        }
        
        return $usuarios;

    }
    function getNotificaciones($codUsuario){
        $sql="SELECT i.*,u.email,u.rutaFoto
        from incidencias i
        inner join prioridades p on p.codPrioridad=i.codPrioridad
        inner join usuarios u on u.codUsuario=i.codUsuario
        WHERE codAdminAsignado=$codUsuario AND solucionada=0
        order by fechaInsercion desc";


        $stmt = $this->prepare($sql);
        $stmt->execute();
        $mensajes=[];
        while ($mensaje = $stmt->fetch(PDO::FETCH_OBJ)) {
            $mensajes[] = $mensaje;
        }
        return $mensajes;

    }
    function getMisIncidencias($codUsuario,$verSolucionadas=null){
        if(is_null($verSolucionadas)){
            $WHERE="WHERE u.codUsuario=$codUsuario";
        }
        elseif($verSolucionadas){
            $WHERE="WHERE u.codUsuario=$codUsuario AND solucionada=1";
        }
        elseif(!$verSolucionadas){
            $WHERE="WHERE u.codUsuario=$codUsuario AND solucionada=0";
        }
        $sql="SELECT i.*,tipo,prioridad,a.email,a.rutaFoto,e.nombre as nombreEquipo
                from incidencias i inner join tipoIncidencia t
                on i.codTipo=t.codTipo
                inner join prioridades p on p.codPrioridad=i.codPrioridad
                inner join usuarios u on u.codUsuario=i.codUsuario
                inner join equipos e on e.codEquipo=i.codEquipo
                inner join admins a on a.codUsuario=i.codAdminAsignado
                $WHERE
                order by fechaInsercion desc";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        $incidencias=[];
        while ($incidencia = $stmt->fetch(PDO::FETCH_OBJ)) {
            $incidencias[] = $incidencia;
        }
        return $incidencias;
        
    }
    function getIncidencias($verSolucionadas=false,$codAdmin=null){
        if($verSolucionadas){
            $WHERE="";
        }
        else{
            $WHERE="WHERE solucionada=0";
            if(!is_null($codAdmin)){
                $WHERE.=" AND codAdminAsignado=$codAdmin";
            }
        }
        

        $sql="
        SELECT i.*,tipo,prioridad,u.email,u.rutaFoto,e.nombre as nombreEquipo
        from incidencias i inner join tipoIncidencia t
        on i.codTipo=t.codTipo
        inner join prioridades p on p.codPrioridad=i.codPrioridad
        inner join usuarios u on u.codUsuario=i.codUsuario
        inner join equipos e on e.codEquipo=i.codEquipo
        $WHERE
        order by fechaInsercion desc;     
           ";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        $incidencias=[];
        while ($incidencia = $stmt->fetch(PDO::FETCH_OBJ)) {
            $incidencias[] = $incidencia;
        }
        return $incidencias;
    }
    function cambiarFoto($codUsuario,$ruta){
        $sql="UPDATE usuarios set rutaFoto=:ruta where codUsuario=:codUsuario";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codUsuario", $codUsuario);
        $stmt->bindParam(":ruta", $ruta);
        if($stmt->execute()){
            return true;
        } else {
            // Captura el error de la base de datos
            // $errorInfo = $stmt->errorInfo();
            
            // Devuelve el mensaje de error
            // return $errorInfo[2];
        }
    }
    function actualizarPassword($codUsuario, $password){
        $sql = "UPDATE usuarios SET password=:password, fechaUltimaModificacion=now(), habilitado=1 WHERE codUsuario=:codUsuario";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codUsuario", $codUsuario);
        $stmt->bindParam(":password", $password);
        if($stmt->execute()){
            return true;
        } else {
            // Captura el error de la base de datos
            $errorInfo = $stmt->errorInfo();
            // Devuelve el mensaje de error
            return $errorInfo[2];
        }
    }
    


    function getDatosAdmin($codAdmin){
        $sql = "SELECT * FROM usuarios WHERE codUsuario=:codAdmin";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codAdmin", $codAdmin);
        $stmt->execute();
        if ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            return $fila;
        }
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

    function insertarUsuario($email,$admin,$nombre,$apellido1,$apellido2,$telefono){
        if($apellido2==""){
            $apellido2=null;
        }
        if($telefono==""){
            $telefono=null;
        }
        if($admin==""){
            $admin=0;
        }
        if($admin){
            $sql="INSERT into usuarios (email,admin,nombre,apellido1,apellido2,telefono) values(:email,:admin,:nombre,:apellido1,:apellido2,:telefono)";
        }else{
            $sql="INSERT into usuarios (email,nombre,apellido1,apellido2,telefono) values(:email,:nombre,:apellido1,:apellido2,:telefono)";
        }
        $stmt=$this->prepare($sql);
        $stmt->bindParam(":email", $email);
        if($admin){
            $stmt->bindParam(":admin", $admin);
        }
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellido1", $apellido1);
        $stmt->bindParam(":apellido2", $apellido2);
        $stmt->bindParam(":telefono", $telefono);
        if($stmt->execute()) {
            return $this->lastInsertId();
        } else {
            // Recoge el código de error y la información de error
            $errorInfo = $stmt->errorInfo();
            $errorCode = $errorInfo[0];
            $errorMessage = $errorInfo[2];
            
            // Puedes hacer lo que necesites con el código de error y el mensaje de error
            // echo "Error al ejecutar la consulta. Código de error: $errorCode. Mensaje de error: $errorMessage";
            
            return false;
        }
    }
    function updateIncidencia($codIncidencia,$codPrioridad,$codAdmin){
        $sql="UPDATE incidencias set codPrioridad=:codPrioridad,codAdminAsignado=:codAdmin where codIncidencia=:codIncidencia";
        $stmt=$this->prepare($sql);
        $stmt->bindParam(":codIncidencia", $codIncidencia);
        $stmt->bindParam(":codPrioridad", $codPrioridad);
        $stmt->bindParam(":codAdmin", $codAdmin);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    function getCodigosIncidencias(){
        $sql="SELECT codIncidencia from incidencias";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $codigos=[];
        while ($codigo = $stmt->fetch(PDO::FETCH_OBJ)) {
            $codigos[] = $codigo->codIncidencia;
        }
        return $codigos;
    }
    function getComentariosIncidencia($codIncidencia){
        $sql="SELECT c.*,email from comentarios c inner join usuarios u on c.codUsuario=u.codUsuario where codIncidencia=:codIncidencia order by fechaInsercion asc";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codIncidencia", $codIncidencia);
        $stmt->execute();
        $comentarios=[];
        while ($comentario = $stmt->fetch(PDO::FETCH_OBJ)) {
            $comentarios[] = $comentario;
        }
        return $comentarios;
    }
    function getAdmins(){
        $sql="SELECT * from admins";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $admins=[];
        while ($admin = $stmt->fetch(PDO::FETCH_OBJ)) {
            $admins[] = $admin;
        }
        return $admins;
    }
   
    function insertarIncidencia($codTipo,$codPrioridad,$codEquipo,$incidencia,$codUsuario){
        $sql="INSERT into incidencias(codTipo,codPrioridad,codEquipo,incidencia,codUsuario)
              values (:codTipo,:codPrioridad,:codEquipo,:incidencia,:codUsuario)";
              $stmt=$this->prepare($sql);
              $stmt->bindParam(":codUsuario", $codUsuario);
              $stmt->bindParam(":codPrioridad",$codPrioridad);
              $stmt->bindParam(":codEquipo", $codEquipo);
              $stmt->bindParam(":incidencia", $incidencia);
              $stmt->bindParam(":codTipo", $codTipo);
                if($stmt->execute()){
                    return true;  
                }
                return false;
    }

    

    function getPrioridades(){
        $sql="SELECT * FROM prioridades";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $prioridades=[];
        while ($prioridad = $stmt->fetch(PDO::FETCH_OBJ)) {
            $prioridades[] = $prioridad;
        }
        return $prioridades;
    }

    function getEquipos(){
        $sql="SELECT * FROM equipos";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $equipos=[];
        while ($equipo = $stmt->fetch(PDO::FETCH_OBJ)) {
            $equipos[] = $equipo;
        }
        return $equipos;
    }

    function getNumIncidenciasUsuario($codUsuario){
        $sql = "Select count(*) as numIncidencias from incidencias where codUsuario=:codUsuario";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codUsuario", $codUsuario);
        $stmt->execute();
        if ($numero=$stmt->fetchObject())
            return $numero->numIncidencias;
        
    }

    function getIncidenciasUsuario($codUsuario){
        $sql="Select * from incidencias where codUsuario=:codUsuario";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":codUsuario", $codUsuario);
        $stmt->execute();
        $incidencias=[];
        while ($incidencia = $stmt->fetch(PDO::FETCH_OBJ)) {
            $incidencias[] = $incidencia;
        }
        return $incidencias;
    }
    
    function solucionarIncidencia($codIncidencia){
        $sql="update incidencias set solucionada=1 where codIncidencia=:codIncidencia";
        $stmt=$this->prepare($sql);
        $stmt->bindParam(":codIncidencia", $codIncidencia);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
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
        
        $sql = "SELECT s.codServicio,u.usuario,s.titulo,s.fechaCreacion,s.numUsuariosActuales,s.maxUsuarios FROM usuarios_servicios us inner join servicios s on s.codServicio = us.codServicio inner join usuarios u on u.codUsuario = us.codUsuario where us.codUsuario =:codUsuario";      
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