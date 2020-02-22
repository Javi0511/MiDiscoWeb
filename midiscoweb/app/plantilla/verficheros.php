<?php
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<table>
	<tr>
<?php
$auto = $_SERVER['PHP_SELF'];

// identificador => Nombre, email, plan y Estado
?>
<h1>Ficheros del usuario <?= $_SESSION['user'] ?></h1>
<?php foreach ($ficheros as $clave => $datosfichero) : ?>
<tr>	

<td><?= $clave ?></td> 
	<?php for  ($j=0; $j < count($datosfichero); $j++) :?>
     <td><?=$datosfichero[$j] ?></td>
	<?php endfor;?>
<td><a href="#" onclick="confirmarBorrarFile('<?= $clave?>');"></div><img src="web/img/borrar.png"></a></td>
<td><a href="#" onclick="confirmarRenombrarFile('<?= $clave?>');"></div><img src="web/img/editar.png"></a></td>
<td><a href="<?= $auto?>?orden=Descargar&file=<?= $clave?>">Descargar</a></div>
</tr>		

<?php endforeach; ?>
</table>
<form action='index.php'>
        	<input  type='hidden' name='orden' value='Cerrar'> 
        	<input id='botoncerrar' type='submit' value='Cerrar Sesión'>
        	
</form>

<form  enctype="multipart/form-data" method="post" action="index.php?orden=SubirFichero">
         	<input type="file" name="archivo"><br>
        	<input  type='hidden' name='orden' value='Enviar'> 
        	<input id='botoncrear' type='submit' value='Subir archivo'>
</form>
<form action='index.php'>
        	<input  type='hidden' name='orden' value='ModificarUsuario'> 
        	<input id='boton' type='submit' value='Modificar sus datos'>
</form>
<h2> Ficheros: <?= $numFicheros ?> </h2>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>
