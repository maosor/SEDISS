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
      $del = $con->prepare("DELETE FROM tipo_unidades_gestion WHERE id=? AND id_compania = ? AND NOT EXISTS(SELECT * FROM (SELECT null from tipo_unidades_gestion where idpa =?)AS u)");
      $del->bind_param('iii', $id,$compania,$id);
    }else {
      $del = $con->prepare("DELETE FROM red_organizacional WHERE id=? AND id_compania = ? AND NOT EXISTS(SELECT * FROM (SELECT null from red_organizacional where idpa =?)AS r) ");
      $del->bind_param('iii', $id,$compania,$id);
    }
  }else {
    $del = $con->prepare("DELETE FROM organizacion WHERE id=? AND idcompania = ? and not EXISTS(SELECT * FROM (SELECT null from unidadgestion_organizacion where organizacion =?))AS u ");
    $del->bind_param('iii', $id,$compania,$id);
    $tipo=1;
  }

    if ($del -> execute()) {
      if($del->affected_rows > 0){
        mostrararbol(0,$tipo,$compania);
      }else {
        header('location:../extend/alerta.php?msj=No se puede borrar un rubro que tiene hijos.\nDebe borrar todos sus hijos para poder borrarlo&c=red&p=in&t=error&o='.$tipo);
      }

  }else {
    echo 'Error Borrando...';
  }
$del->close();
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
