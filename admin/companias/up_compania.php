<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $up = $con->prepare("UPDATE compania SET descripcion=?, pais=? WHERE id=? ");
  $up->bind_param('ssi', $descripcion, $pais,$id);
    if ($up -> execute()) {
    header('location:../extend/alerta.php?msj=Compañía actualizada&c=com&p=in&t=success');
  }else {
    header('location:../extend/alerta.php?msj=La compañía no pudo ser actualizada&c=com&p=in&t=error');
  }
$ins->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=com&p=in&t=error');
}
 ?>
