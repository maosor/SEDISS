<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_POST){
  $json = $_POST['mydata'];
  $organizacion=$_POST['organizacion'];
  $fecha=$_POST['fecha'];
  $accion=$_POST['accion'];
  $data = json_decode($json);
  if($accion == '#insumos')
  {
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
          $sql=$sql."(1, ".$organizacion.", ".ltrim($item->Id,'g-').", ".ltrim($valor->Id,'g-').", '".$fecha."', ".$valor->Rubro.", 'E'),";
        }
    }
    $sql= rtrim($sql,","); // Elimina la ultima coma generada.
    //echo 'Insertado: SQL ==> '.$sql;
}else if($accion == '#produccion')
{
  $del= $con->prepare("DELETE FROM produccion WHERE idcompania = 1 AND organizacion = ? AND fecha = ?");
  $del -> bind_param ('is',$organizacion,$fecha);
  $del -> execute();
  $del -> close();
  $sql="INSERT INTO produccion (idcompania, organizacion, unidadgestion, producto, fecha, rubro, tiporeg, primaria) VALUES ";
    //  print_r($data);
  foreach ($data as $item){
      $n=1;
      foreach ($item->produccion as $valor) {
        if ($valor->Rubro == '')
        {
          $valor->Rubro=0;
        }
/*        if($n==1)
        {
            $n = 2;
        }
        else if($n==2) {
          if (!count($item->produccion)==3) {
            $n = 3;
          }else {
              $n = 1;
          }
        }*/

        $sql=$sql."(1, ".$organizacion.", ".explode("-",$item->Id)[1].", ".ltrim($valor->Id,'p-').", '".$fecha."', ".$valor->Rubro.", 'E', ".$n."),";
        $n++;
      }
  }
  $sql= rtrim($sql,","); // Elimina la ultima coma generada.
  //echo 'Insertado: SQL ==> '.$sql;
}
else if($accion == '#horas')
{
  $del= $con->prepare("DELETE FROM horas WHERE idcompania = 1 AND organizacion = ? AND fecha = ?");
  $del -> bind_param ('is',$organizacion,$fecha);
  $del -> execute();
  $del -> close();
  $sql="INSERT INTO horas (idcompania, organizacion, unidadgestion, recurso, fecha, rubro, tiporeg) VALUES ";
  foreach ($data as $item){
      foreach ($item->hora as $valor) {
        if ($valor->Rubro == '')
        {
          $valor->Rubro=0;
        }
          $sql=$sql."(1, ".$organizacion.", ".ltrim($item->Id,'h-').", ".ltrim($valor->Id,'h-').", '".$fecha."', ".$valor->Rubro.", 'E'),";
      }
  }
  $sql= rtrim($sql,","); // Elimina la ultima coma generada.
//  echo 'Insertado: SQL ==> '.$sql;
}
  $ins = $con->prepare($sql);
  if ($ins -> execute()) {
    if($accion=='#insumos')
    {
      //echo 'insumos';
      include 'gridinsumo.php';
    }else if($accion=='#produccion')
    {
    //  echo 'insumos';
      include 'gridproduccion.php';
    }else if($accion=='#horas')
    {
      //echo 'insumos';
      include 'gridhora.php';
    }

  }else {
    //$log = error('Error Insertando: SQL==>> '.$sql);
    echo "console.log('Error Insertando: SQL==>> ')".$sql;
    echo 'Error Insertando...';
  }
}
?>
