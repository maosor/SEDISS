<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
$id='';
$ins = $con->prepare("INSERT INTO sucursal VALUES (?,?,?) ");
$ins -> bind_param('iss',$id, $nombre, $telefono);
if ($ins -> execute()) {
  header('location:../extend/alerta.php?msj=Sucursal registrada&c=suc&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=La sucursal no pudo ser registrada'.$ins->error.'&c=suc&p=in&t=error');
}
$ins ->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=suc&p=in&t=error');
}
 ?>
