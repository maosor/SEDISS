
  <nav class="darken-blue">
    <a href="#" data-activates="menu" class="button-collapse"><i class="material-icons">menu</i></a>
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
    <!-- <li><a href="../ejecutivos"><i class="material-icons">contact_phone</i>Ejecutivos</li></a>
    <li><div class="divider"></div></li> -->
    <li><a href="../redorganizacional"><i class="material-icons">location_city</i>Red Organizacional</li></a>
    <li><div class="divider"></div></li>
    <li><a href="#"><i class="material-icons">dehaze</i>Parametros</li></a>
    <li><div class="divider"></div></li>
    <!--<li><a href=".#"><i class="material-icons">contacts</i>Unidades de Gestion</li></a>
    <li><div class="divider"></div></li>
    <li><a href="../clientes"><i class="material-icons">people</i>Clientes</li></a>
    <li><div class="divider"></div></li> -->
    <li><a href="../contactos"><i class="material-icons">perm_contact_calendar</i>Contactos</li></a>
    <li><div class="divider"></div></li>

    <!-- <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i class="material-icons">work</i>PROPIEDADES
      <i class="material-icons right">arrow_drop_down</i></a></li>
    <li><div class="divider"></div></li> -->
    <li><a href="../login/salir.php"><i class="material-icons">power_setting_new</i>SALIR</li></a>
    <li><div class="divider"></div></li>
  </ul>

  <ul id="dropdown1" class="dropdown-content">
    <li><a href="../propiedades/index.php">GENERAL</a></li>
    <li><a href="../propiedades/index.php?ope=VENTA">VENTA</a></li>
    <li><a href="../propiedades/index.php?ope=RENTA">RENTA</a></li>
    <li><a href="../propiedades/index.php?ope=TRASPASO">TRASPASO</a></li>
    <li><a href="../propiedades/index.php?ope=OCUPADO">OCUPADO</a></li>
    <li><a href="../propiedades/cancelados.php">CANCELADOS</a></li>
   </ul>
