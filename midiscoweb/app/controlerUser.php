<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------
include_once 'configDB.php';
include_once 'modeloUser.php';
include_once 'modeloUserDB.php';

/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlUserInicio(){
    modeloUserDB::modeloinit();
    $msg = "";
    $user ="";
    $clave ="";
    $numFicheros ="";
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['clave'])){
            $user =$_POST['user'];
            $clave=$_POST['clave'];
            if ( modeloUserDB::OkUser($user,$clave)){
                $_SESSION['user'] = $user;
                $_SESSION['tipouser'] = modeloUserDB::ObtenerTipo($user);
                $_SESSION['estado'] = modeloUserDB::ObtenerEstado($user);
                if ( $_SESSION['tipouser'] == "M�ster"){
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    header('Location:index.php?orden=VerUsuarios');
                }
                else {
                    $_SESSION['modo']= GESTIONFICHEROS;
                    if($_SESSION['estado'] == 'Activo'){
                        header('Location:index.php?orden=VerFicheros');
                    } else {
                        $msg = "Su usuario no esta activo";
                        session_destroy();
                    }
                }
            }
            else {
                $msg="Error: usuario y contraseña no válidos.";
            }
        }
    }
    
    include_once 'plantilla/facceso.php';
}

// Cierra la sesión y vuelca los datos
function ctlUserCerrar(){
    session_destroy();
    modeloUserDB::closeDB();
    header('Location:index.php');
}

// Muestro la tabla con los usuario 
function ctlUserVerUsuarios (){
    // Obtengo los datos del modelo
    $usuarios = modeloUserDB::GetAll();
    // Invoco la vista
    include_once 'plantilla/verusuariosp.php';
   
}
function ctlUserAlta(){
    $msg = "";
    $usuario = "";
    $clave = "";
    $clave2 = "";
    $correo = "";
    $tipo = "";
    $estado = "";
    $nombre = "";
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['user']) && isset($_POST['clave']) && isset($_POST['correo'])  && isset($_POST['estado']) && isset($_POST['nombre']) && isset($_POST['tipo'])) {
            $usuario= $_POST['user'];
            $nombre = $_POST['nombre'];
            $clave = $_POST['clave'];
            $clave2= $_POST['clave2'];
            $correo = $_POST['correo'];
            $tipo = $_POST['tipo'];
            $estado = $_POST['estado'];
            
            $nuevo = [
                $clave,
                $nombre,
                $correo,
                $tipo,
                $estado,
                $clave2
            ];
            
            if (!modeloUserDB::errorValoresAlta($usuario, $nuevo)) {
               $claveencriptada =modeloUserDB::modeloUserEncriptar( $_POST['clave']);
               $nuevoencriptado = [
                   $claveencriptada,
                   $nombre,
                   $correo,
                   $tipo,
                   $estado,
                   $clave2
               ];
               modeloUserDB::UserAdd($usuario, $nuevoencriptado);
               modeloUserDB::GetAll();
               header('Location:index.php?orden=VerUsuarios');
           }else {
                $msg = modeloUserDB::errorValoresAlta($usuario, $nuevo);
                include_once 'plantilla/fnuevo.php';
           }
        }
    } else {
        include_once 'plantilla/fnuevo.php';
    }
}

function ctlUserDetalles(){
    $clave=$_GET['id'];
    $listadetalles = modeloUserDB::UserGet($clave);
    $nombre=$listadetalles[2];
    $correo=$listadetalles[3];
    $tipo=$listadetalles[4];
    $plan=PLANES[$tipo];
    $ruta = "app/dat/". $clave;
    $numFicheros = modeloDatos($ruta);
    $espacioOcupado = modeloDirectorio($ruta);
    include_once 'plantilla/fdetalles.php'; 
}
function ctlUserModificar(){
    if( $_SERVER['REQUEST_METHOD'] == "GET"){
        $login=$_GET['id'];
        
        $usuariomodif = modeloUserDB::UserGet($login);
        $oldcorreo = $usuariomodif[3];// Correo que tiene el usuario si haberlo modificado
        $newuser=$login;
        $newcorreo=$usuariomodif[3];
        $newnombre=$usuariomodif[2];
        $newcontrasena = $usuariomodif[1];
        $newtipo="";
        $newestado="";
    }
    $distinto = false;
    
    if( $_SERVER['REQUEST_METHOD'] == "POST"){
        
        $newuser = $_POST['user'];
        $usuariomodif = modeloUserDB::UserGet($newuser);
        $newnombre = $_POST['nombre'];
        $newcorreo = $_POST['correo'];//Correo modificado o no, el que coge de la caja de texto
        $newtipo = $_POST['tipo'];
        $newestado = $_POST['estado'];
        $newcontrasena = $usuariomodif[1];
        $oldcorreo = $usuariomodif[3];
        if(!empty($_POST['clave']) ){
            $newcontrasena = $_POST['clave'];
            $distinto = true;
        }
        
        $modificado = [ $newcontrasena, $newnombre, $newcorreo, $newtipo, $newestado];
        
        if(!modeloUserDB::errorValoresModificar($newuser, $modificado, $oldcorreo) && $distinto == false){
                
                $modificadoencriptado = [ $newcontrasena, $newnombre, $newcorreo, $newtipo, $newestado];
                
                if(modeloUserDB::UserUpdate($newuser, $modificadoencriptado)){
                    header('Location:index.php?orden=VerUsuarios');
                }
                
        } else if (!modeloUserDB::errorValoresModificar($newuser, $modificado, $oldcorreo) &&
            $distinto == true){
                
                $newcontrasena = modeloUserEncriptar($newcontrasena);
                
                $modificadoencriptado = [ $newcontrasena, $newnombre, $newcorreo, $newtipo, $newestado];
                
                if(modeloUserDB::UserUpdate($newuser, $modificadoencriptado)){
                    header('Location:index.php?orden=VerUsuarios');
                }
                
        } else {
            
            $msg = modeloUserDB::errorValoresModificar($newuser, $modificado, $oldcorreo);
            include_once 'plantilla/fmodificar.php';
            
        }
        
    } else {
        include_once 'plantilla/fmodificar.php';
    }
    
}
function ctlUserBorrar(){
    
    if (isset($_GET['id'])){
        $user = $_GET['id'];
        
        if( modeloUserDB::UserDel($user)){
            header('Location:index.php?orden=VerUsuarios');
        }
    }
}

function ctUserModificarUsuario(){
    $login=$_SESSION['user'];
    
    $usuariomodif = modeloUserDB::UserGet($login);
    $oldcorreo = $usuariomodif[3];// Correo que tiene el usuario si haberlo modificado
    $newuser=$login;
    $newcorreo=$usuariomodif[3];
    $newnombre=$usuariomodif[2];
    $newcontrasena = $usuariomodif[1];
    $newtipo="";
    $newestado="";
    $distinto = false;
    
    if( $_SERVER['REQUEST_METHOD'] == "POST"){
        
        $newuser = $_POST['user'];
        $usuariomodif = modeloUserDB::UserGet($newuser);
        $newnombre = $_POST['nombre'];
        $newcorreo = $_POST['correo'];//Correo modificado o no, el que coge de la caja de texto
        $newtipo = $_POST['tipo'];
        $newestado = $_POST['estado'];
        $newcontrasena = $usuariomodif[1];
        $oldcorreo = $usuariomodif[3];
        if(!empty($_POST['clave']) ){
            $newcontrasena = $_POST['clave'];
            $distinto = true;
        }
        
        $modificado = [ $newcontrasena, $newnombre, $newcorreo, $newtipo, $newestado];
        
        if(!modeloUserDB::errorValoresModificar($newuser, $modificado, $oldcorreo) &&
            $distinto == false){
                
                $modificadoencriptado = [ $newcontrasena, $newnombre, $newcorreo, $newtipo, $newestado];
                
                if(modeloUserDB::UserUpdate($newuser, $modificadoencriptado)){
                    header('Location:index.php?orden=VerFicheros');
                }
                
        } else if (!modeloUserDB::errorValoresModificar($newuser, $modificado, $oldcorreo) &&
            $distinto == true){
                
                $newcontrasena = modeloUserEncriptar($newcontrasena);
                
                $modificadoencriptado = [ $newcontrasena, $newnombre, $newcorreo, $newtipo, $newestado];
                
                if(modeloUserDB::UserUpdate($newuser, $modificadoencriptado)){
                    header('Location:index.php?orden=VerFicheros');
                }
                
        } else {
            
            $msg = modeloUserDB::errorValoresModificar($newuser, $modificado, $oldcorreo);
            include_once 'plantilla/fmodificarUsuario.php';
            
        }
        
    } else {
        include_once 'plantilla/fmodificarUsuario.php';
    }
    
}
