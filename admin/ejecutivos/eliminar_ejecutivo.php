<?php
include '../extend/header.php';
$id = htmlentities($_GET['id']);
$del = $con->prepare("UPDATE ejecutivo SET borrado = 1 WHERE id = ?");
$del -> bind_param('i', $id);

if ($del -> execute()) {
  header('location:../extend/alerta.php?msj=Ejecutivo eliminado&c=eje&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=El ejecutivo no pudo ser eliminado&c=eje&p=in&t=error');
}
$del ->close();
$con->close();
 ?>
