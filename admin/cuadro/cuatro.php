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
      $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by funcion, Concat(0,(select orden from tipo_unidades_gestion where id = tu.idpa), tu.orden)*1");
        $sel_unid -> bind_param('i', $val_org);
        $sel_unid -> execute();
        $sel_unid-> store_result();
        $sel_unid -> bind_result($idug, $unidadgestion);
        $rows= $sel_unid->num_rows;
         ?>
        <?php $sel_insum = $con->prepare("SELECT ro.descripcion, sum(rubro) FROM gastos g INNER JOIN red_organizacional ro ON g.insumo = ro.id and ro.tipo = 4 and g.fecha = ?	INNER JOIN tipo_unidades_gestion tu ON g.unidadgestion = tu.id
        where EXISTS(select 1=1 from gastos where insumo = g.insumo and rubro > 0 and fecha = ? )
	GROUP BY insumo,g.unidadgestion order by g.insumo, funcion, concat(0,(select orden from tipo_unidades_gestion t where id = tu.idpa), tu.orden)*1");
         $sel_insum -> bind_param('ss', $fecha,$fecha);
          $sel_insum -> execute();
          $sel_insum-> store_result();
          $sel_insum -> bind_result($idin, $insumo);
            ?>
        <div class="divTable">
          <div class="divTableBody">
              <div class="divTableRow">
                <div class="divTableCell" style="width: 150px;"><b>COSTOS<br>DIRECTOS</b></div>

                <?php $c=0;
                 while ($sel_unid ->fetch()): ?>
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
             endwhile;
             $total=0;?>
             <div class="divTableRow">
               <div class="divTableCell"><b>TOTAL COSTOS DIRECTOS</b></div>
               <?php $sel_unitot = $con->prepare("SELECT sum(rubro) FROM gastos g INNER JOIN red_organizacional ro ON g.insumo = ro.id and ro.tipo = 4  and g.fecha = ?
               INNER JOIN tipo_unidades_gestion tu ON g.unidadgestion = tu.id
	              GROUP BY g.unidadgestion order by ro.id, tu.funcion, concat(0,(select orden from tipo_unidades_gestion t where id = tu.idpa), tu.orden)*1 ");
                 $sel_unitot -> bind_param('s', $fecha);
                 $sel_unitot -> execute();
                 $sel_unitot-> store_result();
                 $sel_unitot -> bind_result($totalunidad);
                 while ($sel_unitot ->fetch()):
                   $arrfinal[$c][]= $totalunidad;
                   $total+=$totalunidad;
                 ?>
               <div class="divTableCell number"><b><?php echo number_format($totalunidad, 2, ',', ' ') ?></b></div>
               <?php endwhile;
               $c++;
               ?>

               <div class="divTableCell number"><b><?php echo number_format($total, 2, ',', ' ') ?></b></div>
             </div>
             <div class="divTableRow">
               <div class="divTableCell"><b>PORCENTAJES</b></div>

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
        $sel_unidApoy = $con->prepare("SELECT u.descripcion, g.unidadgestion FROM gastos g INNER JOIN tipo_unidades_gestion u on g.unidadgestion = u.id where organizacion = ? and u.Funcion = 1 AND g.fecha = ? GROUP BY g.unidadgestion ");
        $sel_unidApoy -> bind_param('is', $val_org, $fecha);
        $sel_unidApoy -> execute();
        $sel_unidApoy-> store_result();
        $sel_unidApoy -> bind_result($unidadgestionap, $idap);
        ?>
        <div class="divTable">
        <div class="divTableBody">
        <div class="divTableRow">
        <div class="divTableCell" style="width: 150px;"><b>COSTOS<br>INDIRECTOS</b></div>
        <?php
        $h = 1;
        $c=0;
        while ($sel_unidApoy ->fetch()):
        $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by funcion, Concat(0,(select orden from tipo_unidades_gestion where id = tu.idpa), tu.orden)*1");
        $sel_unid -> bind_param('i', $val_org);
        $sel_unid -> execute();
        $sel_unid-> store_result();
        $sel_unid -> bind_result($idug, $unidadgestion);
        $rows= $sel_unid->num_rows;
         ?>
        <?php $sel_insum = $con->prepare("SELECT Concat(funcion, 0,(select orden from tipo_unidades_gestion where id = u.idpa), u.orden)*1, u.Descripcion, ((select sum(RUBRO) from gastos g where unidadgestion = ? and g.fecha = ?
            group by unidadgestion))*(sum(rubro)/(select sum(RUBRO) from produccion p inner join tipo_unidades_gestion u on p.unidadgestion = u.id
            where producto <> unidadgestion and primaria = 1 and p.producto = ? and p.fecha = ?)) from produccion p inner join tipo_unidades_gestion u on p.unidadgestion = u.id
            where producto <> unidadgestion and primaria = 1 and p.producto = ? and p.fecha = ? group by p.unidadgestion
            union select Concat(1, 0,(select orden from tipo_unidades_gestion where id = u.idpa), u.orden)*1, p.producto,0 from produccion p inner join gastos g on p.unidadgestion = g.unidadgestion
              inner join tipo_unidades_gestion u on g.unidadgestion = u.id where p.unidadgestion <> p.producto and p.fecha = ? and  g.fecha = ? group by p.producto order by 1; ");
          $sel_insum -> bind_param('isisisss', $idap,$fecha,$idap,$fecha,$idap,$fecha,$fecha,$fecha);
          $sel_insum -> execute();
          $sel_insum-> store_result();
          $sel_insum -> bind_result($orden, $idin, $insumo);

          while ($sel_unid ->fetch()):
            if ($h<=$rows): ?>
                <div class="divTableCell "><b class="invisible"><?php echo $unidadgestion?></b></div>

                <?php
            endif;
            $h++;
             endwhile;
             if ($h<=$rows+1):?>
              <div class="divTableCell "><b class="invisible">TOTAL</b></div>
              <?php
              endif;
                 ?>
              </div>

              <?php
               while ($sel_insum ->fetch()):
                if ($i ==$rows && $p==0):
                  $p=1;
                  $i=0;
                  $total=0;
                endif;
                echo $p==1?"<div class='divTableRow'><div class='divTableCell'>".$unidadgestionap."</div>":'';
                ?>
                <div class="divTableCell number"><?php echo number_format($insumo, 2, ',', ' ')?></div>
              <?php
              $arrapoyo[$c][]= $insumo;
              $total +=$insumo;
              echo $i==$rows-1?"<div class='divTableCell number'>".number_format($total, 2, ',', ' ')."</div>":'';
              $p=0;
              $i++;
             endwhile;
             $c++;
             endwhile;
             echo "</div>";
             ?>

             <div class="divTableRow">
               <div class="divTableCell"><b>TOTAL COSTOS INDIRECTOS</b></div>
               <?php
                $total = 0;
                for ($c=0; $c<count($arrapoyo[0]);$c++)
                {
                   $total+=array_sum(array_column($arrapoyo, $c));
                 ?>
               <div class="divTableCell number"><b><?php echo number_format(array_sum(array_column($arrapoyo, $c)), 2, ',', ' ') ?></b></div>
               <?php } ?>
               <div class="divTableCell number"><b><?php echo number_format($total, 2, ',', ' ') ?></b></div>
             </div>
             <div class="divTableRow">
               <div class="divTableCell"><b>PORCENTAJES</b></div>

                 <?php $sel_unitot->data_seek(0);
                 for ($c=0; $c<count($arrapoyo[0]);$c++)
                 {
                 ?>
               <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format(array_sum(array_column($arrapoyo, $c))/$total*100, 2, ',', ' '):0 ?></b></div>
                <?php }; ?>
                <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format($total/$total*100, 2, ',', ' '):0 ?></b></div>

               </div>

             </div>
             <div class="divTableRow">
               <div class="divTableCell"><b>TOTAL COSTOS</b></div>
             <?php
             for ($c=0; $c<count($arrapoyo[0]);$c++)
              {
              ?>
            <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format(array_sum(array_column($arrapoyo, $c))+array_sum(array_column($arrfinal, $c)), 2, ',', ' '):0 ?></b></div>
             <?php }; ?>
             <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format(array_sum(array_map("array_sum", $arrapoyo))+array_sum(array_map("array_sum", $arrfinal))*100,2, ',', ' '):0 ?></b></div>
             </div>
             <div class="divTableRow">
               <div class="divTableCell"><b>PORCENTAJES TOTALES</b></div>
             <?php
             for ($c=0; $c<count($arrapoyo[0]);$c++)
              {
              ?>
            <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format((array_sum(array_column($arrapoyo, $c))+array_sum(array_column($arrfinal, $c)))/(array_sum(array_map("array_sum", $arrapoyo))+array_sum(array_map("array_sum", $arrfinal)))*100
            , 2, ',', ' '):0 ?></b></div>
             <?php }; ?>
             <div class="divTableCell number"><b><?php echo $totalunidad >0? number_format((array_sum(array_map("array_sum", $arrapoyo))+array_sum(array_map("array_sum", $arrfinal)))/(array_sum(array_map("array_sum", $arrapoyo))+array_sum(array_map("array_sum", $arrfinal)))*100
             , 2, ',', ' '):0 ?></b></div>
          </div>
          <?php //print_r(array_sum(array_map("array_sum", $arrapoyo)).'<br>');

          //print_r($arrfinal);?>
        </div>
  </div>
  </div>
<?php } ?>
