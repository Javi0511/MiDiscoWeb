<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
// FORMULARIO DE ALTA DE USUARIOS
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Alta">
<table>
		<tr>
			<td>Usuario:</td>
			<td><input type="text" name="user"
				value=""></td>
		</tr>
		<tr>
			<td>Nombre:</td>
			<td><input type="text" name="nombre"
				value=""></td>
		</tr>
		<tr>
			<td>Contraseña:</td>
			<td><input type="password" name="clave"
				value=""></td>
		</tr>
		<tr>
			<td>Confirmar contraseña:</td>
			<td><input type="password" name="clave2"
				value=""></td>
		</tr>
		
        <tr>
			<td>Correo:</td>
			<td><input type="text" name="correo"
				value=""></td>
		</tr>
        <tr>
			<td>Plan:</td>
			<td><select name="tipo">
				<option value="0">Basico</option>
				<option value="1">Profesional</option>
				<option value="2">Premium</option>
				<option value="3">Master</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Estado:</td>
			<td><select name="estado">
				<option value="A">Activo</option>
				<option value="B">Bloqueado</option>
				<option value="I">Inactivo</option>
				</select>
			</td>
		</tr>
	</table>
	<input type="hidden" name="orden" value="Enviar">
	<input id="botoncrear" type="submit"  value="Enviar datos">
	<a href="<?= $_SERVER["HTTP_REFERER"]?>"><input type="button" value="Volver" id="boton" ></a>
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>