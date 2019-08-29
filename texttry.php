<?php
include 'admin/conexion/conexion_web.php';
function manejador_excepciones($excepción) {
echo "Excepción no capturada: " , $excepción->getMessage(), "\n";
}
try {
  //throw new RuntimeException();
  print "this is our try block\n";
  $id=1;
  $sel_edo = $con->prepare("SELECT estado FROM estados WHERE idestados = ?");
  $sel_edo -> bind_param('i', $id);
  $sel_edo -> execute();
  $res_edo = $sel_edo -> get_result();
  if ($f_edo=$res_edo->fetch_assoc()) {
    echo $f_edo['estado'];
  }
set_exception_handler('manejador_excepciones');

throw new Exception('Excepción No Capturada');
echo "No Ejecutado\n";

} catch (PDOException  $e) {
  print "something went wrong\n";
} finally {
  print "This part is always executed\n";
}
 ?>
