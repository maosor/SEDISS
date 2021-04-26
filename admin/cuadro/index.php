<?php include '../extend/header.php';
include '../extend/funciones.php';
$cuadro= $_GET['n'];
$compania= $_SESSION['compania'];
?>
<div class="col s12">
  <div class="card">
    <div class="card-content">
      <div class="row">
        <h3>Cuadro # <?php echo $cuadro ?></h3>
        <div class="col s6">
          <input id= "cuadro" type="hidden" name="" value="<?php echo $cuadro ?>">
          <input id = "comp" type ="hidden" value="<?php echo $compania; ?>">
          <?php
          $sel_org = $con->prepare("SELECT DISTINCT o.id, o.descripcion FROM organizacion o INNER JOIN unidadgestion_organizacion uo ON o.id = uo.organizacion WHERE o.idcompania = ? ");
          $sel_org->bind_param('i', $compania);
          $sel_org -> execute();
          $sel_org-> store_result();
          $sel_org -> bind_result($idor, $organizacion);
          ?>
          <label for="organizacion">Organización</label>
             <select id="organizacion"class="form-control">
                 <?php while ($sel_org ->fetch()): ?>
                   <option value="<?php echo $idor?>"><?php echo $organizacion?> <?php !isset($val_org)?$val_org=$idor:$val_org?></option>
                 <?php endwhile;
                 $sel_org ->close();
                 ?>
             </select>
        </div>
        <div id= 'periodoscuadros'class="col s2">
           <label for="periodo">Periodo</label>
           <select id="periodo"class="form-control">
               <?php echo $compania.$val_org; periodos($compania,$val_org);
               ?>
           </select>
         </div>
         <div class="col s1">
              <a id ='preliminar' class="btn-floating btn-large blue left" style= "margin-left: 5px;"><i
                class="material-icons">search</i></a>
         </div>
      </div>
    </div>
  </div>
</div>
<?php include '../extend/scripts.php'; ?>
<script type="text/javascript">
  $('#preliminar').click(function () {
    if ($('#cuadro').val() == '1'){
        window.location.href = 'uno.php?c='+$('#organizacion').val()+'&f='+ $('#periodo').val();
    }else if ($('#cuadro').val() == '2'){
        window.location.href = 'dos.php?c='+$('#organizacion').val()+'&f='+ $('#periodo').val();
    }else if($('#cuadro').val() == '3a'){
          window.location.href = 'tresa.php?c='+$('#organizacion').val()+'&f='+ $('#periodo').val();
    }else if($('#cuadro').val() == '3b'){
          window.location.href = 'tresb.php?c='+$('#organizacion').val()+'&f='+ $('#periodo').val();
    }else if($('#cuadro').val() == '4'){
          window.location.href = 'cuatro.php?c='+$('#organizacion').val()+'&f='+ $('#periodo').val();
    }else if($('#cuadro').val() == 'e'){
          window.location.href = 'evaluacion.php?c='+$('#organizacion').val()+'&f='+ $('#periodo').val();
    }
  })

    $('#organizacion').change (function () {
      $("#periodoscuadros").load("recargarperiodocuadros.php?org="+$('#organizacion').val()+"&com="+$('#comp').val());

    })
</script>
