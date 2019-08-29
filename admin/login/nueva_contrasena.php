<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
$usuario = $con->real_escape_string(htmlentities($_POST['usuario']));
$password = substr( md5(microtime()), 1, 8);
//$mensaje= "<html><head><title>Recuperar contraseña</title></head>";
//$mensaje.= "<body><p>Su contraseña temporal es: ".$password."\r\n";
//$mensaje.="Recuerde la importancia de guardar su contraseña y cambiar la temporal\r\n</p></body></html>";
$mensaje= "Su contraseña temporal es: ".$password."\r\nRecuerde la importancia de guardar su contraseña y cambiar la temporal.\r\n";
$password = sha1($password);
$up = $con->query("UPDATE ejecutivo SET password = '$password'
  WHERE email='$usuario'");
if ($up) {
  //$header= 'MIME-VERSION 1.0'. "\r\n";
  //$header.='Content-Type: text/html; charset=iso-8859-1'." \r\n";
  $asunto = "Correo generado automáticamente para recuerar su contraseña\r\n";
  $header= 'From: Recuperar contraseña <'.$usuario.'>'."\r\n";

  $mail = mail($usuario, $asunto, $mensaje, $header);
  if ($mail) {
  header('location:../extend/alerta.php?msj=Su nueva contraseña ha sido enviada a su email.&c=salir&p=salir&t=success');
}else {
  header('location:../extend/alerta.php?msj=El correo no pudo ser enviado&c=salir&p=salir&t=error');
}
}else {
  header('location:../extend/alerta.php?msj=Su contraseña no pudo ser restablecida&c=salir&p=salir&t=error');

}

$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=us&p=in&t=error');
}
 ?>
