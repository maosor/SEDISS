<!-- <link rel="stylesheet" href="../css/treeview.css"> -->
<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
$compania = $_SESSION['compania'];
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  if(isset($_POST['tipo'])){
    if ($tipo > 4)
    {
      $up = $con->prepare("DELETE FROM tipo_unidades_gestion WHERE id=? AND id_compania = ?");
      $up->bind_param('ii',  $id,$compania);
    }else {
      $up = $con->prepare("DELETE FROM red_organizacional WHERE id=? AND id_compania = ?");
      $up->bind_param('ii', $id,$compania);
    }
  }else {
    $up = $con->prepare("DELETE FROM organizacion WHERE id=? AND idcompania = ?");
    $up->bind_param('ii', $id,$compania);
    $tipo=1;
  }

    if ($up -> execute()) {
     mostrararbol(0,$tipo,$compania);
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
 $('.node').click(function(){
   event.stopPropagation();
   $('.selecionado').removeClass('selecionado');
   $(this).addClass("selecionado");
   if($('#tipo').val() == '')
   {
     llama_organizacion($(this).attr('id'))
   }
   else {
     llama_nodo($(this).attr('id'),$('#tipo').val())
   }
 });
 function llama_nodo(cod, tip) {
   $.post('ajax_nodo.php',{
     id:cod,
     tipo:tip,
     beforeSend: function () {
       $('.dvdetalle').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('.dvdetalle').html(respuesta)
   });
 }
 function llama_organizacion(cod) {
   $.post('ajax_nodo_organizacion.php',{
     id:cod,
     beforeSend: function () {
       $('.dvdetalle').html('Espere un momento por favor')
      }
    }, function (respuesta) {
         $('.dvdetalle').html(respuesta)
   });
 }
 </script>
