function cargaGrids() {
  $.post("gridinsumo.php",{
    organizacion:$('#organizacion').val(),
    fecha:$('#periodo').val(),
    beforeSend: function () {
      $("#insumos").html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $("#insumos").html(respuesta)
  });
  $.post("gridproduccion.php",{
    organizacion:$('#organizacion').val(),
    fecha:$('#periodo').val(),
    beforeSend: function () {
      $("#produccion").html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $("#produccion").html(respuesta)
  });
  $.post("gridhora.php",{
    organizacion:$('#organizacion').val(),
    fecha:$('#periodo').val(),
    beforeSend: function () {
      $("#horas").html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $("#horas").html(respuesta)
  });
}
$(document).ready(function() {
var esnuevo = localStorage['Nuevo'];
if(esnuevo==null)
{
  localStorage['Nuevo']=false;
  esnuevo = localStorage['Nuevo'];
}
if (esnuevo=="false")
{
  cargaGrids();
}
  localStorage['Nuevo']=false;
});
$('#organizacion').change (function () {
  //$('#periodo').val(document.write('<?php ultimoPeriodo(1,2)?>'));
  $("#dvperiodo").load(location.href + "recargarperiodo.php?org="+$('#organizacion').val()+"&com="+$('#comp').val());
  window.setTimeout( cargaGrids, 1500 );
})
$('#new').click(function () {
  localStorage['Nuevo'] = true;
$("#OrgActual").val($("#organizacion").val()) ;
$('#insumos').load(location.href + "?id="+$("#organizacion").val() +" #insumos");
$('#produccion').load(location.href + "?id="+$("#organizacion").val() + " #produccion");
$('#horas').load(location.href + "?id="+$("#organizacion").val()+ " #horas");
//$( "#periodo" ).datepicker({dateFormat:"yy/mm/dd"}).datepicker("setDate",Date.now());
//$('#periodo').val(new Date().toDateString());
});
$('#up').click(function() {
  // $.each([ 52, 97 ], function( index, value ) {
var unidades=[];
//var ref = $(".tabs .active").attr('href');
var ref= "#insumos";
  var insumo=[];
  $('#insumos div .dvunidad').each(function (iu, univalor) {
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
        accion:ref,
      },
      success:function (respuesta) {
          //console.log(respuesta);
          $(ref).html(respuesta);
      },
      error:function () {
        console.log('No respuesta...');
      }
    });
    unidades=[];
ref= "#produccion";
  var produccion=[];
  $('#produccion div .dvunidad').each(function (iu, univalor) {
    var unidad = {};
    unidad['Id'] = $(univalor).attr('id');
    //unidad['Descripcion'] = $(univalor).attr('Text');
    var uniid = $(univalor).attr('id');
    $('#'+ uniid +' .inprod').each(function(ii,insvalor) {
        item = {};
        item['Id']=$(insvalor).attr('id');
        item['Rubro'] = $(insvalor).val();
        produccion.push(item);
      });
      unidad['produccion'] =produccion;
      produccion=[];
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
        accion:ref,
      },
      success:function (respuesta) {
          //console.log(respuesta);
          $(ref).html(respuesta);
      },
      error:function () {
        console.log('No respuesta...');
      }
    });
    unidades=[];
ref= "#horas";
    var hora=[];
  $('#horas div .dvunidad').each(function (iu, univalor) {
    var unidad = {};
    unidad['Id'] = $(univalor).attr('id');
    //unidad['Descripcion'] = $(univalor).attr('Text');
    var uniid = $(univalor).attr('id');
    $('#'+ uniid +' .inphora').each(function(ii,insvalor) {
        item = {};
        item['Id']=$(insvalor).attr('id');
        item['Rubro'] = $(insvalor).val();
        hora.push(item);
        // insumo.Insumos.push({
        //   Id: $(value).attr('id'),
        //   Rubro:$(value).val()
        // })
        //console.log( index + ": " + $('#984 div .input-field input').val());
      });
      unidad['hora'] =hora;
      hora=[];
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
      accion:ref,
    },
    success:function (respuesta) {
        //console.log(respuesta);
        $(ref).html(respuesta);
    },
    error:function () {
      console.log('No respuesta...');
    }
  });
  cargaGrids();
});

$('#sync').click(function () {
  var ref = $(".tabs .active").attr('href');
  var accion,tab;
  if (ref=== "#insumos"){
    accion = 'gridinsumo.php';
  }else if (ref=== "#produccion"){
    accion = 'gridproduccion.php';
  }else if (ref=== "#horas"){
    accion = 'gridhora.php';
  }
  $.post(accion,{
    organizacion:$('#organizacion').val(),
    fecha:$('#periodo').val(),
    beforeSend: function () {
      $(ref).html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $(ref).html(respuesta)
  });
});
$('#del').click(function () {
//var ref = $(".tabs .active").attr('href');
swal({
title: '¿Esta seguro que desea borrar los datos?',
text: "Después de borrados no se podrán recuperar",
type: 'error',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Si, quiero borrarlos!'
}).then((result) => {
  if (result.value) {
  ref= "#insumos";
  $.post('del_gestion_datos.php',{
    organizacion:$('#organizacion').val(),
    fecha:$('#periodo').val(),
    accion:ref,
    beforeSend: function () {
      $(ref).html('');
     }
   }, function (respuesta) {
        $(ref).html(respuesta)
  });
  ref= "#produccion";
    $.post('del_gestion_datos.php',{
      organizacion:$('#organizacion').val(),
      fecha:$('#periodo').val(),
      accion:ref,
      beforeSend: function () {
        $(ref).html('');
       }
     }, function (respuesta) {
          $(ref).html(respuesta)
    });
ref = ref= "#horas";

    $.post('del_gestion_datos.php',{
      organizacion:$('#organizacion').val(),
      fecha:$('#periodo').val(),
      accion:ref,
      beforeSend: function () {
        $(ref).html('');
       }
     }, function (respuesta) {
          $(ref).html(respuesta)
    });
  }
});

});
