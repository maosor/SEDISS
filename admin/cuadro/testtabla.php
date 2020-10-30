
<style media="screen">
.tabla{
display: table;
width: 100%;
}
.row{
display: table-row;
background: #ddd;
}
.cel{
display: table-cell;
padding: 12px;
border: solid 1px;
}
.celg{
  display: table-cell;
}

.colgroup{
  display: table-column-group;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>

<?php
include '../conexion/conexion.php';
// Pruebas con objectos
 //class Categoria{
//   public $Id;
//   public $Descripcion;
//   public $Orden;
//   public $Icono;
// }
// // kvstore API url
// $url = 'http://18.224.140.239/SedissWebService/api/categoria';
// $curl = curl_init($url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// $response = json_decode(curl_exec($curl),true);
// curl_close($curl);
// $lista = (object) $response;
// print_r($lista);
// foreach ($response as $key => $value) {
//   $cat = new Categoria();
//   $obj = (object) $value;
//   $cat = $obj;
//   print_r($obj);
//   echo 'Categoria <br>';
//   print_r($cat);
//   echo 'individual <br>';
//   echo $cat->Descripcion;
//   echo $cat->Id;
//   echo '<br>';
// }
//echo $data["categoria"];
$val_org = 1;
$fecha = '2020-09-27 00:00:00,000';
$compania = $_SESSION ['compania'];
$idug=977;
// echo "SELECT CONCAT(0,(SELECT orden FROM tipo_unidades_gestion WHERE id = uo.idpa), uo.orden) * 1, uo.Descripcion as PRODUCCION_HRS_RRHH, @Volumen_Produccion :=p.rubro  as Volumen_Produccion, p.primaria
//    FROM produccion p INNER JOIN tipo_unidades_gestion uo on p.unidadgestion = uo.id
//     WHERE p.unidadgestion = p.producto AND p.primaria in(1,2) AND p.idcompania = ".$compania." AND p.organizacion = ".$val_org." AND p.fecha = '".$fecha."'
//          GROUP BY p.unidadgestion, p.producto, p.primaria UNION
//     SELECT CONCAT(0,(SELECT orden FROM tipo_unidades_gestion WHERE id = u.idpa), u.orden) * 1, i.descripcion AS PRODUCCION_HRS_RRHH, h.rubro,'0' FROM horas h INNER JOIN tipo_unidades_gestion u ON h.unidadgestion = u.id
//       INNER JOIN red_organizacional i ON h.recurso = i.id AND i.tipo = 3 AND h.idcompania = ".$compania." AND h.organizacion = ".$val_org." AND fecha = '".$fecha."'
//    WHERE EXISTS(SELECT 1=1 FROM horas WHERE rubro > 0 AND fecha = '".$fecha."' AND recurso = h.recurso)";

$sel_insum = $con->prepare("SELECT uo.UnidProdPrim, CONCAT(0,(SELECT orden FROM tipo_unidades_gestion WHERE id = uo.idpa), uo.orden) * 1 AS Orden, p.primaria,'0' AS Ord_RH,uo.Descripcion as PRODUCCION_HRS_RRHH, p.rubro  as Volumen_Produccion
   FROM produccion p INNER JOIN tipo_unidades_gestion uo on p.unidadgestion = uo.id
    WHERE p.unidadgestion = p.producto AND p.primaria in(1,2) AND p.idcompania = ? AND p.organizacion = ? AND p.fecha = ?
    GROUP BY p.unidadgestion, p.producto, p.primaria UNION
    SELECT u.UnidProdPrim, CONCAT(0,(SELECT orden FROM tipo_unidades_gestion WHERE id = u.idpa), u.orden) * 1 AS orden,'3', CONCAT(0,(SELECT orden FROM red_organizacional WHERE id = i.idpa), i.orden) * 1,
    i.descripcion AS PRODUCCION_HRS_RRHH, h.rubro FROM horas h INNER JOIN tipo_unidades_gestion u ON h.unidadgestion = u.id AND u.funcion = 0
      INNER JOIN red_organizacional i ON h.recurso = i.id AND i.tipo = 3 AND h.idcompania = ? AND h.organizacion = ? AND fecha = ?
   WHERE EXISTS(SELECT 1=1 FROM horas WHERE rubro > 0 AND fecha = ? AND recurso = h.recurso)");
 $sel_insum -> bind_param('iisiiss', $compania,$val_org,$fecha,$compania,$val_org,$fecha,$fecha);

   $sel_insum -> execute();
  $arr = $sel_insum->get_result()->fetch_all(MYSQLI_ASSOC);
//sort($arr);
//var_dump(json_encode($arr));
echo '<br>';
//var_dump(json_encode($arr2));
sort($arr);
//var_dump(json_encode($arr));
echo '<br>'.$arr[2]["PRODUCCION_HRS_RRHH"];
$primero=True;
 ?>
 <div class="tabla">
     <div class="celg">
<?php foreach ($arr as $key => $value): ?>
  <?php if ($key > 0 && $value["Orden"] != $arr[$key-1]["Orden"]): ?>
    <?php $primero = false; ?>
    <div class="celg">
       <?php endif; ?>
       <div class="row">
       <?php if ($primero==true): ?>
        <div class="cel"> <?php echo $value["PRODUCCION_HRS_RRHH"] ?> </div>
       <?php endif; ?>
        <div class="cel"> <?php echo $value["Volumen_Produccion"] ?></div>
        <?php if ($value["Orden"] != $arr[$key+1]["Orden"]): ?>
          </div>
        <?php endif; ?>
       </div>
<?php endforeach; ?>
      </div>
    </div>
  </div>
