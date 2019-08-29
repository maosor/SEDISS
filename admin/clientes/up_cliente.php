<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $up = $con->prepare("UPDATE cliente SET nombre=?, telefono1=?, telefono2=?,
    telefono3=?, email=?, presupuesto_maximo=?, id_ejecutivo_asignado=? WHERE id_cliente=? ");
  $up->bind_param('sssssdii', $nombre, $telefono1, $telefono2, $telefono3, $email,
    $presupuesto_maximo, $id_ejecutivo_asignado,$id);
    if ($up -> execute()) {
    header('location:../extend/alerta.php?msj=Cliente actualizado&c=cli&p=in&t=success');
  }else {
    header('location:../extend/alerta.php?msj=El cliente no pudo ser actualizado&c=cli&p=in&t=error');
  }
$ins->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=cli&p=in&t=error');
}
 ?>
