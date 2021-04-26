<?php include '../extend/funciones.php';
if(isset($_GET['org'])){
   $orgactual=$_GET['org'];
   $compania= $_GET['com'];
}
?>
<label for="periodo">Periodo</label>
<select id="periodo"class="form-control">
    <?php echo $compania.$orgactual; periodos($compania,$orgactual);
    ?>
</select>
<script type="text/javascript">
  $('select').material_select();
</script>
