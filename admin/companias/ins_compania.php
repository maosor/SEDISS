<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
$id='';
$ins = $con->prepare("INSERT INTO compania VALUES (?,?,?) ");
$ins -> bind_param('iss',$id, $descripcion, $pais);
if ($ins -> execute()) {
  header('location:../extend/alerta.php?msj=Compañía registrada&c=com&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=La compañía no pudo ser registrada&c=com&p=in&t=error');
}
$ins ->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=com&p=in&t=error');
}
 ?>
