</main>
  <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>

      <script type = "text/javascript" src="../js/sweetalert2.all.js"></script>
      <script src="../js/materialize.min.js"></script>
      <script>
      $('#buscar').keyup(function(event){
        var contenido = new RegExp($(this).val(), 'i'); //i reporesenta sencible a MAYUSCULAS y MINUSCULAS
        $('tr').hide();
        $('tr').filter(function(){
          return contenido.test($(this).text());
        }).show();
        $('.cabecera').attr('Style','');
      });
      $('.button-collapse').sideNav();
      $('select').material_select();
      function may(obj, id) {
        obj = obj.toUpperCase();
        document.getElementById(id).value = obj;
      }
      $('.datepicker').pickadate({
        format:'yyyy-mm-dd',
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Ok',
        closeOnSelect: false,
            });
      /*  $('.datepickermonth').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 150, // Creates a dropdown of 15 years to control year
          format: 'mmm-yyyy',
          clear: 'Limpiar',
          max: true,
          isRTL:true,
          onSet: function (arg) {
          if ('select' in arg) { //prevent closing on selecting month/year
            this.close();
          }
        }
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
      <script type="text/javascript">
    //  $('#compania').material_select();
      $('#compania').on('change', function(e) {
        $.post("../extend/set.php", {"name": "compania","value":e.target.value},function(result){
          console.log(result);
          location.reload();
        });

      });

      </script>
