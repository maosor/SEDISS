<?php include '../extend/header.php';
include '../extend/funciones.php';
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    $sel_eje = $con->prepare("SELECT id, nombre, telefono FROM sucursal WHERE id = ?");
    $sel_eje->bind_param('i', $id);
    $sel_eje->execute();
    $sel_eje->bind_result( $id, $nombre, $telefono);
    $sel_eje->fetch();
    $accion = 'Actualizar';
    $sel_eje ->close();
    $deshabilitar = 'disabled';
  }
  else {
    $id = ''; $nombre = ''; $telefono = '';
    $accion = 'Insertar';
    $deshabilitar = '';

  }
?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Sucursales</span>
        <?php if ($accion == 'Actualizar'): ?>
          <form  action="up_sucursal.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id ?>">
        <?php else: ?>
        <form  action="ins_sucursal.php" method="post" autocomplete="off">
         <?php endif; ?>
          <div class="input-field">
            <input type="text" name="nombre"  title="Solo letras" pattern="[A-Z/s ]+"  id="nombre" onblur="may(this.value, this.id)" value="<?php echo $nombre?>"  >
            <label for="nombre">Nombre</label>
          </div>
          <div class="input-field">
            <input type="text" name="telefono"  title="Solo letras" id="telefono" onblur="may(this.value, this.id)" value="<?php echo $telefono?>"  >
            <label for="telefono">Teléfono</label>
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
