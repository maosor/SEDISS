<link rel="stylesheet" href="../css/treeview.css">
<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $up = $con->prepare("UPDATE red_organizacional SET descripcion=?, codpadre=?,nivel=?, orden=?  WHERE codigo=? ");
  $up->bind_param('sssii', $descripcion, $codpadre, $codigo, $nivel, $orden);
    if ($up -> execute()) {
     mostrararbol('000000000000000000000000000000000000000000000000000000000000');
  }else {
    echo 'Error actualizando...';
  }
$up->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=suc&p=in&t=error');
}
 ?>
 <script src="../js/treeview.js" charset="utf-8"></script>
 <script type="text/javascript">
 $('.node').not(':has(ul)').click(function(){
   $.post('ajax_nodo.php',{
     codigo:$(this).attr('id'),
     beforeSend: function () {
       $('.dvdetalle').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('.dvdetalle').html(respuesta);
   });
 });
 $('.branch').dblclick(function(){
   $.post('ajax_nodo.php',{
     codigo:$(this).attr('id'),
     beforeSend: function () {
       $('.dvdetalle').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('.dvdetalle').html(respuesta);
   });
 });
 </script>
