<?php include '../extend/header.php';
include '../extend/funciones.php';
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    $sel_eje = $con->prepare("SELECT nombre, telefono1, telefono2, telefono3, email, estatus, id_ejecutivo_agrego, presupuesto_maximo,
 id_ejecutivo_asignado, fecha_ingreso, fecha_envio FROM cliente WHERE id_cliente = ? ");
    $sel_eje->bind_param('i', $id);
    $sel_eje->execute();
    $sel_eje->bind_result( $nombre, $telefono1, $telefono2, $telefono3, $email, $estatus, $id_ejecutivo_agrego, $presupuesto_maximo,
 $id_ejecutivo_asignado, $fecha_ingreso, $fecha_envio );
    $sel_eje->fetch();
    $accion = 'Actualizar';
    $sel_eje ->close();
    $deshabilitar = 'disabled';
  }
  else {
    $nombre= '';  $telefono1= '';  $telefono2= '';  $telefono3= '';  $email= '';  $estatus= '';  $id_ejecutivo_agrego= '';  $presupuesto_maximo= '';
    $id_ejecutivo_asignado= '';  $fecha_ingreso= '';  $fecha_envio;
    $accion = 'Insertar';
    $deshabilitar = '';
  }
?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Clientes</span>
        <?php if ($accion == 'Actualizar'): ?>
          <form  action="up_cliente.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id ?>">
        <?php else: ?>
        <form  action="ins_cliente.php" method="post" autocomplete="off">
         <?php endif; ?>
         <div class="input-field col m9 s6">
           <input type="text" name="nombre" title="Solo letras" pattern="[A-Z/s ]+"  id="nombre" onblur="may(this.value, this.id)" value="<?php echo $nombre?>"  >
           <label for="nombre">Nombre</label>
         </div>
         <div class="col m3 s6">
            <select id="id_ejecutivo_asignado" name="id_ejecutivo_asignado" title="Debe asignar un ejecutivo" required value = "1">
              <?php if ($accion == 'Actualizar'): ?>
                  <option value="<?php echo $id_ejecutivo_asignado ?>" selected><?php echo ejecutivo($id_ejecutivo_asignado) ?></option>
                <?php else: ?>
                  <option value="0" selected disabled>ASIGNAR UN EJECUTIVO</option>
               <?php endif; ?>
               <?php
               $sel_eje = $con->prepare("SELECT id, nombre FROM ejecutivo ");
               $sel_eje->execute();
               $sel_eje->bind_result( $id, $ejecutivo);
                ?>
                <?php while ($sel_eje->fetch()): ?>
                  <option value="<?php echo $id?>"><?php echo $ejecutivo?></option>
                <?php endwhile;
                $sel_eje ->close();?>
            </select>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="telefono1"  id="telefono1" onblur="may(this.value, this.id)" value="<?php echo $telefono1?>"  >
            <label for="telefono1">Telefono1</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="telefono2"  id="telefono2" onblur="may(this.value, this.id)" value="<?php echo $telefono2?>"  >
            <label for="telefono2">Telefono2</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="telefono3"  id="telefono3" onblur="may(this.value, this.id)" value="<?php echo $telefono3?>"  >
            <label for="telefono3">Telefono3</label>
          </div>
          <!-- <div class="validacion"> </div> -->
          <div class="input-field col m4 s6">
            <input type="email" name="email" id="email" onblur="may(this.value, this.id)" value="<?php echo $email?>"  >
            <label for="email">Email</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="number" name="presupuesto_maximo" id="presupuesto_maximo" title="Solo números" pattern="[0-9/s ]+"value="<?php echo $presupuesto_maximo?>"  >
            <label for="presupuesto_maximo">Presupuesto Máximo</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="estatus" id="estatus" value="<?php echo $estatus?>" disabled >
            <label for="estatus">Estatus</label>
          </div>
          <center>
            <?php if ($accion == 'Actualizar'): ?>
            <button type="submit" class="btn">Guardar</button>
            <?php else: ?>
              <button type="submit" class="btn">Guardar nuevo</button>
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
