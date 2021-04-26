<?php
include '../conexion/conexion.php';
//$_SESSION['compania'] = 2;
//print_r($_SESSION);
//phpinfo();
$sel_compania= $con->prepare("SELECT id, descripcion,pais  FROM compania WHERE id = ? ");
$sel_compania -> bind_param('i', $_SESSION['compania']);
$sel_compania -> execute();
$sel_compania -> bind_result($id, $compania,$pais);
$sel_compania->fetch();
 ?>

  <nav class="darken-blue">
    <?php echo'&nbsp;&nbsp;&nbsp;'.$pais ?>
    <a href="#" data-activates="menu" class="button-collapse"><i class="material-icons">menu</i></a>
    <ul class="right hide-on-med-and-down">
      <select  name="compania" id="compania" required>
         <option value="<?php echo $id?>" disabled selected><?php echo $compania ?></option>
         <?php
         $sel_compania->close();
         $sel= $con->prepare("SELECT c.id cid, descripcion FROM usuario_compania uc inner join compania c on uc.id_compania=c.id
         WHERE uc.id_usuario= ? ");
         $sel -> bind_param('i', $_SESSION['id']);
         $sel-> execute();
         $sel-> store_result();
         $sel-> bind_result($cid, $comp);
         ?>
         <?php while ($sel-> fetch()) { ?>
         <option value="<?php echo $cid?>" ><?php echo  $comp?></option>
         <?php } ?>
      </select>
    </ul>
  </nav>
  <ul id="menu" class="side-nav fixed blue lighten-5">
    <li>
      <div class="userView">
        <div class="background fixed">
          <img src="../css/images/abstract-q-c-640-480-9.jpg" style="width: 100%;">
        </div>
        <a href="../perfil/index.php"><img src="../perfil/<?php echo $_SESSION['foto'] ?>" class="circle" alt=""></a>
          <a href="../perfil/perfil.php" class="white-text"><?php echo $_SESSION['nombre'].' '. $_SESSION['apellido1'].' '.$_SESSION['apellido2'] ?></a>
          <a href="../perfil/perfil.php" class="white-text"><?php echo $_SESSION['email'] ?> </a>
      </div>
    </li>
    <li><a href="../inicio"><i class="material-icons">home</i>INICIO</li></a>
    <li><div class="divider"></div></li>
    <li><a href="../companias"><i class="material-icons">domain</i>Países</li></a>
    <li><div class="divider"></div></li>
    <li><a class="dropdown-button" href="#!" data-activates="ddclasificacion"><i class="material-icons">device_hub</i>Organización
      <i class="material-icons right">arrow_drop_down</i></a></li>
    <li><div class="divider"></div></li>
    <!-- <li><a href="#"><i class="material-icons">dehaze</i>Parametros</li></a>
    <li><div class="divider"></div></li> -->
    <li><a href="../gestionglobal"><i class="material-icons">grid_on</i>Gestión de Datos</li></a>
    <li><div class="divider"></div></li>
     <li><a class="dropdown-button" href="#!" data-activates="ddcuadros"><i class="material-icons">view_comfy</i>Cuadros<i class="material-icons right">arrow_drop_down</i></a></li>
    <li><div class="divider"></div></li>
  <!-- <li><a href="../clientes"><i class="material-icons">people</i>Clientes</li></a>
    <li><div class="divider"></div></li> -->
    <!-- <li><a href="../contactos"><i class="material-icons">perm_contact_calendar</i>Contactos</li></a>
    <li><div class="divider"></div></li> -->
    <li><a href="../extend/pregunta.php"><i class="material-icons">power_setting_new</i>SALIR</li></a>
    <li><div class="divider"></div></li>
  </ul>

  <ul id="ddclasificacion" class="dropdown-content">
    <li><a href="../redorganizacional/index.php?o=1">Red</a></li>
    <li><a href="../redorganizacional/index.php?o=2">Nivel Complejidad</a></li>
    <li><a href="../redorganizacional/index.php?o=3">Categoria y tipo Recurso Humano</a></li>
    <li><a href="../redorganizacional/index.php?o=4">Categoria y tipo de Insumo</a></li>
    <li><a href="../redorganizacional/index.php?o=5">Grupo unidad de gestión</a></li>
    <li><a href="../redorganizacional/index.php?o=6">Unidad de gestión</a></li>
    <li><a href="../redorganizacional/index.php">Organización</a></li>
  </ul>
  <ul id="ddcuadros" class="dropdown-content">
    <li><a href="../cuadro/index.php?n=1">Uno</a></li>
    <li><a href="../cuadro/index.php?n=2">Dos</a></li>
    <li><a href="../cuadro/index.php?n=3a">Tres A</a></li>
    <li><a href="../cuadro/index.php?n=3b">Tres B</a></li>
    <li><a href="../cuadro/index.php?n=4">Cuatro</a></li>
    <li><a href="../cuadro/index.php?n=e">Evaluacion</a></li>
 </ul>
