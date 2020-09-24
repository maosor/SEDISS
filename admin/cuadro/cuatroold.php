<?php include '../extend/header.php';
include '../extend/funciones.php';
?>
<div class="row">
    <div id="insumos" class="col s12">
    <br><br><br>
    <div class="row">
      <div class="col s4">
        <b>Unidad de gestión</b>
      </div>
      <div class="col s5">
        <b>Insumo</b>
      </div>
      <div class="col s3">
        <b>Rubro</b>
      </div>
    </div>
    <?php
    $val_org = 1;
    $titfila = true;
    $i=0;
    $p=1;
    $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by tu.id");
      $sel_unid -> bind_param('i', $val_org);
      $sel_unid -> execute();
      $sel_unid-> store_result();
      $sel_unid -> bind_result($idug, $unidadgestion);
      while ($sel_unid ->fetch()): ?>
      <?php $sel_insum = $con->prepare("SELECT ro.descripcion, sum(rubro) FROM gastos g INNER JOIN red_organizacional ro ON g.insumo = ro.id and ro.tipo = 4	WHERE unidadgestion = ? group by insumo");
  $sel_insum -> bind_param('i', $idug);
  $sel_insum -> execute();
  $sel_insum-> store_result();
  $sel_insum -> bind_result($idin, $insumo);
  ?>
    <?php echo $titfila?'<div id ="pag'.$p.'" class="dvpags row hidden">':''?>
      <div class="col <?php echo $titfila?'s5':'s2'?>">
        <div class="" style="font-size: 12px;max-width: 15px;white-space: nowrap;width:80%; text-overflow: ellipsis;">
        <b> <?php  echo $unidadgestion; ?> </b>
        </div>
      <?php
        while ($sel_insum ->fetch()):
          if ($titfila): ?>
            <div class="col s8">
             <span><?php echo $idin ?></span>
           </div>
           <div class="col s2">
            <span><?php echo $insumo ?></span>
          </div>
         <?php
         else:?>
         <div class="col s12">
          <span><?php echo $insumo ?></span>
        </div>
        <?php
       endif;
       ?>
          <?php endwhile;
          $i++;
          if ($i==4){
            $titfila = True;
             $p++;
          }else {
            $titfila = false;
          }
          $sel_insum ->close();?>
        </div>
        <?php
        echo $titfila?'</div>':'';
      endwhile;
      $sel_unid ->close();?>
    </div>
    <ul class="pagination">
      <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
      <li class="active"><a class="pags" href="#pag1">1</a></li>
      <li class="pags waves-effect"><a class="pags" href="#pag2">2</a></li>
      <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
     </ul>
<?php include '../extend/scripts.php'; ?>
     <script type="text/javascript">
     $(document).ready(function() {
        console.log( "document loaded" );
        $('#pag1').removeClass('hidden');
      });
     $('.pags').click (function(){
       $('.dvpags').addClass('hidden');// dvpags
      $($(this).attr('href')).removeClass('hidden');
     });
     </script>
