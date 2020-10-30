<!-- <link rel="stylesheet" href="../css/treeview.css"> -->
<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
$compania = $_SESSION['compania'];
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  //echo $variable;
  }
  if($idpa == '' or $idpa == null )
  {
    $idpa = '0';
  }
  $tipo=$tipo==null?1:$tipo;
  //$camas=;
 $c=$camas=='true'?1:0;
    if(isset($_POST['tipo'])){
        if ($tipo > 4)
        {
          $up = $con->prepare("UPDATE tipo_unidades_gestion SET id_compania=?, descripcion=?, idpa=?,nivel=?, orden=?,Hereda=?,TieneCamas=?,Comprensiva=?,UnidProdPrim=?, UnidProdSec=?,UnidProdValorRel1=?,UnidProdValorRel2=?,RecursoNuclear=?,Funcion=?,PerteneceA=?  WHERE id=? ");
          $up->bind_param('isiiiiiissiisiii',$compania, $descripcion, $idpa, $nivel, $orden, $hereda, $c, $comprensiva, $primaria, $secundaria, $prelativo, $srelativo,$RecursoNuclear,$funcion,$pertenece,$id);
          //echo "UPDATE tipo_unidades_gestion SET id_compania=?, descripcion=?, idpa=?,nivel=?, orden=?,Hereda=?,TieneCamas=?,Comprensiva=?,UnidProdPrim=?, UnidProdSec=?,UnidProdValorRel1=?,UnidProdValorRel2=?,RecursoNuclear=?,Funcion=?,PerteneceA=?  WHERE id=? ".$compania. $descripcion. $idpa. $nivel. $orden. $hereda. $camas. $comprensiva. $primaria. $secundaria. $prelativo. $srelativo.$RecursoNuclear.$funcion.$pertenece.$id;
        }else {
          $up = $con->prepare("UPDATE red_organizacional SET id_compania=?, descripcion=?, idpa=?,nivel=?, orden=?  WHERE id=? ");
          $up->bind_param('issiii',$compania, $descripcion, $idpa, $nivel, $orden, $id);
        }
      }
      else {
        $up = $con->prepare("UPDATE organizacion SET idcompania=?, descripcion=?, complejidad=?, poblacion=? WHERE id=? ");
        $up->bind_param('isiii',$compania, $descripcion, $complejidad, $poblacion, $id);
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
