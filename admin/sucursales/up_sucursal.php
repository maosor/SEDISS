<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $up = $con->prepare("UPDATE sucursal SET nombre=?, telefono=? WHERE id=? ");
  $up->bind_param('ssi', $nombre, $telefono, $id);
    if ($up -> execute()) {
    header('location:../extend/alerta.php?msj=Sucursal actualizado&c=suc&p=in&t=success');
  }else {
    header('location:../extend/alerta.php?msj=La Sucursal no pudo ser actualizada '.$up->error.'&c=suc&p=in&t=error');
  }
$ins->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=suc&p=in&t=error');
}
 ?>
