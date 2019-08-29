<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
$id='';
$ins = $con->prepare("INSERT INTO contacto(id_contacto, nombre, telefono_casa,telefono_oficina,telefono_celular,
                      fax,email,es_corredor,email2)
 VALUES (?,?,?,?,?,?,?,?,?)");
$ins -> bind_param('sssssssss',$id, $nombre, $telefono_casa,$telefono_oficina,$telefono_celular,
                      $fax,$email,$es_corredor,$email2);
if ($ins -> execute()) {
  header('location:../extend/alerta.php?msj=Contacto registrado&c=con&p=in&t=success');
}else {
  header('location:../extend/alerta.php?msj=El contacto no pudo ser registrado&c=con&p=in&t=error');
}
$ins ->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=con&p=in&t=error');
}
 ?>
