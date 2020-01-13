<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
// FORMULARIO DE ALTA DE USUARIOS
$auto = $_SERVER['PHP_SELF'];
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<h1 id='titulodet'>Detalles del <?= $clave ?></h1>
<table id='tabladet'>
		<tr>
			<td>Nombre:</td>
			<td><?= $nombre ?></td>
		</tr>
		<tr>
			<td>Correo electronico:</td>
			<td><?= $correo ?></td>
		</tr>
		<tr>
			<td>Plan:</td>
			<td><?= $plan?></td>
		</tr>
        <tr>
			<td>Numero de ficheros:</td>
			<td></td>
		</tr>
        <tr>
			<td>Espacio ocupado:</td>
			<td></td>
		</tr>
		
	</table>
	<a href="<?= $_SERVER["HTTP_REFERER"]?>"><input type="button" value="Volver" id="boton" ></a>

<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";



?>