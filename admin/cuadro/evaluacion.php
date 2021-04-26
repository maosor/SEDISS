<?php //include '../extend/header.php';
include '../extend/funciones.php';
include '../conexion/conexion.php'
?>
<style>
html{
  font-family: Arial Narrow,Arial,sans-serif;
  font-size: 11px;
}
/* DivTable.com */
.divTable{
display: table;
width: 100%;
}
.divTableRow {
display: table-row;
}
.divTableHeading {
background-color: #EEE;
display: table-header-group;
}
.divTableCell, .divTableHead {
border: 1px solid #999999;
display: table-cell;
padding: 0.3vw 0.5vw;
}
.divTableHeading {
background-color: #EEE;
display: table-header-group;
font-weight: bold;
}
.divTableFoot {
background-color: #EEE;
display: table-footer-group;
font-weight: bold;
}
.divTableBody {
display: table-row-group;
}
.number{
  text-align: right;
}
.colspan3
 {
   width: 300px; /*3 times the standard cell width of 100px - colspan3 */
 }
 .half
 {
   width: 50vw;
 }
 .whole
 {
   width: 49vw;
   min-width: 49vw;
   border: solid 2px #999999;
 }
 .thick_border{
   border: solid 2px #999999;
 }
 .incols
 {
   display: table-cell;
   width: 24vw;
 }
 .inblock
 {
   display: block;
 }
 .halfHeadtable{
   display: block ruby;
   width: 100%;
   border: none;
 }
</style>
<?php if (!isset($_GET['c']) && (!isset($_GET['f'])||$_GET['f']=="undefined")) {
  echo "<div> <h3>No hay datos para mostrar...</h3></div>";
}
else {
  echo "<div class='row divTableCell whole'><br><h2>Establecimiento: ".compania($_SESSION ['compania'])."<br>";
  echo "EVALUACION INSTITUCIONAL <br>";
  echo "HOSPITALES LOCALES <br>";
  echo "Mes de: ".$_GET['f']."<br></h3></div><br>";
  echo "<div class='row divTableCell whole'><br><h3>Productividad del Recurso Cama <br> </h3><br></div>";
  ?>

<div class="row ">
    <div id="insumos" class="col s12">
    <?php
    $organizacion = $_SESSION['compania'];
    $val_org = $_GET['c'];
    $fecha = $_GET['f'];
    $sel = $con->prepare("CALL GetProdRecursoCama (?,?,?)");
      $sel -> bind_param('iis',$organizacion, $val_org,$fecha);
      $sel -> execute();
      $sel-> store_result();
      $sel -> bind_result($primaria, $egresos, $indice, $estancia, $unitario, $total);
       ?>
      <div class="divTable half thick_border">
        <div class="divTableBody">
            <div class="divTableRow">
              <div class="divTableCell " style='width: 180px;'><b></b></div>
              <div class="divTableCell " style='width: 100px;'><b>Egresos</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Indice <br>Ocupacional </b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Estancia  <br>promedio</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Costo <br>Unitario</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Costo <br>Total</b></div>
            </div>
          <?php while ($sel ->fetch()):

            ?>
          <div class="divTableRow">

              <div class="divTableCell "style='width: 180px;'><b><?php echo $primaria<>1?'Egresos':'Días Paciente' ?></b></div>
              <div class="divTableCell number" style='width: 100px;'><?php echo number_format($egresos, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='width: 100px;'><?php echo $indice=='-'?$indice:number_format($indice, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='width: 100px;'><?php echo $estancia==''?$estancia:number_format($estancia, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='width: 100px;'><?php echo number_format($unitario, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='width: 100px;'><?php echo $total==''?$total:number_format($total, 2, ',', ' ') ?></div>
            </div>
          <?php endwhile;
          $sel->close();
          ?>
      </div>
    </div>
  </div>
</div>
<br></br>
<div class="row">
<?php  echo "<div class='row divTableCell whole '><br><h3>Productividad del Recurso Humano - Internación </h3><br></div>";?>
    <div id="insumos" class="col s12">
    <?php
    $sel = $con->prepare("CALL GetProdRecursoHumano (?,?,?)");
      $sel -> bind_param('iis',$organizacion, $val_org,$fecha);
      $sel -> execute();
      $sel-> store_result();
      $sel -> bind_result($descripcion, $horas,$hegreso, $hdiapacl);
       ?>
      <div class="divTable half thick_border">
        <div class="divTableBody">
            <div class="divTableRow">
              <div class="divTableCell " style='width: 180px;'><b>HRS Personal</b></div>
              <div class="divTableCell " style='width: 100px;'><b>Total horas</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Hrs x Egreso</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Hrs x D-Pac</b></div>
              <div class="divTableCell number" style='min-width: 200px;'><b></b></div>

            </div>
          <?php while ($sel ->fetch()):

            ?>
          <div class="divTableRow">

              <div class="divTableCell "style='min-width: 180px;'><b><?php echo $descripcion ?></b></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($horas, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($hegreso, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($hdiapacl, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='min-width: 200px;'></div>
            </div>
          <?php endwhile;
          $sel->close();
          ?>
      </div>
    </div>
  </div>
</div>
<br></br>
<div class="row">
<?php  echo "<div class='row divTableCell whole'><br><h3>Producción, Costos y Productividad de los Servicios Ambulatorios </h3><br></div>";?>
    <div id="insumos" class="col s12">
    <?php
    $sel = $con->prepare("CALL GetProdCosAmbulatorios (?,?,?)");
      $sel -> bind_param('iis',$organizacion, $val_org,$fecha);
      $sel -> execute();
      $sel-> store_result();
      $sel -> bind_result($Id, $descripcion, $Costo_Total, $Consultas, $Costo_Unitario);
       ?>
      <div class="divTable half thick_border">
        <div class="divTableBody">
            <div class="divTableRow">
              <div class="divTableCell " style='width: 180px;'><b></b></div>
              <div class="divTableCell " style='width: 100px;'><b>Costo Total</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Consultas</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Costo unitario</b></div>
              <div class="divTableCell number" style='min-width: 200px;'><b></b></div>

            </div>
          <?php while ($sel ->fetch()):

            ?>
          <div class="divTableRow">

              <div class="divTableCell "style='min-width: 180px;'><b><?php echo $descripcion ?></b></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($Costo_Total, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($Consultas, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($Costo_Unitario, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='min-width: 200px;'></div>
            </div>
          <?php endwhile;
          $sel->close();
          ?>
      </div>
    </div>
  </div>
</div>
<br></br>
<div class="row">
<?php  echo "<div class='row divTableCell whole inblock'><br><h3>Atención Ambulatoria - Productividad del Recurso Humano </h3><br></div>";?>
    <div id="insumos" class="col s6 incols">
    <?php
    $unidad=11321;
    $sel = $con->prepare("CALL GetProdAmbulatoriosRecursoHumano (?,?,?,?)");
      $sel -> bind_param('iisi',$organizacion, $val_org,$fecha,$unidad);
      $sel -> execute();
      $sel-> store_result();
      $sel -> bind_result($descripcion, $total_hrs, $horasxconsulta);
       ?>
      <div class="divTable thick_border">
        <div class="divTableBody">
          <div class="divTableRow">
            <div class="divTableCell halfHeadtable" ><b>CONSULTA EXTERNA</b></div>
          </div>
            <div class="divTableRow">
              <div class="divTableCell " style='width: 180px;'><b></b></div>
              <div class="divTableCell " style='width: 100px;'><b>Costo Total</b></div>
              <div class="divTableCell number" style='width: 100px;'><b>Costo unitario</b></div>

            </div>
          <?php $costoTotal =0;
                $porcentTotal=0;
                while ($sel ->fetch()):
                  $costoTotal +=$total_hrs;
                  $porcentTotal+=$horasxconsulta;

            ?>
          <div class="divTableRow">

              <div class="divTableCell "style='min-width: 180px;'><b><?php echo $descripcion ?></b></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($total_hrs, 2, ',', ' ') ?></div>
              <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($horasxconsulta, 2, ',', ' ') ?></div>
            </div>
          <?php endwhile;
          $sel->close();
          ?>
          <div class="divTableRow">

              <div class="divTableCell "style='min-width: 100px;'><b>Total</b></div>
              <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($costoTotal, 2, ',', ' ') ?></b></div>
              <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($porcentTotal, 2, ',', ' ') ?></b></div>
            </div>
      </div>
      </div>
    </div>


  <div id="insumos" class="col s6 incols">
  <?php
  $unidad=11322;
  $sel = $con->prepare("CALL GetProdAmbulatoriosRecursoHumano (?,?,?,?)");
    $sel -> bind_param('iisi',$organizacion, $val_org,$fecha,$unidad);
    $sel -> execute();
    $sel-> store_result();
    $sel -> bind_result($descripcion, $total_hrs, $horasxconsulta);
     ?>
    <div class="divTable thick_border">
      <div class="divTableBody">
        <div class="divTableRow">
          <div class="divTableCell halfHeadtable" ><b>CONSULTA DE EMERGENCIA</b></div>
        </div>
          <div class="divTableRow">
            <div class="divTableCell " style='width: 100px;'><b></b></div>
            <div class="divTableCell " style='width: 100px;'><b>Costo Total</b></div>
            <div class="divTableCell number" style='width: 100px;'><b>Costo unitario</b></div>

          </div>
        <?php $costoTotal =0;
              $porcentTotal=0;
              while ($sel ->fetch()):
                $costoTotal +=$total_hrs;
                $porcentTotal+=$horasxconsulta;

          ?>
        <div class="divTableRow">

            <div class="divTableCell "style='min-width: 100px;'></div>
            <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($total_hrs, 2, ',', ' ') ?></div>
            <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($horasxconsulta, 2, ',', ' ') ?></div>
          </div>
        <?php endwhile;
        $sel->close();
        ?>
        <div class="divTableRow">

            <div class="divTableCell "style='min-width: 100px;'><b>Total</b></div>
            <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($costoTotal, 2, ',', ' ') ?></b></div>
            <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($porcentTotal, 2, ',', ' ') ?></b></div>
          </div>
    </div>
  </div>

</div>
<br>
<div id="insumos" class="col s6 incols">
<?php
$unidad=11321;
$sel = $con->prepare("CALL GetCostoDirecto (?,?,?)");
  $sel -> bind_param('iis',$organizacion, $val_org,$fecha);
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($descripcion, $total, $porcent);
   ?>
  <div class="divTable thick_border">
    <div class="divTableBody">
      <div class="divTableRow">
        <div class="divTableCell halfHeadtable" ><b>COSTOS DIRECTOS</b></div>
      </div>
        <div class="divTableRow">
          <div class="divTableCell " style='width: 180px;'><b>Rubros</b></div>
          <div class="divTableCell " style='width: 100px;'><b>Total</b></div>
          <div class="divTableCell number" style='width: 100px;'><b>%</b></div>

        </div>
      <?php
          $costoTotal =0;
          $porcentTotal=0;
          while ($sel ->fetch()):
            $costoTotal +=$total;
            $porcentTotal+=$porcent;

        ?>
      <div class="divTableRow">

          <div class="divTableCell "style='min-width: 180px;'><b><?php echo $descripcion ?></b></div>
          <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($total, 2, ',', ' ') ?></div>
          <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($porcent, 2, ',', ' ') ?></div>
        </div>
      <?php endwhile;
      $sel->close();
      ?>
      <div class="divTableRow">

          <div class="divTableCell "style='min-width: 100px;'><b>Total</b></div>
          <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($costoTotal, 2, ',', ' ') ?></b></div>
          <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($porcentTotal, 2, ',', ' ') ?></b></div>
        </div>
  </div>
</div>

</div>
<div id="insumos" class="col s6 incols">
<?php
$sel = $con->prepare("CALL GetCostoindirecto (?,?,?)");
  $sel -> bind_param('iis',$organizacion, $val_org,$fecha);
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($descripcion, $costos, $porcent);
   ?>
  <div class="divTable thick_border">
    <div class="divTableBody">
      <div class="divTableRow">
        <div class="divTableCell halfHeadtable" ><b>COSTOS INDIRECTOS</b></div>
      </div>
        <div class="divTableRow">
          <div class="divTableCell " style='width: 100px;'><b>Serv Apoyo</b></div>
          <div class="divTableCell " style='width: 100px;'><b>Costos</b></div>
          <div class="divTableCell number" style='width: 100px;'><b>%</b></div>

        </div>
      <?php
      $costoTotal =0;
      $porcentTotal=0;
      while ($sel ->fetch()):
        $costoTotal +=$costos;
        $porcentTotal+=$porcent;
        ?>
      <div class="divTableRow">
          <div class="divTableCell "style='min-width: 100px;'><?php echo $descripcion ?></div>
          <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($costos, 2, ',', ' ') ?></div>
          <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($porcent, 2, ',', ' ') ?></div>
        </div>
      <?php endwhile;

      $sel->close();
      ?>
      <div class="divTableRow">

          <div class="divTableCell "style='min-width: 100px;'><b>Total</b></div>
          <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($costoTotal, 2, ',', ' ') ?></b></div>
          <div class="divTableCell number" style='min-width: 100px;'><b><?php echo number_format($porcentTotal, 2, ',', ' ') ?></b></div>
        </div>

  </div>
</div>

</div>
<br>
<div id="insumos" class="col s6 incols">
<?php
$sel = $con->prepare("CALL GetCostoPerCapita (?,?,?)");
  $sel -> bind_param('iis',$organizacion, $val_org,$fecha);
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($poblacion, $egresos, $consultas, $servicios);
   ?>
  <div class="divTable thick_border">
    <div class="divTableBody">
      <div class="divTableRow">
        <div class="divTableCell halfHeadtable"><b>Covertura y Gasto Per Capita</b></div>
      </div>
        <div class="divTableRow">
          <div class="divTableCell " style='width: 100px;'><b>Problación</b></div>
          <div class="divTableCell " style='width: 100px;'><b>Total Egresos</b></div>
          <div class="divTableCell number" style='width: 100px;'><b>Total Consultas</b></div>
          <div class="divTableCell number" style='width: 100px;'><b>Total Servicioes</b></div>

        </div>
      <?php
      $costoTotal =0;
      $porcentTotal=0;
      while ($sel ->fetch()):
        $costoTotal +=$costos;
        $porcentTotal+=$porcent;
        ?>
      <div class="divTableRow">

          <div class="divTableCell number "style='min-width: 100px;'><?php echo number_format($poblacion, 2, ',', ' ')?></div>
          <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($egresos, 2, ',', ' ') ?></div>
          <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($consultas, 2, ',', ' ') ?></div>
          <div class="divTableCell number" style='min-width: 100px;'><?php echo number_format($servicios, 2, ',', ' ') ?></div>
        </div>
      <?php endwhile;

      $sel->close();
      ?>
      <div class="divTableRow">

          <div class="divTableCell number "style='min-width: 100px;'>Covertura por 1000 habitantes: </div>
          <div class="divTableCell number "style='min-width: 100px;'><?php echo number_format($poblacion/$servicios, 2, ',', ' ') ?> </div>
          <div class="divTableCell number" style='min-width: 100px;'>Costo per Capita</div>
          <div class="divTableCell number" style='min-width: 100px;'></div>

        </div>
  </div>
</div>

</div>
</div>
<?php } ?>
