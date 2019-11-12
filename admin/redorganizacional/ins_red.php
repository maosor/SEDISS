<!-- <link rel="stylesheet" href="../css/treeview.css"> -->
<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
$id='';
if($codpadre == '' or $codpadre == null )
{
  $codpadre = '000000000000000000000000000000000000000000000000000000000000';
}
if ($tipo > 4)
{
  $ins = $con->prepare("INSERT INTO tipo_unidades_gestion (Codigo, Descripcion, id, Nivel, Orden, CodPadre,Hereda,TieneCamas,Comprensiva,UnidProdPrim, UnidProdSec,UnidProdValorRel1,UnidProdValorRel2)
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ");
  $ins -> bind_param('ssiiisiiissii',$codigo, $descripcion,$id, $nivel, $orden, $codpadre, $hereda, $camas, $comprensiva, $primaria, $secundaria, $prelativo, $srelativo);
}
else {
    $ins = $con->prepare("INSERT INTO red_organizacional VALUES (?,?,?,?,?,?) ");
    $ins -> bind_param('sssiss',$codigo, $descripcion,$id, $nivel, $orden, $codpadre);
  }
if ($ins -> execute()) {
   mostrararbol('000000000000000000000000000000000000000000000000000000000000',$tipo);
}else {
  echo 'Error actualizando...';
}
$ins ->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=suc&p=in&t=error');
}
 ?>
 <script src="../js/treeview.js" charset="utf-8"></script>
 <script type="text/javascript">
 $('.node').not(':has(ul)').click(function(){
   $('.selecionado').removeClass('selecionado');
   $(this).addClass("selecionado");
   $.post('ajax_nodo.php',{
     codigo:$(this).attr('id'),
     tipo:$('#tipo').val(),
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
