<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------
include_once 'config.php';
include_once 'modeloUser.php';

/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlUserInicio(){
    $msg = "";
    $user ="";
    $clave ="";
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['clave'])){
            $user =$_POST['user'];
            $clave=$_POST['clave'];
            if ( modeloOkUser($user,$clave)){
                $_SESSION['user'] = $user;
                $_SESSION['tipouser'] = modeloObtenerTipo($user);
                if ( $_SESSION['tipouser'] == "Máster"){
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    header('Location:index.php?orden=VerUsuarios');
                }
                else {
                  // Usuario normal;
                  // PRIMERA VERSIÓN SOLO USUARIOS ADMISTRADORES
                  $msg="Error: Acceso solo permitido a usuarios Administradores.";
                  // $_SESSION['modo'] = GESTIONFICHEROS;
                  // Cambio de modo y redireccion a verficheros
                }
                if ( $_SESSION['tipouser'] == "Básico"){
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    header('Location:index.php?orden=VerFicheros');
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
    modeloUserSave();
    header('Location:index.php');
}

// Muestro la tabla con los usuario 
function ctlUserVerUsuarios (){
    // Obtengo los datos del modelo
    $usuarios = modeloUserGetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verusuariosp.php';
   
}
function ctlUserAlta()
{
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
            
           if (modeloUserComprobarAlta($usuario, $nuevo)=="") {
                modeloUserGetAll();
                modeloUserAdd($usuario, $nuevo);
                modeloUserSave();
                
                header('Location:index.php?orden=VerUsuarios');
           } else {
                $msg = modeloUserComprobarAlta($usuario, $nuevo);
                include_once 'plantilla/fnuevo.php';
           }
        }
    } else {
        include_once 'plantilla/fnuevo.php';
    }
}

function ctlUserDetalles(){
    $clave=$_GET['id'];
    $listadetalles = modeloUserGet($clave);
    $nombre=$listadetalles[1];
    $correo=$listadetalles[2];
    $tipo=$listadetalles[3];
    $plan=PLANES[$tipo];
    include_once 'plantilla/fdetalles.php';  
}
function ctlUserModificar(){
        $clave=$_GET['id'];
        $usuariomodif =$_SESSION['tusuarios'][$clave];
        
        $newuser=$clave;
        $newclave2=$usuariomodif[0];
        $newclave=$usuariomodif[0];
        $newcorreo=$usuariomodif[2];
        $newnombre=$usuariomodif[1];
        $newtipo="";
        $newestado="";
        if( $_SERVER['REQUEST_METHOD'] == "POST"){
          
                $newuser = $_POST['user'];
                $newclave = $_POST['clave'];
                $newclave2 = $_POST['clave2'];
                $newnombre = $_POST['nombre'];
                $newcorreo = $_POST['correo'];
                $newtipo = $_POST['tipo'];
                $newestado = $_POST['estado'];
                
                $modificado = [ $newclave, $newnombre, $newcorreo, $newtipo, $newestado, $newclave2];
                if (modeloUserComprobarModif($newuser, $modificado)=="") {
                    modeloUserUpdate($newuser, $modificado);
                    modeloUserSave();
                    
                    if(modeloUserUpdate($newuser, $modificado)){
                        header('Location:index.php?orden=VerUsuarios');
                    }
                } else {
                    $msg = modeloUserComprobarModif($newuser, $modificado);
                    include_once 'plantilla/fmodificar.php';
                }
                
              
            
        } else{
            include_once 'plantilla/fmodificar.php';
        }
}
function ctlUserBorrar(){

        if (isset($_GET['id'])){
            $user = $_GET['id'];
                modeloUserDel($user);
                modeloUserSave();
                if(modeloUserDel($user)){
                    header('Location:index.php?orden=VerUsuarios');
                }
            }
            
            
        }






