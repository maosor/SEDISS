<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_POST){
  $json = $_POST['mydata'];
  $organizacion=$_POST['organizacion'];
  $fecha=$_POST['fecha'];
  $data = json_decode($json);
  $del= $con->prepare("DELETE FROM gastos WHERE idcompania = 1 AND organizacion = ? AND fecha = ?");
  $del -> bind_param ('is',$organizacion,$fecha);
  $del -> execute();
  $del -> close();
  $sql="INSERT INTO gastos (idcompania, organizacion, unidadgestion, insumo, fecha, rubro, tiporeg) VALUES ";
  foreach ($data as $item){
      foreach ($item->insumo as $valor) {
        if ($valor->Rubro == '')
        {
          $valor->Rubro=0;
        }
        $sql=$sql."(1, ".$organizacion.", ".$item->Id.", ".$valor->Id.", '".$fecha."', ".$valor->Rubro.", 'E'),";
      }
  }
  $sql= rtrim($sql,","); // Elimina la ultima coma generada.
  //$log= info('Insertado: SQL ==> '.$sql);
  $ins = $con->prepare($sql);
  if ($ins -> execute()) {
    include 'gridinsumo.php';
  }else {
    //$log = error('Error Insertando: SQL==>> '.$sql);
    echo "console.log('Error Insertando: SQL==>> ')".$sql;
    echo 'Error Insertando...';
  }
}
?>
