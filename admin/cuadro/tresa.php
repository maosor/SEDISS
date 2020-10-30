<?php //include '../extend/header.php';
include '../extend/funciones.php';
include '../conexion/conexion.php'
?>

<link href="../css/reportstyles.css" rel="stylesheet">
<?php if (!isset($_GET['c']) && (!isset($_GET['f'])||$_GET['f']=="undefined")) {
  echo "<div> <h3>No hay datos para mostrar...</h3></div>";
}
else {
  echo "Establecimiento: ".compania($_SESSION ['compania'])."<br>";
  echo "Cuadro N° 3A: Productividad y Composición del Recurso Humano <br>";
  echo "Mes de: ".$_GET['f']."<br>"; ?>

  <div class="row"> <!-- Costos directos-->
        <div id="insumos" class="col s12">
      <?php
      $val_org = $_GET['c'];
      $fecha = $_GET['f'];
      $compania = $_SESSION ['compania'];
      $titfila = true;
      $i=0;
      $index = 0;
      $total=0;
      $sel_unid = $con->prepare("SELECT uo.id, uo.Descripcion FROM produccion p INNER JOIN tipo_unidades_gestion uo ON p.unidadgestion = uo.id
          WHERE p.unidadgestion = p.producto AND p.idcompania = ? AND p.organizacion = ? AND p.fecha = ?
          GROUP BY p.unidadgestion, p.producto ORDER BY funcion , CONCAT(0,(SELECT orden FROM tipo_unidades_gestion WHERE id = uo.idpa), uo.orden) * 1");
        $sel_unid -> bind_param('iis',$compania, $val_org,$fecha);
        $sel_unid -> execute();
        $sel_unid-> store_result();
        $sel_unid -> bind_result($idug, $unidadgestion);
        $rows= $sel_unid->num_rows;
         ?>
        <div class="divTable">
          <div class="divTableBody">
            <!-- <div class="divTableRow">
              <div class="divTableCell">
                SERVICIOS INTRAHOSPITALARIOS
              </div>
            </div> -->
              <div class="divTableRow">
                 <div class="divTableCell" style="width: 140px;"><b>PRODUCCION<br>HRS RRHH</b></div>
                <?php $c=0;
                 while ($sel_unid ->fetch()):
                     ?>
                  <div class="divTableCell number" style="width: 140px;"><b><?php echo $unidadgestion ?></b></div>
                <!-- <div class="divTableCell"><b>TOTAL</b></div> -->

            <?php endwhile;?>
            <div class="divTableCell number" style="width: 140px;"><b>TOTAL</b></div>
              </div>
              <?php
              $sel_unid-> data_seek(0);
             //echo "<div class='divTableCell'>";
             $primerainteraccion=true;
              while ($sel_unid ->fetch()):
                $sel_insum = $con->prepare("SELECT uo.Descripcion as PRODUCCION_HRS_RRHH, @Volumen_Produccion :=p.rubro  as Volumen_Produccion, p.primaria
                   FROM produccion p INNER JOIN tipo_unidades_gestion uo on p.unidadgestion = uo.id
                    WHERE p.unidadgestion = p.producto AND p.primaria in(1,2) AND p.idcompania = ? AND p.organizacion = ? AND p.fecha = ? and p.unidadgestion = ?
                    GROUP BY p.unidadgestion, p.producto, p.primaria UNION
                    SELECT * FROM (SELECT i.descripcion AS PRODUCCION_HRS_RRHH, h.rubro,'0' FROM horas h INNER JOIN red_organizacional i
                   ON h.recurso = i.id AND i.tipo = 3 AND h.idcompania = ? AND h.organizacion = ? AND fecha = ? AND h.unidadgestion = ?
                   WHERE EXISTS(SELECT 1=1 FROM horas WHERE rubro > 0 AND fecha = ? AND recurso = h.recurso)
                   ORDER BY (SELECT orden FROM red_organizacional WHERE id = i.idpa),orden) AS HORAS;");
                 $sel_insum -> bind_param('iisiiisis', $compania,$val_org,$fecha,$idug,$compania,$val_org,$fecha,$idug,$fecha);
                  $sel_insum -> execute();
                  $sel_insum-> store_result();
                  $sel_insum -> bind_result($idin, $insumo,$primaria);
                  $prods= $sel_insum->num_rows;
                    //echo $primerainteraccion;
                  if($primerainteraccion)
                  {

                    echo "<div class='divTableRow'>";
                    //$primerainteraccion=false;
                  }
                //  echo $prods;
                // echo $primaria==1&&$i==0?"<div class='divTableCellg'><div class='divTableRow'><div class='divTableCell'>EGRESOS</div></div>":'';
                // echo $primaria==2&&$i==0?"<div class='divTableRow'><div class='divTableCell'>CONSULTAS</div></div>":'';
                // echo $primaria==0&&$i==0?"<div class='divTableRow'><div class='divTableCell'>".$idin."</div></div>":'';
                // if ($p==$prods) {
                //   echo "</div>";
                // }
                  echo "<div class='divTableCellg'>";
                  $p=0;
                  while ($sel_insum ->fetch()):
                    if($primerainteraccion)
                    {
                     echo $primaria==1&&$i==0?"<div class='divTableRow'><div class='divTableCell sinBordeBottom' style='width: 140px;'>EGRESOS</div></div>":'';
                     echo $primaria==2&&$i==0?"<div class='divTableRow'><div class='divTableCell sinBordeTop' style='width: 140px;'>CONSULTAS</div></div>":'';
                     echo $primaria==0&&$i==0?"<div class='divTableRow'><div class='divTableCell' style='width: 140px;'>".$idin."</div></div>":'';
                     echo $primaria==0&&$i==0?"<div class='divTableRow'><div class='divTableCell' style='width: 140px;'>Por egreso o consulta</div></div>":'';
                     echo $primaria==0&&$i==0?"<div class='divTableRow'><div class='divTableCell' style='width: 140px;'>Por día paciente</div></div>":'';


                     echo  $primaria==1&&$i==0?"<div class='divTableCellg'>":'';
                   }
                   else {
                     switch ($primaria){
                       case 1:
                         $egreso = $insumo;
                         break;
                       case 2:
                         $consulta = $insumo;
                         break;
                     }
                   ?>
                    <div class='divTableRow'><div class="divTableCell number"style="width: 140px;"><?php echo number_format($insumo, 2, ',', ' ')?></div></div>
                   <?php
                  $arrProd[$i][] = $insumo;
                   if ($primaria==0): ?>
                     <div class='divTableRow'><div class="divTableCell number"style="width: 140px;"><?php echo number_format($insumo/($egreso>0?$egreso:1), 2, ',', ' ')?></div></div>
                     <div class='divTableRow'><div class="divTableCell number"style="width: 140px;"><?php echo number_format($insumo/($consulta>0?$consulta:1), 2, ',', ' ')?></div></div>
                   <?php
                   $arrProd[$i][] = $insumo/($egreso>0?$egreso:1);
                   $arrProd[$i][] = $insumo/($consulta>0?$consulta:1);
                  endif;
                 }?>

                <?php
                $p++;
                endwhile;
                echo "</div>";
                if($i==$rows)
                {
                //  echo "</div>";
                }
                $p=0;
                $i++;
                if($primerainteraccion)
                {
                //  echo "<div class='divTableRow'>";
                  echo "</div>";
                  $primerainteraccion=false;
                  $sel_unid-> data_seek(0);
                }
            endwhile;
             $total=0;
             $c=0;
             ?>
            <div class='divTableCellg'>
             <?php
             foreach ($arrProd[1] as $key => $value) {
             ?>
               <div class='divTableRow'><div class="divTableCell number"style="width: 140px;"><?php echo number_format(array_sum(array_column($arrProd,$c)), 2, ',', ' ')?></div></div>
               <?php
               $c++;
               }
                ?>
             </div>
           </div>
          </div>
        </div>
  </div>
  </div>
<?php }



//echo '<br>';
// print_r(array_sum($value));
// print_r(array_sum(array_column($arrProd, 1)));
//print_r($arrProd);
?>
