<?php
include '../extend/header.php';
$id = htmlentities($_GET['id']);
$del = $con->prepare("DELETE FROM cliente WHERE id_cliente = ? ");
$del -> bind_param('i', $id);
if ($del -> execute()) {
  header('location:../extend/alerta.php?msj=Cliente eliminado&c=cli&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=El cliente no pudo ser eliminado&c=cli&p=in&t=error');
}
$del ->close();
$con->close();
 ?>
