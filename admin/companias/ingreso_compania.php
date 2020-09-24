<?php include '../extend/header.php';
include '../extend/funciones.php';
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    $sel_com = $con->prepare("SELECT id, descripcion, pais FROM compania WHERE id =?");
    $sel_com ->bind_param('i', $id);
    $sel_com->execute();
    $sel_com->bind_result($id, $descripcion, $pais);
    $sel_com->fetch();
    $accion = 'Actualizar';
    $sel_com ->close();
    $deshabilitar = 'disabled';
  }
  else {
    $id = ''; $descripcion = ''; $pais = '';
    $accion = 'Insertar';
    $deshabilitar = '';

  }
?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Compañía</span>
        <?php if ($accion == 'Actualizar'): ?>
          <form  action="up_compania.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id ?>">
        <?php else: ?>
        <form  action="ins_compania.php" method="post" autocomplete="off">
         <?php endif; ?>
          <div class="input-field col s6">
            <input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion?>"  >
            <label for="descripcion">descripción</label>
          </div>
          <div class="input-field col s6">
            <input type="text" name="pais" id="pais" value="<?php echo $pais?>"  >
            <label for="pais">País</label>
          </div>
          <center>
            <?php if ($accion == 'Actualizar'): ?>
            <button type="submit" class="btn">Guardar</button>
            <?php else: ?>
              <button type="submit" class="btn">Guardar nueva</button>
            <?php endif; ?>
            <button type="reset" class="btn red darken-4"  onclick="window.location='index.php'" name="button">Cancelar</button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../extend/scripts.php'; ?>

</body>
</html>
