<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
$nick = $_SESSION['nick'];
$nombre = $con->real_escape_string(htmlentities($_POST['nombre']));
$apellido1 =$con->real_escape_string(htmlentities($_POST['apellido1']));
$apellido2 =$con->real_escape_string(htmlentities($_POST['apellido2']));
$email = $con->real_escape_string(htmlentities($_POST['email']));
$lastemail= $_SESSION['email'];
$up = $con->query("UPDATE ejecutivo SET nombre='$nombre', email = '$email',apellido1= '$apellido1', apellido2= '$apellido2'
  WHERE email='$lastemail'");
if ($up) {
  $_SESSION['nombre'] = $nombre;
  $_SESSION['apellido1'] = $apellido1;
  $_SESSION['apellido2'] = $apellido2;
  $_SESSION['email'] = $email;
  header('location:../extend/alerta.php?msj=Datos actualizados&c=pe&p=perfil&t=success');
}else {
  header('location:../extend/alerta.php?msj=Datos no actualizados&c=pe&p=perfil&t=error');

}

$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=us&p=in&t=error');
}
 ?>
