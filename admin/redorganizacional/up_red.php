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
          $up = $con->prepare("UPDATE tipo_unidades_gestion SET descripcion=?, idpa=?,nivel=?, orden=?,Hereda=?,TieneCamas=?,Comprensiva=?,UnidProdPrim=?, UnidProdSec=?,UnidProdValorRel1=?,UnidProdValorRel2=?,RecursoNuclear=?,Funcion=?,PerteneceA=?  WHERE id=? and id_compania=?");
          $up->bind_param('siiiiiissiisiiii', $descripcion, $idpa, $nivel, $orden, $hereda, $c, $comprensiva, $primaria, $secundaria, $prelativo, $srelativo,$RecursoNuclear,$funcion,$pertenece,$id,$compania);
          //echo "UPDATE tipo_unidades_gestion SET id_compania=?, descripcion=?, idpa=?,nivel=?, orden=?,Hereda=?,TieneCamas=?,Comprensiva=?,UnidProdPrim=?, UnidProdSec=?,UnidProdValorRel1=?,UnidProdValorRel2=?,RecursoNuclear=?,Funcion=?,PerteneceA=?  WHERE id=? ".$compania. $descripcion. $idpa. $nivel. $orden. $hereda. $camas. $comprensiva. $primaria. $secundaria. $prelativo. $srelativo.$RecursoNuclear.$funcion.$pertenece.$id;
        }else {
          $up = $con->prepare("UPDATE red_organizacional SET descripcion=?, idpa=?,nivel=?, orden=?  WHERE id=? and id_compania=?");
          $up->bind_param('ssiiii', $descripcion, $idpa, $nivel, $orden, $id,$compania);
          addLog('UPDATE red_organizacional SET descripcion='.$descripcion.', idpa='.$idpa.',nivel='.$nivel.', orden='.$orden.'  WHERE id='.$id.' AND id_compania='.$compania);
        }
      }
      else {
        $up = $con->prepare("UPDATE organizacion SET descripcion=?, complejidad=?, poblacion=? WHERE id=? and idcompania=?");
        $up->bind_param('siiii', $descripcion, $complejidad, $poblacion, $id,$compania);
        $tipo=1;
      }
        if ($up -> execute()) {
          mostrararbol(0,$tipo,$compania);
        }else {
          echo 'Error actualizando... ';
          addlog('Error actualizando: SQL Error --> '.$up->error);
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
