<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $up = $con->prepare("UPDATE comentario SET fecha=?, comentario=? WHERE id=? ");
  $up->bind_param('ssi', $fecha, $comentario,$id);
    if ($up -> execute()) {
    header('location:../extend/alerta.php?msj=Comentario actualizado&id='.$id_cliente.'&c=com&p=in&t=success');
  }else {
    header('location:../extend/alerta.php?msj=El comentario no pudo ser actualizado&id='.$id_cliente.'&c=com&p=in&t=error');
  }
$up->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=com&p=in&t=error');
}
 ?>
