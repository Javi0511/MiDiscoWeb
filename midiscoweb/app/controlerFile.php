<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------
include_once 'configDB.php';
include_once 'modeloUser.php';

function ctFileVerFicheros (){
    $ruta = "app/dat/". $_SESSION['user'];
    $ficheros = modeloUserGetFicheros($ruta);
    $ruta = "app/dat/". $_SESSION['user'];
    $numFicheros = modeloDatos($ruta);
    include_once 'plantilla/verficheros.php';
}

function ctFileSubirFicheros(){
    $msg="";
    $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
    $nombreArchivo=$_FILES['archivo']['name'];
    $tmpArchivo=$_FILES['archivo']['tmp_name'];
    
    if(!modeloFileSave($nombreArchivo,$tmpArchivo)){
        $msg="Error al subir el fichero";
    }
    $ruta = "app/dat/". $_SESSION['user'];
    $ficheros = modeloUserGetFicheros($ruta);
    $numFicheros = modeloDatos($ruta);
    include_once 'plantilla/verficheros.php';
}

function ctFileBorrarFicheros(){
    if (isset($_GET['id'])){
        $fichero=$_GET['id'];
        modeloFileDel($fichero);
        if(modeloFileDel($fichero)){
            header('Location:index.php?orden=VerFicheros');
        }else{
            $msg="Error al borrar el fichero";
            include_once 'plantilla/verficheros.php';
        }
    }
    $ruta = "app/dat/". $_SESSION['user'];
    $numFicheros = modeloDatos($ruta);
}

function ctFileRenombrarFicheros(){
    if (isset($_GET['id'])){
        $fichero=$_GET['id'];
        $nuevoNombre=$_GET['nombre'];
        if(modeloFileRenombrar($fichero,$nuevoNombre)){
            $msg="Error al renombrar el fichero";
        }
        $ruta = "app/dat/". $_SESSION['user'];
        $ficheros = modeloUserGetFicheros($ruta);
        $numFicheros = modeloDatos($ruta);
        include_once 'plantilla/verficheros.php';
        }
}

function ctFileDescargar(){
    if (isset($_GET['file'])){
        
        $nombreFichero = $_GET['file'];
        $ruta = "./app/dat/". $_SESSION['user'] .'/';
        $rutaNombre = $ruta . $nombreFichero;
        modeloFileDescargar($rutaNombre, $nombreFichero);
    }
    
}
?>