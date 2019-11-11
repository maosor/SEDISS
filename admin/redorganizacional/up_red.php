<link rel="stylesheet" href="../css/treeview.css">
<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  if($codpadre == '' or $codpadre == null )
  {
    $codpadre = '000000000000000000000000000000000000000000000000000000000000';
  }
  if ($tipo > 4)
  {
  $up = $con->prepare("UPDATE tipo_unidades_gestion SET codigo=?, descripcion=?, codpadre=?,nivel=?, orden=?,Hereda=?,TieneCamas=?,Comprensiva=?,UnidProdPrim=?, UnidProdSec=?,UnidProdValorRel1=?,UnidProdValorRel2=?  WHERE id=? ");
  $up->bind_param('sssiiiiiissii', $codigo,$descripcion, $codpadre, $nivel, $orden, $id, $hereda, $camas, $comprensiva, $primaria, $secundaria, $prelativo, $srelativo);
}else {
  $up = $con->prepare("UPDATE red_organizacional SET codigo=?, descripcion=?, codpadre=?,nivel=?, orden=?  WHERE id=? ");
  $up->bind_param('sssiii', $codigo,$descripcion, $codpadre, $nivel, $orden, $id);
}
    if ($up -> execute()) {
     mostrararbol('000000000000000000000000000000000000000000000000000000000000',$tipo);
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
   $('.selecionado').removeClass('selecionado');
   $(this).addClass("selecionado");
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
