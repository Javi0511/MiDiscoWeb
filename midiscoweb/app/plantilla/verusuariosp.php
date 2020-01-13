<?php
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();

?>

<table id="verusuarios">
	<tr>
<?php
$auto = $_SERVER['PHP_SELF'];
// identificador => Nombre, email, plan y Estado
?>
<?php foreach ($usuarios as $clave => $datosusuario) : ?>
<tr  id ="datos">		
<td id="nombreuser"><?= $clave ?></td> 
	<?php for  ($j=0; $j < count($datosusuario); $j++) :?>
     <td><?=$datosusuario[$j] ?></td>
	<?php endfor;?>
<td><a href="#" onclick="confirmarBorrar('<?= $datosusuario[0]."','".$clave."'"?>);"><img  title="Borrar" src="web/img/borrar.png"></a></td>
<td><a href="<?= $auto?>?orden=Modificar&id=<?= $clave ?>"><img title="Editar" src="web/img/editar.png"></a></td>
<td><a href="<?= $auto?>?orden=Detalles&id=<?= $clave?>"><img title="Modificar" src="web/img/detalles.png"></a></td>
</tr>
<?php endforeach; ?>
</table>

<form action='index.php'>
	<input type='hidden' name='orden' value='Alta'> 
	<input id="botoncrear" type='submit' value='Crear usuario'>
</form>
<form action='index.php'>
	<input type='hidden' name='orden' value='Cerrar'> 
	<input id="botoncerrar" type='submit' value='Cerrar Sesión'>
	
</form>

<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>