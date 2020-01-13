<?php
// --------------------------------------------------------------
// Controlador que realiza la gestión de ficheros de un usuario
// ---------------------------------------------------------------



function ctlVerFicheros(){
    $user=$_SESSION['user'];
    $ruta="app/dat/".$user;
    $ficheros = modeloUserGetFicheros($ruta);
    include_once 'plantilla/verficheros.php';
}
function ctlFileSubirFicheros(){
    $msg="";
    $archivo= (isset($_FILES['archivo'])) ? $_FILES['archivo']:null;
    if (!modeloFileSave($archivo)){
        $msg="Error al subir el fichero";
    }
    $ruta ="app/dat/".$_SESSION['user'];
    $ficheros = modeloUserGetFicheros($ruta);
    include_once 'plantilla/verficheros.php';
}
function ctlFileBorrarFicheros(){
    if(isset($_GET['file'])){
        $fichero=$_GET['file'];
        modeloFileDel($fichero);
        if(modeloFileDel($fichero)){
            header('Location:index.php?orden=VerFicheros');
        }else{
            $msg="Error al borrar el fichero";
            include_once 'plantilla/verficheros.php';
        }
    }
}
