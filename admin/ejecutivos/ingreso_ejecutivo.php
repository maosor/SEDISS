<?php include '../extend/header.php';
include '../extend/funciones.php';
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    $sel_eje = $con->prepare("SELECT id, nombre, apellido1, apellido2, email, password,
       activo, id_perfil, id_tipo, telefono_principal, telefono_secundario, telefono_celular,
       id_sucursal FROM ejecutivo WHERE id = ? AND borrado = 0");
    $sel_eje->bind_param('i', $id);
    $sel_eje->execute();
    $sel_eje->bind_result( $id, $nombre, $apellido1, $apellido2, $email, $password,
       $activo, $id_perfil, $id_tipo, $telefono_principal, $telefono_secundario, $telefono_celular,
       $id_sucursal );
    $sel_eje->fetch();
    $accion = 'Actualizar';
    $sel_eje ->close();
    $deshabilitar = 'disabled';
  }
  else {
    $id = ''; $nombre = ''; $apellido1 = ''; $apellido2 = ''; $email = ''; $password = '';
       $activo = ''; $id_perfil = ''; $id_tipo = ''; $telefono_principal = ''; $telefono_secundario = '';
        $telefono_celular = '';  $id_sucursal = '';
    $accion = 'Insertar';
    $deshabilitar = '';

  }
?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Ejecutivos</span>
        <?php if ($accion == 'Actualizar'): ?>
          <form  action="up_ejecutivo.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id ?>">
        <?php else: ?>
        <form  action="ins_ejecutivo.php" method="post" autocomplete="off">
         <?php endif; ?>
         <div class="col m4 s6">
            <select id="id_perfil" name="id_perfil" required value = "1">
              <?php if ($accion == 'Actualizar'): ?>
                  <option value="<?php echo $id_perfil ?>" selected><?php echo perfil_ejecutivo($id_perfil) ?></option>
                <?php else: ?>
                  <option value="0" selected disabled>SELECCIONE UN PERFIL</option>
               <?php endif; ?>
               <?php
               $sel_per = $con->prepare("SELECT id, descripcion FROM perfil_ejecutivo ");
               $sel_per->execute();
               $sel_per->bind_result( $id, $descripcion_perfil);
                ?>
                <?php while ($sel_per->fetch()): ?>
                  <option value="<?php echo $id?>"><?php echo $descripcion_perfil?></option>
                <?php endwhile;
                $sel_per ->close();?>
            </select>
          </div>
          <div class="col m4 s6">
             <select id="id_tipo" name="id_tipo" required value = "1">
               <?php if ($accion == 'Actualizar'): ?>
                   <option value="<?php echo $id_tipo ?>" selected><?php echo tipo_ejecutivo($id_tipo) ?></option>
                 <?php else: ?>
                   <option value="0" selected disabled>SELECCIONE UN TIPO</option>
                <?php endif;?>
                <?php
                $sel_tip = $con->prepare("SELECT id, descripcion FROM tipo_ejecutivo ");
                $sel_tip->execute();
                $sel_tip->bind_result( $id, $descripcion_tipo);
                ?>
                 <?php while ($sel_tip->fetch()): ?>
                   <option value="<?php echo $id?>"><?php echo $descripcion_tipo?></option>
                 <?php endwhile;
                  $sel_tip ->close();?>
             </select>
           </div>
           <div class="col m4 s6">
              <select id="id_sucursal" name="id_sucursal" required value = "1">
                <?php if ($accion == 'Actualizar'): ?>
                    <option value="<?php echo $id_sucursal ?>" selected><?php echo sucursal($id_sucursal) ?></option>
                  <?php else: ?>
                    <option value="0" selected disabled>SELECCIONE UNA SUCURSAL</option>
                 <?php endif; ?>
                 <?php
                 $sel_suc = $con->prepare("SELECT id, nombre FROM sucursal ");
                 $sel_suc->execute();
                 $sel_suc->bind_result( $id, $nombre_sucursal);
                  ?>
                  <?php while ($sel_suc->fetch()): ?>
                    <option value="<?php echo $id?>"><?php echo $nombre_sucursal?></option>
                  <?php endwhile;
                  $sel_suc ->close(); ?>
              </select>
            </div>
          <div class="input-field col m4 s6">
            <input type="text" name="nombre"  title="Solo letras" pattern="[A-Z/s ]+"  id="nombre" onblur="may(this.value, this.id)" value="<?php echo $nombre?>"  >
            <label for="nombre">Nombre</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="apellido1"  title="Solo letras" pattern="[A-Z/s ]+"  id="apellido1" onblur="may(this.value, this.id)" value="<?php echo $apellido1?>"  >
            <label for="apellido1">Primer Apellido</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="apellido2"  title="Solo letras" pattern="[A-Z/s ]+"  id="apellido2" onblur="may(this.value, this.id)" value="<?php echo $apellido2?>"  >
            <label for="apellido2">Segundo Apellido</label>
          </div>
          <!-- <div class="validacion"> </div> -->
          <div class="input-field col m4 s6">
            <input type="text" name="email" id="email" onblur="may(this.value, this.id)" value="<?php echo $email?>"  >
            <label for="email">Email</label>
          </div>
          <div class = "input-field col m4 s6">
            <input type="password" name="pass1" title="CONTRASEÑA CON NUMEROS, LETRAS MAYUSCULAS, MINUSCULAS"
            id="pass1" required <?php echo $deshabilitar?>>
            <label for="pass1">Contraseña:</label>
          </div>
          <div class = "input-field col m4 s6">
            <input type="password"  title="CONTRASEÑA CON NUMEROS, LETRAS MAYUSCULAS, MINUSCULAS"
            id="pass2" required  <?php echo $deshabilitar?>>
            <label for="pass">Verificar Contraseña:</label>
          </div>

          <div class="input-field col m4">
            <input type="text" name="telefono_principal"   id="telefono_principal" value="<?php echo $telefono_principal ?>"   >
            <label for="telefono_principal">Telefono Principal</label>
          </div>
          <div class="input-field col m4">
            <input type="text" name="telefono_secundario"   id="telefono_secundario" value="<?php echo $telefono_secundario ?>"   >
            <label for="telefono_secundario">Telefono Secundario</label>
          </div>
          <div class="input-field col m4">
            <input type="text" name="telefono_celular"   id="telefono_celular" value="<?php echo $telefono_celular ?>"   >
            <label for="telefono_celular">Telefono Celular</label>
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
