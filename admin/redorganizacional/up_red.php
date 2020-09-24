<!-- <link rel="stylesheet" href="../css/treeview.css"> -->
<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  if($idpa == '' or $idpa == null )
  {
    $idpa = '0';
  }
  $tipo=$tipo==null?1:$tipo;
    if(isset($_POST['tipo'])){
        if ($tipo > 4)
        {
          $up = $con->prepare("UPDATE tipo_unidades_gestion SET descripcion=?, idpa=?,nivel=?, orden=?,Hereda=?,TieneCamas=?,Comprensiva=?,UnidProdPrim=?, UnidProdSec=?,UnidProdValorRel1=?,UnidProdValorRel2=?,RecursoNuclear=?,Funcion=?,PerteneceA=?  WHERE id=? ");
          $up->bind_param('siiiiiissiisiii', $descripcion, $idpa, $nivel, $orden, $hereda, $camas, $comprensiva, $primaria, $secundaria, $prelativo, $srelativo,$RecursoNuclear,$funcion,$pertenece,$id);
        }else {
          $up = $con->prepare("UPDATE red_organizacional SET descripcion=?, idpa=?,nivel=?, orden=?  WHERE id=? ");
          $up->bind_param('ssiii', $descripcion, $idpa, $nivel, $orden, $id);
        }
      }
      else {
        $up = $con->prepare("UPDATE organizacion SET descripcion=?, complejidad=?, poblacion=? WHERE id=? ");
        $up->bind_param('siii', $descripcion, $complejidad, $poblacion, $id);
        $tipo=1;
      }
        if ($up -> execute()) {
          mostrararbol('000000000000000000000000000000000000000000000000000000000000',$tipo);
        }else {
          echo 'Error actualizando...';
        }
  $up->close();
  $con->close();
  }else {
    header('location:../extend/alerta.php?msj=Utiliza el formulario&c=red&p=in&t=error');
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
