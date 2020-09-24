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
<?php echo "Establecimiento: ".compania($_SESSION ['compania'])."<br>";
echo "Cuadro N° 2: INDICES DE RENDIMIENTO SERVICIOS COMPLEMENTARIOS <br>";
echo "Mes de: Julio, 2020 <br>"; ?>
<div class="row">
    <div id="insumos" class="col s12">
    <?php
    $val_org = $_GET['c'];
    $fecha = $_GET['f'];
    $titfila = true;
    $i=0;
    $p=1;
    $index = 0;
    $total=0;
    $sel_clasif = $con->prepare("SELECT id, descripcion from tipo_unidades_gestion where id in (
        SELECT (select idpa from tipo_unidades_gestion where tu.idpa = id) FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion
        WHERE organizacion = ? and tu.Funcion = 0 order by tu.id)");
      $sel_clasif -> bind_param('i', $val_org);
      $sel_clasif -> execute();
      $sel_clasif-> store_result();
      $sel_clasif -> bind_result($idclasif, $unidadgestionclasif);
      $strid= 'id';
      //print_r($sel_clasif);
      if ($sel_clasif->affected_rows==0)
        {
        $sel_clasif ->close();
        $sel_clasif = $con->prepare("SELECT id, descripcion from tipo_unidades_gestion where id in (
            SELECT idpa FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion
            WHERE organizacion = ? and tu.Funcion = 0 order by tu.id)");
          $sel_clasif -> bind_param('i', $val_org);
          $sel_clasif -> execute();
          $sel_clasif-> store_result();
          $sel_clasif -> bind_result($idclasif, $unidadgestionclasif);
          $strid= 'idpa';
      }
       ?>
      <div class="divTable">
        <div class="divTableBody">
          <div class="divTableRow">
            <?php while ($sel_clasif ->fetch()):

              ?>
              <div class="divTableCell "><b><?php echo $unidadgestionclasif ?></b></div>

            <?php endwhile;
            $sel_clasif->data_seek(0);
            while ($sel_clasif ->fetch()):
            $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion
               WHERE organizacion = ? and tu.Funcion = 0 and tu.idpa in (SELECT DISTINCT ".$strid." FROM tipo_unidades_gestion where idpa = ? ) order by tu.id");
              // echo  "SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion
               //    WHERE organizacion =".$val_org."
               //    and tu.Funcion = 0 and tu.idpa in (SELECT DISTINCT id FROM tipo_unidades_gestion where idpa = ".$idclasif." ) order by tu.id";
              $sel_unid -> bind_param('ii', $val_org, $idclasif);
              $sel_unid -> execute();
              $sel_unid-> store_result();
              $sel_unid -> bind_result($idug, $unidadgestion);
              $rows= $sel_unid->num_rows;
            ?>

            </div>
            <div class="divTableCell" style="padding: 0;">
            <div class="divTable">
              <div class="divTableBody">
                <div class="divTableRow">
                  <div class="divTableCell"><b>PRODUCTOS</b></div>
                  <?php while ($sel_unid ->fetch()): ?>
                    <div class="divTableCell number"><b><?php echo $unidadgestion ?></b></div>
                  <?php endwhile; ?>
                  <div class="divTableCell"><b>TOTAL</b></div>
                </div>
              <?php obtenerdosfila(null,$rows,$sel_unid,0,1,$fecha);
              obtenerdosfila(null, $rows,$sel_unid,0,2,$fecha);
              $sel_prod = $con->prepare("SELECT DISTINCT producto FROM produccion WHERE producto<>unidadgestion");
              $sel_prod -> execute();
              $sel_prod-> store_result();
              $sel_prod -> bind_result($prod);
              while ($sel_prod ->fetch()):
                obtenerdosfila($prod,$rows,$sel_unid,1,1,$fecha);
                obtenerdosfila($prod,$rows,$sel_unid,1,2,$fecha);
              endwhile;
              $sel_prod->close();
             ?>
             <div class="divTableRow">
               <div class="divTableCell"><b>TOTAL</b></div>
               <?php $sel_unitot = $con->prepare("SELECT sum(rubro) FROM produccion h INNER JOIN tipo_unidades_gestion ug ON h.producto = ug.id WHERE unidadgestion = ? and h.fecha = ? group by producto,primaria");
                 $sel_unitot -> execute();
                 $sel_unitot-> store_result();
                 $sel_unitot -> bind_result($totalunidad);
                 while ($sel_unitot ->fetch()):
                   $total+=$totalunidad;
                 ?>
               <div class="divTableCell number"><b><?php echo number_format($totalunidad, 2, ',', ' ') ?></b></div>
               <?php endwhile;
               obtenerdosfila($prod,$rows,$sel_unid,null,null,$fecha);
               ?>

               <!-- <div class="divTableCell number"><b><?php //echo number_format($total, 2, ',', ' ') ?></b></div> -->
             </div>
             <div class="divTableRow">
               <div class="divTableCell"><b>%</b></div>
                 <?php
                 obtenerdosfila($prod,$rows,$sel_unid,100,100,$fecha);
                 ?>

                </div>
              <?php endwhile;?>

           </div>
          </div>

          </div>


      </div>

</div>
</div>
