<?php include '../extend/header.php';
include '../extend/funciones.php';
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    $sel = $con->prepare("SELECT cm.fecha, comentario, cl.nombre, cl.id_cliente FROM comentario cm INNER JOIN cliente cl ON(cm.id_cliente = cl.id_cliente) WHERE id =? ");
    $sel->bind_param('i', $id);
    $sel->execute();
    $sel->bind_result($fecha, $comentario, $nombre, $id_cliente );
    $sel->fetch();
    $accion = 'Actualizar';
    $sel ->close();
    $deshabilitar = '';
  }
  else {
    $fecha = date("Y/m/d"); $comentario = '';
    $accion = 'Insertar';
    $id_cliente = $_GET['cli'];
    $deshabilitar = 'disabled';
  }
?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Comentario <?php $nombre?></span>
        <?php if ($accion == 'Actualizar'): ?>
          <form  action="up_comentario.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id ?>">
          <?php else: ?>
        <form  action="ins_comentario.php" method="post" autocomplete="off">
         <?php endif; ?>
         <div class="input-field col s12">
           <input type="text" name="fecha" class = "datepicker" id="fecha" onblur="may(this.value, this.id)" value="<?php echo $fecha?>"  >
           <label for="fecha">Fecha</label>
         </div>
         <input type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">
         <div class="input-field col s12">
          <textarea id="comentario" name="comentario" class="materialize-textarea"> <?php echo $comentario?></textarea>
            <label for="comentario">comentario</label>
            </div>
            <center>
            <?php if ($accion == 'Actualizar'): ?>
            <button type="submit" class="btn">Guardar</button>
            <?php else: ?>
              <button type="submit" class="btn">Guardar nuevo</button>
            <?php endif; ?>
            <button type="reset" class="btn red darken-4"  onclick="window.location='index.php?id=<?php echo $id_cliente?>'" name="button">Cancelar</button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../extend/scripts.php'; ?>
</body>
</html>
