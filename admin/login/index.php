<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  $user = $con->real_escape_string(htmlentities($_POST['usuario']));
  $pass = $con->real_escape_string(htmlentities($_POST['contra']));
  $candado = ' ';
  $str_u = strpos($user, $candado);
  $str_p = strpos($pass, $candado);
  if (is_int($str_u)){
    $user = '';
  }else {
    $usuario = $user;
  }
  if (is_int($str_p)){
    $pass = '';
  }else {
    $pass2 = sha1($pass);
  }
  if ($user == null && $pass == null) {
    header('location:../extend/alerta.php?msj=El formato no es correcto&c=salir&p=salir&t=error');
  }else {
    $sel = $con->query("SELECT id, nombre, apellido1, apellido2, email, password, id_perfil, id_tipo, id_sucursal, foto
      FROM ejecutivo WHERE borrado= 0 AND activo = 1 AND email = '$usuario' AND password = '$pass2' ");
       $row = mysqli_num_rows($sel);
       if ($row == 1) {
         if ($var = $sel->fetch_assoc()) {
            $id = $var['id'];
            $nombre = $var['nombre'];
            $apellido1 = $var['apellido1'];
            $apellido2 = $var['apellido2'];
            $password = $var['password'];
            $email = $var['email'];
            $id_perfil = $var['id_perfil'];
            $id_tipo = $var['id_tipo'];
            $id_sucursal = $var['id_sucursal'];
            $foto = $var['foto'];
         }
         if ($email == $usuario && $password == $pass2) {
            $_SESSION ['id'] = $id;
            $_SESSION ['nombre'] = $nombre;
            $_SESSION ['apellido1'] = $apellido1;
            $_SESSION ['apellido2'] = $apellido2;
            $_SESSION ['email'] = $email;
            $_SESSION ['id_perfil'] = $id_perfil;
            $_SESSION ['id_tipo'] = $id_tipo;
            $_SESSION ['id_sucursal'] = $id_sucursal;
            $_SESSION ['foto'] = $foto;
            header('location:../extend/alerta.php?msj=Bienvenido&c=home&p=home&t=success');
           }
           else {
             header('location:../extend/alerta.php?msj=No tienes el permiso para entrar&c=salir&p=salir&t=error');
         }
       }else {
         header('location:../extend/alerta.php?msj=Nombre de usuario o contraseña incorrecto...&c=salir&p=salir&t=error');
       }
  }
}else {
  header('location:../extend/alerta.php?msj=Utilza el formulario&c=salir&p=salir&t=error');
}
 ?>
