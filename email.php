<?php
include 'admin/conexion/conexion_web.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
}
$header= "MIME-VERSION 1.0 \r\n";
$header.="Content-Type: text/html; charset=iso-8859-1 \r\n";
$header.= "From: {$nombre} < {$correo}> \r\n";
$mail = mail("correo@empresa.com", $asunto, $mensaje, $header);
if ($mail) {
  echo "<h4 style='color:green;'>El mensaje ha sido enviado </h4>";
}else{
  echo "<h4 style='color:red;'>El mensaje no pudo ser enviado </h4>";
  }
$con->close();
}else {
    echo "<h4 style='color:red;'>Utilice el formulario </h4>";
}
 ?>
