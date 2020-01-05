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
if($idpa == '' or $idpa == null )
{
  $idpa = '0';
}
if(isset($_POST['tipo'])){
  if ($tipo > 4)
  {
    $ins = $con->prepare("INSERT INTO tipo_unidades_gestion (Descripcion, Nivel, Orden,
       idpa,Hereda,TieneCamas,Comprensiva,UnidProdPrim, UnidProdSec,UnidProdValorRel1,UnidProdValorRel2,RecursoNuclear,Funcion,PerteneceA)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
    $ins -> bind_param('siiiiiissiisii', $descripcion, $nivel, $orden,
    $idpa, $hereda, $camas, $comprensiva, $primaria, $secundaria, $prelativo, $srelativo,$RecursoNuclear,$funcion,$pertenece);
  }
  else {
      $ins = $con->prepare("INSERT INTO red_organizacional (Descripcion, Nivel, Orden, idpa, tipo) VALUES (?,?,?,?,?) ");
      $ins -> bind_param('siiii', $descripcion, $nivel, $orden, $idpa,$tipo);
    }
}else {
  $ins = $con->prepare("INSERT INTO organizacion (Descripcion, complejidad, poblacion, idpa) VALUES (?,?,?,?) ");
  $ins -> bind_param('siii', $descripcion, $complejidad, $poblacion, $idpa);
  $tipo=1;
}

if ($ins -> execute()) {
   mostrararbol('0',$tipo);
}else {
  echo 'Error Insertando...';
}
$ins ->close();
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
