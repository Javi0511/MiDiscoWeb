/**
 * Funciones auxiliares de javascripts 
 */
function confirmarBorrar(nombre,id){
  if (confirm("¿Quieres eliminar el usuario:  "+nombre+"?"))
  {
   document.location.href="?orden=Borrar&id="+id;
  }
}

var x;
x=$(document);
x.ready(inicializarEventos);

function inicializarEventos()
{
  var x;
  x=$('#botoncrear');
  x.mousedown(presionaMouse);
  y=$('#botoncerrar');
  y.mousedown(presionaMouse2);
  z=$('#boton');
  z.mousedown(presionaMouse3);

}

function presionaMouse()
{
  var x;
  x=$('#botoncrear');
  $(this).css("background","#4af750");
}


  function presionaMouse2()
{
  var y;
  y=$('#botoncerrar');
  $(this).css("background","#f25a5a");
}


function presionaMouse3()
{
  var z;
  z=$('#boton');
  $(this).css("background","#00ffeb");
}


