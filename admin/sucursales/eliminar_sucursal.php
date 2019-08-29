<?php
include '../extend/header.php';
$id = htmlentities($_GET['id']);
$del = $con->prepare("DELETE FROM sucursal WHERE id = ?");
$del -> bind_param('i', $id);

if ($del -> execute()) {
  header('location:../extend/alerta.php?msj=Sucursal eliminada&c=suc&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=La sucursal no pudo ser eliminada&c=suc&p=in&t=error');
}
$del ->close();
$con->close();
 ?>
