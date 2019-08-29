<?php include '../extend/header.php';
include '../extend/funciones.php';
$a=htmlentities($_GET['a']);
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    if ($a=='t') {
      $sel = $con->prepare("SELECT id, descripcion FROM tipo_ejecutivo WHERE id = ?");
    }
    else {
      $sel = $con->prepare("SELECT id, descripcion FROM perfil_ejecutivo WHERE id = ?");
    }
    $sel->bind_param('i', $id);
    $sel->execute();
    $sel->bind_result( $id, $descripcion);
    $sel->fetch();
    $accion = 'Actualizar';
    $sel ->close();
    $deshabilitar = 'disabled';
  }
  else {
    $id = ''; $descripcion = '';
    $accion = 'Insertar';
    $deshabilitar = '';
  }
?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <?php if ($a=='t'): ?>
            <span class="card-title">Tipos Ejecutivo</span>
        <?php else: ?>
            <span class="card-title">Perfiles Ejecutivo</span>
        <?php endif; ?>
        <?php if ($accion == 'Actualizar'): ?>
          <form  action="up_tipoyperfil.php?a=<?php echo $a?>" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id ?>">
        <?php else: ?>
        <form  action="ins_tipoyperfil.php?a=<?php echo $a?>" method="post" autocomplete="off">
         <?php endif; ?>
          <div class="input-field">
            <input type="text" name="descripcion"  title="Solo letras" pattern="[A-Z/s ]+"  id="descripcion" onblur="may(this.value, this.id)" value="<?php echo $descripcion?>"  >
            <label for="descripcion">Descripción</label>
          </div>
          <center>
            <?php if ($accion == 'Actualizar'): ?>
            <button type="submit" class="btn">Guardar</button>
            <?php else: ?>
              <button type="submit" class="btn">Guardar nuevo</button>
            <?php endif; ?>
            <button type="reset" class="btn red darken-4"  onclick="window.location='index.php?a=<?php echo $a?>'" name="button">Cancelar</button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../extend/scripts.php'; ?>

</body>
</html>
