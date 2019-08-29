<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
$id='';
$estatus= 'Activo';
$id_ejecutivo_agrego = $_SESSION['id'];
$ins = $con->prepare("INSERT INTO comentario(id, fecha, comentario, id_cliente)
 VALUES (?,?,?,?)");
$ins -> bind_param('issi',$id, $fecha, $comentario, $id_cliente);
if ($ins -> execute()) {
  header('location:../extend/alerta.php?msj=Comentario registrado&id='.$id_cliente.'&c=com&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=El comentario no pudo ser registrado&id='.$id_cliente.'&c=com&p=in&t=error');
}
$ins ->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=com&p=in&t=error');
}
 ?>
