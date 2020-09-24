<?php //include '../extend/header.php';
include '../extend/funciones.php';
include '../conexion/conexion.php'
?>
<style media="screen">
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
padding: 3px 10px;
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
</style>
<?php if (!isset($_GET['c']) && (!isset($_GET['f'])||$_GET['f']=="undefined")) {
  echo "<div> <h3>No hay datos para mostrar...</h3></div>";
}
else {
  echo "Establecimiento: ".compania($_SESSION ['compania'])."<br>";
  echo "Cuadro N° 1: INDICES DE RENDIMIENTO SERVICIOS COMPLEMENTARIOS <br>";
  echo "Mes de: ".$_GET['f']."<br>"; ?>
<div class="row">
    <div id="insumos" class="col s12">
    <?php
    $organizacion = $_SESSION['compania'];
    $val_org = $_GET['c'];
    $fecha = $_GET['f'];
    $sel_clasif = $con->prepare("CALL GetCuadroUno (?,?,?)");
      $sel_clasif -> bind_param('iis',$organizacion, $val_org,$fecha);
      $sel_clasif -> execute();
      $sel_clasif-> store_result();
      $sel_clasif -> bind_result($Funcion, $Servicios, $Unidad_Produccion, $Primario, $Secundario, $Volumen_Produccion, $Costo_Total, $Costo_Unitario, $Camas, $Indice_ocupacional, $Promedio_Estancia, $Indice_Rotación);
       ?>
      <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">
              <div class="divTableCell "><b>Servicios</b></div>
              <div class="divTableCell "><b>Unidad <br>de produccion </b></div>
              <div class="divTableCell number"><b>Volumen <br>de Producción </b></div>
              <div class="divTableCell number"><b>Costos <br>Totales</b></div>
              <div class="divTableCell number"><b>Costos <br>Unitarios</b></div>
              <div class="divTableCell number"><b>Indice <br>ocupacional</b></div>
              <div class="divTableCell number"><b>Promedio <br>Estancia</b></div>
              <div class="divTableCell number"><b>Indice <br>de Rotación</b></div>
              <div class="divTableCell number"><b>Camas</b></div>
            </div>
          <?php while ($sel_clasif ->fetch()):

            ?>
          <div class="divTableRow">

              <div class="divTableCell "><b><?php echo $Funcion<>'02'?$Servicios:'' ?></b></div>
              <div class="divTableCell "><?php echo $Unidad_Produccion ?></div>
              <div class="divTableCell number"><?php echo number_format($Volumen_Produccion, 2, ',', ' ') ?></div>
              <div class="divTableCell number"><?php echo $Funcion<>'02'?number_format($Costo_Total, 2, ',', ' '):'' ?></div>
              <div class="divTableCell number"><?php echo number_format($Costo_Unitario, 2, ',', ' ') ?></div>
              <div class="divTableCell number"><?php echo $Funcion=='02'?number_format($Indice_ocupacional, 2, ',', ' '):'' ?></div>
              <div class="divTableCell number"><?php echo $Funcion=='02'?number_format($Promedio_Estancia, 2, ',', ' '):'' ?></div>
              <div class="divTableCell number"><?php echo $Funcion=='02'?number_format($Indice_Rotación, 2, ',', ' '):'' ?></div>
              <div class="divTableCell number"><?php echo $Funcion=='02'?number_format($Camas, 2, ',', ' '):'' ?></div>
            </div>
          <?php endwhile;

          ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
