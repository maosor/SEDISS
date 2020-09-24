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
</style>
<?php if (!isset($_GET['c']) && (!isset($_GET['f'])||$_GET['f']=="undefined")) {
  echo "<div> <h3>No hay datos para mostrar...</h3></div>";
}
else {
  echo "Establecimiento: ".compania($_SESSION ['compania'])."<br>";
  echo "Cuadro N° 4: COSTOS DE OPERACION <br>";
  echo "Mes de: ".$_GET['f']."<br>"; ?>

  <div class="row"> <!-- Costos directos-->
        <div id="insumos" class="col s12">
      <?php
      $val_org = $_GET['c'];
      $fecha = $_GET['f'];
      $titfila = true;
      $i=0;
      $p=1;
      $index = 0;
      $total=0;
      $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by tu.id");
        $sel_unid -> bind_param('i', $val_org);
        $sel_unid -> execute();
        $sel_unid-> store_result();
        $sel_unid -> bind_result($idug, $unidadgestion);
        $rows= $sel_unid->num_rows;
         ?>
        <?php $sel_insum = $con->prepare("SELECT ro.descripcion, sum(rubro) FROM gastos g INNER JOIN red_organizacional ro ON g.insumo = ro.id and ro.tipo = 4 and g.fecha = ?	GROUP BY insumo,g.unidadgestion");
         $sel_insum -> bind_param('s', $fecha);
          $sel_insum -> execute();
          $sel_insum-> store_result();
          $sel_insum -> bind_result($idin, $insumo);
            ?>
        <div class="divTable">
          <div class="divTableBody">
              <div class="divTableRow">
                <div class="divTableCell"><b>INSUMOS</b></div>
                <?php while ($sel_unid ->fetch()): ?>
                  <div class="divTableCell number"><b><?php echo $unidadgestion ?></b></div>

                <?php endwhile; ?>
                <div class="divTableCell"><b>TOTAL</b></div>
              </div>
              <?php while ($sel_insum ->fetch()):
                if ($i ==$rows && $p==0):
                  $p=1;
                  $i=0;
                  $total=0;
                endif;
                echo $p==1?"<div class='divTableRow'><div class='divTableCell'>".$idin."</div>":'';
                ?>
                <div class="divTableCell number"><?php echo number_format($insumo, 2, ',', ' ')?></div>
              <?php
              $total +=$insumo;
              echo $i==$rows-1?"<div class='divTableCell number'>".number_format($total, 2, ',', ' ')."</div></div>":'';
              $p=0;
              $i++;
             endwhile; ?>
             <div class="divTableRow">
               <div class="divTableCell"><b>TOTAL</b></div>
               <?php $sel_unitot = $con->prepare("SELECT sum(rubro) FROM gastos g INNER JOIN red_organizacional ro ON g.insumo = ro.id and ro.tipo = 4  and g.fecha = ?	group by g.unidadgestion");
                 $sel_unitot -> bind_param('s', $fecha);
                 $sel_unitot -> execute();
                 $sel_unitot-> store_result();
                 $sel_unitot -> bind_result($totalunidad);
                 while ($sel_unitot ->fetch()):
                   $total+=$totalunidad;
                 ?>
               <div class="divTableCell number"><b><?php echo number_format($totalunidad, 2, ',', ' ') ?></b></div>
               <?php endwhile; ?>
               <div class="divTableCell number"><b><?php echo number_format($total, 2, ',', ' ') ?></b></div>
             </div>
             <div class="divTableRow">
               <div class="divTableCell"><b>%</b></div>

                 <?php $sel_unitot->data_seek(0);
                 while ($sel_unitot ->fetch()):
                 ?>
               <div class="divTableCell number"><b><?php echo $totalunidad >0?number_format($totalunidad/$total*100, 2, ',', ' '):0 ?></b></div>
                <?php endwhile; ?>
                <div class="divTableCell number"><b><?php echo $totalunidad >0?number_format($total/$total*100, 2, ',', ' '):0 ?></b></div>

               </div>

             </div>
          </div>
        </div>
  </div>
  <div class="row">
    <br>
  </div>
  <div class="row"> <!-- Costos indirectos-->
      <div id="insumos" class="col s12">
        <?php
        $titfila = true;
        $i=0;
        $p=1;
        $index = 0;
        $total=0;
        $sel_unidApoy = $con->prepare("SELECT u.descripcion, g.unidadgestion FROM gastos g INNER JOIN tipo_unidades_gestion u on g.unidadgestion = u.id where organizacion = ? and u.Funcion = 1 AND g.fecha = ? GROUP BY g.unidadgestion");
        $sel_unidApoy -> bind_param('is', $val_org, $fecha);
        $sel_unidApoy -> execute();
        $sel_unidApoy-> store_result();
        $sel_unidApoy -> bind_result($unidadgestionap, $idap);
        ?>
        <div class="divTable">
        <div class="divTableBody">
        <div class="divTableRow">
        <div class="divTableCell"><b>INSUMOS</b></div>
        <?php
        $h = 1;
        while ($sel_unidApoy ->fetch()):
        $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by tu.id");
        $sel_unid -> bind_param('i', $val_org);
        $sel_unid -> execute();
        $sel_unid-> store_result();
        $sel_unid -> bind_result($idug, $unidadgestion);
        $rows= $sel_unid->num_rows;
         ?>
        <?php $sel_insum = $con->prepare("SELECT u.Descripcion, ((select sum(RUBRO) from gastos g where unidadgestion = ?
            group by unidadgestion)/100)*((select sum(RUBRO) from produccion p inner join tipo_unidades_gestion u on p.unidadgestion = u.id
            where producto <> unidadgestion and primaria = 1 and p.producto = ? and p.fecha = ?)/sum(rubro)) from produccion p inner join tipo_unidades_gestion u on p.unidadgestion = u.id
            where producto <> unidadgestion and primaria = 1 and p.producto = ? and p.fecha = ? group by p.unidadgestion
            union select p.producto,0 from produccion p inner join gastos g on p.unidadgestion = g.unidadgestion where p.unidadgestion <> p.producto and p.fecha = ? and  g.fecha = ? group by p.producto; ");
          $sel_insum -> bind_param('iisisss', $idap,$idap,$fecha,$idap,$fecha,$fecha,$fecha);
          $sel_insum -> execute();
          $sel_insum-> store_result();
          $sel_insum -> bind_result($idin, $insumo);

          while ($sel_unid ->fetch()):
            if ($h<=$rows): ?>
                <div class="divTableCell number"><b><?php echo $unidadgestion?></b></div>
                <?php
            endif;
            $h++;
             endwhile;
             if ($h<=$rows+1):?>
              <div class="divTableCell"><b>TOTAL</b></div>
              <?php
              endif;
                 ?>
              </div>
              <?php while ($sel_insum ->fetch()):
                if ($i ==$rows && $p==0):
                  $p=1;
                  $i=0;
                  $total=0;
                endif;
                echo $p==1?"<div class='divTableRow'><div class='divTableCell'>".$unidadgestionap."</div>":'';
                ?>
                <div class="divTableCell number"><?php echo number_format($insumo, 2, ',', ' ')?></div>
              <?php
              $total +=$insumo;
              echo $i==$rows-1?"<div class='divTableCell number'>".number_format($total, 2, ',', ' ')."</div></div>":'';
              $p=0;
              $i++;
             endwhile;
             endwhile; ?>

             <div class="divTableRow">
               <div class="divTableCell"><b>TOTAL</b></div>
               <?php $sel_unitot = $con->prepare("SELECT sum(rubro) FROM gastos g INNER JOIN red_organizacional ro ON g.insumo = ro.id and ro.tipo = 4 and g.fecha = ?	group by g.unidadgestion");
                 $sel_unitot -> execute();
                 $sel_unitot-> store_result();
                 $sel_unitot -> bind_result($totalunidad);
                 while ($sel_unitot ->fetch()):
                   $total+=$totalunidad;
                 ?>
               <div class="divTableCell number"><b><?php echo number_format($totalunidad, 2, ',', ' ') ?></b></div>
               <?php endwhile; ?>
               <div class="divTableCell number"><b><?php echo number_format($total, 2, ',', ' ') ?></b></div>
             </div>
             <div class="divTableRow">
               <div class="divTableCell"><b>%</b></div>

                 <?php $sel_unitot->data_seek(0);
                 while ($sel_unitot ->fetch()):
                 ?>
               <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format($totalunidad/$total*100, 2, ',', ' '):0 ?></b></div>
                <?php endwhile; ?>
                <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format($total/$total*100, 2, ',', ' '):0 ?></b></div>

               </div>

             </div>
          </div>
        </div>
  </div>
  </div>
<?php } ?>
