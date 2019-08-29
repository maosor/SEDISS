<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  $pass = $con->real_escape_string(htmlentities($_POST['pass1']));
  $email = $_SESSION['email'];
  $pass = sha1($pass);
  $up = $con->query("UPDATE ejecutivo SET password='$pass' WHERE email='$email'");
  if ($up) {
    header('location:../extend/alerta.php?msj=Password actualizado&c=pe&p=perfil&t=success');
  }else {
    header('location:../extend/alerta.php?msj=El password no pudo ser actualizado&c=pe&p=perfil&t=error');
  }
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=us&p=in&t=error');
}
 ?>
