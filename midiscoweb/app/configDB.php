<?php

// DATOS DE CONEXION
define ('DBSERVER','127.0.0.1');
define ('DBNAME','discoweb' );
define ('DBUSER','root');
define ('DBPASSWORD','root');

define ('GESTIONUSUARIOS','1');
define ('GESTIONFICHEROS','2');

// Fichero donde se guardan los datos
define('FILEUSER','app/dat/usuarios.json');
define('FILEUSERSEGUR','app/dat/usuariossegur.json');
// Ruta donde se guardan los archivos de los usuarios
// Tiene que tener permiso 777 o permitir cambiar a usuario Apache
define('RUTA_FICHEROS','app/dat');
//  Estado: (A-Activo | B-Bloqueado |I-Inactivo )
const  ESTADOS = ['A' => 'Activo','B' =>'Bloqueado', 'I' => 'Inactivo'];


// (0-B�sico |1-Profesional |2- Premium| 3- M�ster)
const  PLANES = ['B�sico','Profesional','Premium','M�ster'];
const LIMITE_FICHEROS = [50,100,200,0];
const LIMITE_ESPACIO  = [10000,20000,50000,0];
// TAMA�O M�XIMO DEL FICHERO 2 MB
define ('TAMMAXIMOFILE',  2000000);
const TMENSAJES = [
    'USREXIST'     => "El ID del usuario ya existe",
    'USRERROR'     => "El ID de usuario solo puede tener letras y n�meros",
    'PASSDIST'     => "Los valores de la contrase�as no son iguales",
    'PASSEASY'     => "La contrase�a no es segura",
    'MAILERROR'    => "El correo electr�nico no es correcto",
    'MAILREPE'     => "La direcci�n de correo ya est� repetida",
    'NOVACIO'      => "Rellenar todos los campos",
    'LOGINERROR'   => "Error: usuario y contrase�a no v�lidos.",
    'USERNOACTIVO' => "Su usuario esta bloqueado o inactivo",
    'USERSAVE'     => "Nuevo Usuario almacenado.",
    'USERNOSAVE'   => "Error: No se puede a�adir el usuario",
    'USERUPDATE'   => "Se han modificado los datos del Usuario",
    'ERRORUPDATE'  => "Error al modificar el usuario",
    'ERRORADDUSER' => "Error: No se puede a�adir el usuario",
    'USERREG'      => "Usuario registrado. Introduzca sus datos",
    'USERDEL'      => "Usuario eliminado.",
    'ERRORDEL'     => "Error no se puede eliminar el usuario."
];


// Definir otras constantes 