<?php
include '../extend/header.php';
$id = htmlentities($_GET['id']);
$del = $con->prepare("DELETE FROM contacto WHERE id_contacto = ? ");
$del -> bind_param('i', $id);
if ($del -> execute()) {
  header('location:../extend/alerta.php?msj=Contacto eliminado&c=con&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=El contacto no pudo ser eliminado&c=con&p=in&t=error');
}
$del ->close();
$con->close();
 ?>
