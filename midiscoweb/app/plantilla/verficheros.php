
<?php
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();

?>

<table>
<tr>
<?php  
$auto = $_SERVER['PHP_SELF'];
/* identificador => Nombre, email, plan y Estado
*/
?>
<?php foreach ($dicheros as $clave => $datosfichero) : ?>
<tr  id ="datos">		
<td><?= $clave ?></td> 
	<?php for  ($j=0; $j < count($datosfichero); $j++) :?>
     <td><?=$datosfichero[$j] ?></td>
	<?php endfor;?>
<td><a href="#" onclick="confirmarBorrar('<?= $datosfichero[0]."','".$clave."'"?>);"><img src="web/img/borrar.png"></a></td>
<td><a href="<?= $auto?>?orden=Modificar&id=<?= $clave ?>"><img src="web/img/editar.png"></a></td>
<td><a href="<?= $auto?>?orden=Detalles&id=<?= $clave?>"><img src="web/img/detalles.png"></a></td>
</tr>
<?php endforeach; ?>
</table>  
<form action='index.php'> 
<input type="hidden" name="orden" value="Subir">
<input id="botoncrear" type="submit"  value="Subir fichero">
<input type='hidden' name='orden' value='Cerrar'> 
<input id="botoncerrar" type='submit' value='Cerrar Sesión'> 

</form>       

<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";
include_once "app/controlerFile.php";
?>