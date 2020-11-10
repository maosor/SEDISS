<?php include '../extend/funciones.php';
if(isset($_GET['org'])){
   $orgactual=$_GET['org'];
   $compania= $_GET['com'];
}
?>
 <label for="periodo">Periodo</label>
 <input id ="periodo" type="text" class = "datepicker" name="periodo" value="<?php echo ultimoPeriodo($compania, $orgactual) ?>">
<script type="text/javascript">
$('.datepicker').pickadate({
  format:'yyyy-mm-dd',
  selectMonths: true, // Creates a dropdown to control month
  selectYears: 15, // Creates a dropdown of 15 years to control year,
  class_day_disabled: 'datepicker--day__disabled',
  today: 'Hoy',
  clear: 'Limpiar',
  close: 'Ok',
  closeOnSelect: false,
      });
</script>
</script>
