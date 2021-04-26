<?php include '../extend/funciones.php';
if(isset($_GET['org'])){
   $orgactual=$_GET['org'];
   $compania= $_GET['com'];
}
?>
 <label for="periodo">Periodo</label>
 <input id ="periodo" type="text" class = "datepickermonth" name="periodo" value="<?php echo ultimoPeriodo($compania, $orgactual) ?>">
<script type="text/javascript">
/*$('.datepicker').pickadate({
  format:'yyyy-mm-dd',
  selectMonths: true, // Creates a dropdown to control month
  selectYears: 15, // Creates a dropdown of 15 years to control year,
  class_day_disabled: 'datepicker--day__disabled',
  today: 'Hoy',
  clear: 'Limpiar',
  close: 'Ok',
  closeOnSelect: false,
});*/
  $('.datepickermonth').pickadate({
    selectMonths: true,
    format: 'mmm-yyyy',
    selectYears: true,
    buttonImageOnly: false,
    disable: [true],
    today: false,
    clear: false,
    close: false,
    onOpen: function() {
      $(".picker__nav--prev, .picker__nav--next").remove();
      $('.picker__table').remove();
      $('.picker__weekday-display').remove();
      $('.picker__day-display').remove();
    },
    onSet: function( arg ){
      if(arg.highlight!== undefined){
        var selectedMonth = parseInt(arg.highlight[1]);
        var selectedYear = arg.highlight[0];
        var selectedDate = arg.highlight[2];
        this.set('select', [selectedYear, selectedMonth, selectedDate,{ format: 'yyyy/mm/dd' }]);
      }


      this.close();

    }
  });
</script>
</script>
