<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
$id='';
$a= htmlentities($_GET['a']);
if ($a== 't') {
$ins = $con->prepare("INSERT INTO tipo_ejecutivo VALUES (?,?) ");
$ins -> bind_param('is',$id, $descripcion);
if ($ins -> execute()) {
  header('location:../extend/alerta.php?msj=Tipo ejecutivo registrado&c=typ&p=in&t=success&a=t');
}else {
  header('location:../extend/alerta.php?msj=El tipo ejecutivo pudo ser registrado&c=typ&p=in&t=error&a=t');
}
}else {
  $ins = $con->prepare("INSERT INTO perfil_ejecutivo VALUES (?,?) ");
  $ins -> bind_param('is',$id, $descripcion);
  if ($ins -> execute()) {
    header('location:../extend/alerta.php?msj=Perfil del ejecutivo registrado&c=typ&p=in&t=success&a=p');
  }else {
    header('location:../extend/alerta.php?msj=El perfil del ejecutivo no pudo ser registrado&c=typ&p=in&t=error&a=p');
  }
}


$ins ->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=suc&p=in&t=error&a=');
}
 ?>
