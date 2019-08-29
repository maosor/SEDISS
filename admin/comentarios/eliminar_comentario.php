<?php
include '../extend/header.php';
$id = htmlentities($_GET['id']);
$del = $con->prepare("DELETE FROM comentario WHERE id = ? ");
$del -> bind_param('i', $id);
if ($del -> execute()) {
  header('location:../extend/alerta.php?msj=Comentario eliminado&id='.$_GET['cli'].'&c=com&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=El comentario no pudo ser eliminado&id='.$_GET['cli'].'&c=com&p=in&t=error');
}
$del ->close();
$con->close();
 ?>
