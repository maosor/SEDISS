<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
$id = htmlentities($_POST['id']);
$foto = htmlentities($_POST['anterior']);
$ruta = $_FILES['foto']['tmp_name'];
$imagen = $_FILES['foto']['name'];
$ancho = 500;
$alto = 400;
$info = pathinfo($imagen);
$tamaño = getimagesize($ruta);
$width = $tamaño[0];
$heigth = $tamaño[1];
if ($info['extension']== "JPG" || $info['extension']== "jpg") {
  $imagenvieja = imagecreatefromjpeg($ruta);
  $nueva = imagecreatetruecolor($ancho, $alto);
  imagecopyresampled($nueva, $imagenvieja, 0,0,0,0, $ancho, $alto, $width, $heigth);
  $rand = rand(000,999);
  $copia = "casas/foto_principal-".$rand.$id.".jpg";
  imagejpeg($nueva, $copia);

}elseif ($info['extension']== "PNG" || $info['extension']== "png") {
  $imagenvieja = imagecreatefrompng($ruta);
  $nueva = imagecreatetruecolor($ancho, $alto);
  imagecopyresampled($nueva, $imagenvieja, 0,0,0,0, $ancho, $alto, $width, $heigth);
  $copia = "casas/foto_principal-".$rand.$id.".png";
  imagepng($nueva, $copia);
}else {
  header('location:../extend/alerta.php?msj=Solo se acepta formato JPG y PNG&c=prop&p=img&t=error&id='.$id.'');
  exit;
}
$up = $con->prepare("UPDATE inventario SET foto_principal=? WHERE propiedad=? ");
$up -> bind_param('ss', $copia, $id);
if ($up -> execute()) {
  if ($foto != 'casas/foto_principal.png') {
    unlink($foto);
  }
  header('location:../extend/alerta.php?msj=Foto principal actualizada&c=prop&p=img&t=success&id='.$id.'');
}else {
  header('location:../extend/alerta.php?msj=La foto principal no pudo ser actualizada&c=prop&p=img&t=error&id='.$id.'');
}


$up -> close();
$con-> close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=prop&p=img&t=error&id='.$id.'');
}
 ?>
