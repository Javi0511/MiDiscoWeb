<?php 
include_once 'config.php';
/* DATOS DE USUARIO
â€¢ Identificador ( 5 a 10 caracteres, no debe existir previamente, solo letras y nÃºmeros)
â€¢ ContraseÃ±a ( 8 a 15 caracteres, debe ser segura)
â€¢ Nombre ( Nombre y apellidos del usuario
â€¢ Correo electrÃ³nico ( Valor vÃ¡lido de direcciÃ³n correo, no debe existir previamente)
â€¢ Tipo de Plan (0-BÃ¡sico |1-Profesional |2- Premium| 3- MÃ¡ster)
â€¢ Estado: (A-Activo | B-Bloqueado |I-Inactivo )
*/
// Inicializo el modelo 
// Cargo los datos del fichero a la session
function modeloUserInit(){
    
    /*
    $tusuarios = [ 
         "admin"  => ["12345"      ,"Administrado"   ,"admin@system.com"   ,3,"A"],
         "user01" => ["user01clave","Fernando PÃ©rez" ,"user01@gmailio.com" ,0,"A"],
         "user02" => ["user02clave","Carmen GarcÃ­a"  ,"user02@gmailio.com" ,1,"B"],
         "yes33" =>  ["micasa23"   ,"Jesica Rico"    ,"yes33@gmailio.com"  ,2,"I"]
        ];
    */
    if (! isset ($_SESSION['tusuarios'] )){
    $datosjson = @file_get_contents(FILEUSER) or die("ERROR al abrir fichero de usuarios");
    $tusuarios = json_decode($datosjson, true);
    $_SESSION['tusuarios'] = $tusuarios;
   }

      
}

// Comprueba usuario y contraseÃ±a (boolean)
function modeloOkUser($user,$clave){
    /*foreach ($_SESSION['tusuarios'] as $key => $datosusuario){
        if($key==$user && $datosusuario[0]==$clave){
            $resultado= true;
        }else {
            $resultado=false;
        }
        
        
    }
    
    return $resultado;*/
    //return ($user=='user01') && ($clave =='123456789');
    return ($user=='admin') && ($clave =='12345');
}

// Devuelve el plan de usuario (String)
function modeloObtenerTipo($user){
    $tipo=$_SESSION['tusuarios'][$user][3];
    
    return PLANES[$tipo]; // MÃ¡ster
}

// Borrar un usuario (boolean)
function modeloUserDel($user){
    $directorio="./app/dat/".$user;
    unset($_SESSION['tusuarios'][$user]);
    rmdir($directorio);
    return true;
}
//comprobamos requisitos
function modeloUserComprobarAlta($user, $nuevo){
    $resultado = "";
    
    $contrase�a=$nuevo[0];
    $contrase�a2=$nuevo[5];
    $nombre =$nuevo[1];
    $correo =$nuevo[2];
    if($contrase�a!=$contrase�a2){
        $resultado = "La contrsena no coincide";
    }
    if (array_key_exists($user, $_SESSION['tusuarios'])) {
        $resultado = "El usuario ya existe";
    }
    /*if (in_array($correo, $_SESSION['tusuarios'])) {
        $resultado = "El correo ya existe";
    }*/
    if(strlen($user)<=5 || strlen($user)>=10){
        $resultado = "La longitud del usuario es incorrecta";
    }
    if(!ctype_alnum($user)){
        $resultado = "La contrasena no puede contener carecteres especiales";
    }
    if(strlen($nombre)>20){
        $resultado = "La longitud del nombre es incorrecta";
    }
    if(strlen($contrase�a)<=8 || strlen($contrase�a)>15){
        $resultado ="La longitud de la contrasena es incorrecta";
    }
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $resultado = "El correo es invalido";
    }
    return $resultado;
}
function modeloUserComprobarModif($user, $nuevo){
    $resultado = "";
    $contrase�a=$nuevo[0];
    $contrase�a2=$nuevo[5];
    $nombre =$nuevo[1];
    $correo =$nuevo[2];
    if($contrase�a!=$contrase�a2){
        $resultado = "La contrsena no coincide";
    }
    /*if (in_array($correo, $_SESSION['tusuarios'])) {
     $resultado = "El correo ya existe";
     }*/
    if(strlen($user)<=5 || strlen($user)>=10){
        $resultado = "La longitud del usuario es incorrecta";
    }
    if(!ctype_alnum($user)){
        $resultado = "La contrasena no puede contener carecteres especiales";
    }
    if(strlen($nombre)>20){
        $resultado = "La longitud del nombre es incorrecta";
    }
    if(strlen($contrase�a)<=8 || strlen($contrase�a)>15){
        $resultado ="La longitud de la contrasena es incorrecta";
    }
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $resultado = "El correo es invalido";
    }
    return $resultado;
}
// AÃ±adir un nuevo usuario (boolean)
function modeloUserAdd($user, $array){
    $directorio="./app/dat/".$user;
    $_SESSION['tusuarios'][$user]=$array;
    mkdir($directorio,777);
    return true;
}

// Actualizar un nuevo usuario (boolean)
function modeloUserUpdate ($user, $array){

    $_SESSION['tusuarios'][$user]=$array;
    
    return true;
}

// Tabla de todos los usuarios para visualizar
function modeloUserGetAll (){
    // Genero lo datos para la vista que no muestra la contraseÃ±a ni los cÃ³digos de estado o plan
    // sino su traducciÃ³n a texto
    $tuservista=[];
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario){
        $tuservista[$clave] = [$datosusuario[1],
                               $datosusuario[2],
                               PLANES[$datosusuario[3]],
                               ESTADOS[$datosusuario[4]]
                               ];
    }
    return $tuservista;
}
// Datos de un usuario para visualizar
function modeloUserGet ($user){
    $usuariodetalles =$_SESSION['tusuarios'][$user];
 
    return $usuariodetalles;
    
}
function modeloUserGetFicheros ($ruta){
    $usuariodetalles =$_SESSION['tusuarios'][$user];
    
    return $usuariodetalles;
    
}

// Vuelca los datos al fichero
function modeloUserSave(){
    
    $datosjon = json_encode($_SESSION['tusuarios']);
    file_put_contents(FILEUSER, $datosjon) or die ("Error al escribir en el fichero.");
}
function modeloFileSave(){
    
    $datosjon = json_encode($_SESSION['tusuarios']);
    file_put_contents(FILEUSER, $datosjon) or die ("Error al escribir en el fichero.");
}
function modeloFileDel ($user){
    $usuariodetalles =$_SESSION['tusuarios'][$user];
    
    return $usuariodetalles;
    
}
