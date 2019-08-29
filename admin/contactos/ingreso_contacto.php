<?php include '../extend/header.php';
include '../extend/funciones.php';
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    $sel_eje = $con->prepare("SELECT nombre, telefono_casa,telefono_oficina,telefono_celular,
                          fax,email,es_corredor,email2  FROM contacto WHERE id_contacto = ? ");
    $sel_eje->bind_param('i', $id);
    $sel_eje->execute();
    $sel_eje->bind_result( $nombre, $telefono_casa,$telefono_oficina,$telefono_celular,
                          $fax,$email,$es_corredor,$email2 );
    $sel_eje->fetch();
    $accion = 'Actualizar';
    $sel_eje ->close();
    $deshabilitar = 'disabled';
  }
  else {
    $nombre =''; $telefono_casa =''; $telefono_oficina =''; $telefono_celular ='';
    $fax =''; $email =''; $es_corredor =''; $email2 ='';
    $accion = 'Insertar';
    $deshabilitar = '';
  }
?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Contactos</span>
        <?php if ($accion == 'Actualizar'): ?>
          <form  action="up_contacto.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id ?>">
        <?php else: ?>
        <form  action="ins_contacto.php" method="post" autocomplete="off">
         <?php endif; ?>
         <div class="input-field col m9 s6">
           <input type="text" name="nombre" title="Solo letras" pattern="[A-Z/s ]+"  id="nombre" onblur="may(this.value, this.id)" value="<?php echo $nombre?>"  >
           <label for="nombre">Nombre</label>
         </div>
         <p><br>
              <input type="checkbox" class="filled-in" name="es_corredor"
              id="es_corredor" <?php echo $es_corredor==1?"checked":""?>/>
              <label for="es_corredor">¿Es corredor? </label>
          </p>
          <div class="input-field col m4 s6">
            <input type="tel" name="telefono_casa" id="telefono_casa" onblur="may(this.value, this.id)" value="<?php echo $telefono_casa?>"  >
            <label for="telefono_casa">Telefono Casa</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="telefono_oficina"  id="telefono_oficina" onblur="may(this.value, this.id)" value="<?php echo $telefono_oficina?>"  >
            <label for="telefono_oficina">Telefono Oficina</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="telefono_celular"  id="telefono_celular" onblur="may(this.value, this.id)" value="<?php echo $telefono_celular?>"  >
            <label for="telefono_celular">Telefono Celular</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="text" name="fax"  id="fax" onblur="may(this.value, this.id)" value="<?php echo $fax?>"  >
            <label for="fax">Fax</label>
          </div>
          <!-- <div class="validacion"> </div> -->
          <div class="input-field col m4 s6">
            <input type="email" name="email" id="email" onblur="may(this.value, this.id)" value="<?php echo $email?>"  >
            <label for="email">Email Principal</label>
          </div>
          <div class="input-field col m4 s6">
            <input type="email" name="email2" id="email2" onblur="may(this.value, this.id)" value="<?php echo $email2?>"  >
            <label for="email2">Email Secundario</label>
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
