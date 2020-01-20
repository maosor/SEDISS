$('#up').click(function() {
  // $.each([ 52, 97 ], function( index, value ) {
var insumo=[];
var unidades=[];
$('.dvunidad').each(function (iu, univalor) {
  var unidad = {};
  unidad['Id'] = $(univalor).attr('id');
  //unidad['Descripcion'] = $(univalor).attr('Text');
  var uniid = $(univalor).attr('id');
  $('#'+ uniid +' .inprubro').each(function(ii,insvalor) {
      item = {};
      item['Id']=$(insvalor).attr('id');
      item['Rubro'] = $(insvalor).val();
      insumo.push(item);
      // insumo.Insumos.push({
      //   Id: $(value).attr('id'),
      //   Rubro:$(value).val()
      // })
      //console.log( index + ": " + $('#984 div .input-field input').val());
    });
    unidad['insumo'] =insumo;
    insumo=[];
    unidades.push(unidad);

});
unidades = JSON.stringify(unidades);
  $.ajax({
    type: "POST",
    url: "ins_up_gestion_datos.php",
    data: {
      mydata:unidades,
      organizacion:$('#organizacion').val(),
      fecha:$('#periodo').val(),
    },
    success:function (respuesta) {
        //console.log(respuesta);
        $('#insumos').html(respuesta);
    },
    error:function () {
      console.log('No respuesta...');
    }


  });
});

$('#sync').click(function () {
  $.post('gridinsumo.php',{
    organizacion:$('#organizacion').val(),
    fecha:$('#periodo').val(),
    beforeSend: function () {
      $('#insumos').html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $('#insumos').html(respuesta)
  });
});
$('#del').click(function () {
  $.post('del_gestion_datos.php',{
    organizacion:$('#organizacion').val(),
    fecha:$('#periodo').val(),
    beforeSend: function () {
      $('#insumos').html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $('#insumos').html(respuesta)
  });
});
