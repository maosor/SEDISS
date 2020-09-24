<?php include '../conexion/conexion.php';
$id = htmlentities($_GET['id']);
$del = $con->prepare("DELETE FROM compania WHERE id = ?");
$del -> bind_param('i', $id);

if ($del -> execute()) {
  header( 'location:../extend/alerta.php?msj=compañía eliminada&c=com&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=La compañía no pudo ser eliminada&c=com&p=in&t=error');
}
$del ->close();
$con->close();
 ?>
