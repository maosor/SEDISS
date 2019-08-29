<?php include '../extend/header.php';
if (isset($_GET['ope'] )) {
  $operacion = $con->real_escape_string(htmlentities($_GET['ope']));
  $sel = $con->prepare("SELECT propiedad, consecutivo,nombre_cliente,calle_num,fraccionamiento,estado,municipio,precio,
    forma_pago,asesor,tipo_inmueble,operacion,mapa, marcado FROM inventario WHERE estatus = 'ACTIVO' AND operacion = ? ");
  $sel->bind_param("s", $operacion);
}else {
  $sel = $con->prepare("SELECT propiedad, consecutivo,nombre_cliente,calle_num,fraccionamiento,estado,municipio,precio,
    forma_pago,asesor,tipo_inmueble,operacion,mapa, marcado FROM inventario WHERE estatus = 'ACTIVO' ");
}
?>

<br>
<div class="row">
  <div class="col s12">
    <nav class="brown lighten-3" >
      <div class="nav-wrapper">
        <div class="input-field">
          <input type="search"   id="buscar" autocomplete="off"  >
          <label for="buscar"><i class="material-icons" >search</i></label>
          <i class="material-icons" >close</i>
        </div>
      </div>
    </nav>
  </div>
</div>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <form action="excel.php" method="post" target="_blank" id="exportar">
            <span class="card-title">Propiedades<button class="btn-floating green botonExcel" type="button"
               name="button"><i class="material-icons">grid_on</i></button>
               <a href="mapa_completo.php" class="btn btn-floating red" target="-_blank">
                 <i class="material-icons">map</i></a>
             </span>
            <input type="hidden" name="datos" id ="datos">

        </form>
        <table class="excel" border="1">
          <thead>
            <tr class="cabecera">
              <th class="borrar">Vista</th>
              <th></th>
              <th>Num</th>
              <th>Cliente</th>
              <th>Propiedad</th>
              <th>Precio</th>
              <th>Credito</th>
              <th>Asesor</th>
              <th>Tipo</th>
              <th class="borrar">Operacion</th>
              <th colspan="5">Opciones</th>
            </tr>
          </thead>
          <?php
          $sel->execute();
          $sel->bind_result($propiedad, $consecutivo,$nombre_cliente,$calle_num,$fraccionamiento,$estado,$municipio,$precio,
            $forma_pago,$asesor,$tipo_inmueble,$operacion,$mapa, $marcado);
          while ($sel->fetch()) {?>
            <tr>
              <td class="borrar"><button data-target="modal1" onclick="enviar(this.value)"
                value="<?php echo $propiedad ?>" class="btn modal-trigger btn-floating"><i class="material-icons">
              visibility</i><?php echo $marcado ?></button></td>
              <td>
                <?php if ($marcado == ''): ?>
                  <a href="marcado.php?id=<?php echo $propiedad ?>&marcado=SI"><i class="small grey-text material-icons">grade</i></a>
                <?php else: ?>
                  <a href="marcado.php?id=<?php echo $propiedad ?>&marcado="><i class="small green-text material-icons">grade</i></a>
                <?php endif; ?>
              </td>
              <td><?php echo $consecutivo  ?></td>
              <td><?php echo $nombre_cliente  ?></td>
              <td><?php echo $calle_num .' '.$fraccionamiento .' '.$estado .' ,'.$municipio  ?></td>
              <td><?php echo "¢".number_format($precio ,2); ?></td>
              <td><?php echo $forma_pago  ?></td>
              <td><?php echo $asesor  ?></td>
              <td><?php echo $tipo_inmueble  ?></td>
              <td><?php echo $operacion  ?></td>
              <td class="borrar"><a href="imagenes.php?id=<?php echo $propiedad ?>" class="btn-floating pink"><i
                class="material-icons">image</i></a></td>
              <td class="borrar"><a href="mapa.php?mapa=<?php echo $mapa ?>" target="_blank" class="btn-floating orange"><i
                class="material-icons">room</i></a></td>
              <td class="borrar"><a href="pdf.php?id=<?php echo $propiedad ?>" target="_blank" class="btn-floating green"><i
                class="material-icons">picture_as_pdf</i></a></td>
              <td class="borrar"><a href="editar_propiedad.php?id=<?php echo $propiedad ?>" target="_blank" class="btn-floating blue"><i
                class="material-icons">loop</i></a></td>
              <td class="borrar"><a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea cancelar la propiedad?',
                type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Cancelarlo!'
              }).then((result) => { if (result.value){location.href='cancelar_propiedad.php?id=<?php echo $propiedad ?>&accion=CANCELADO';}})"><i class="material-icons">delete</i></a></td>

            </tr>
          <?php }
          $sel->close();
          $con->close();
           ?>
        </table>
      </div>
    </div>
  </div>
</div>

<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Informacion</h4>
    <div class="res_modal">

    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">CERRAR</a>
  </div>
</div>
<?php include '../extend/scripts.php'; ?>
<script>
  $('.modal').modal();
  function enviar(valor) {
      $.get('modal.php', {
        id:valor,
        beforeSend: function () {
          $('.res_modal').html('Espere un momento por favor');
         }
       }, function (respuesta) {
            $('.res_modal').html(respuesta);
      });
    }

</script>
<script>
  $('.botonExcel').click(function () {
  $('.borrar').remove();
  $('#datos').val( $("<div>").append($('.excel').eq(0).clone()).html());
  $('#exportar').submit();
  setInterval(function(){location.reload();},3000);
});

</script>

</body>
</html>
