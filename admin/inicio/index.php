  <?php include '../extend/header.php';
  //phpinfo();
//  print_r($_SESSION);
//$sel = $con->prepare("SELECT propiedad FROM inventario WHERE operacion = ?");
//$sel -> bind_param('s', $operacion);
  ?>
     <!-- <div class="row">
       <div class="col s12 m6 l6">
         <div class="card blue-grey darken-1">
           <div class="card-content">
             <span class="card-title white-text"><b>venta</b></span>
             <h2 align="center" class="white-text">
                <?php
                // $operacion = 'VENTA';
                // $sel -> execute();
                // $sel -> store_result();
                // $sel -> bind_result($propiedad);
                // //7echo $sel->num_rows;
                 ?>
             </h2>
           </div>
            <div class="card-action">
              <a href="../propiedades/index.php?ope=VENTA">ver mas..</a>
            </div>
         </div>
       </div>
       <div class="col s12 m6 l6">
         <div class="card blue-grey darken-1">
           <div class="card-content">
             <span class="card-title white-text"><b>renta</b></span>
             <h2 align="center" class="white-text">
                <?php
              //   $operacion = 'RENTA';
              //   $sel -> execute();
              //   $sel -> store_result();
              //   $sel -> bind_result($propiedad);
              // //  echo $sel->num_rows;
                 ?>
             </h2>
           </div>
            <div class="card-action">
              <a href="../propiedades/index.php?ope=RENTA">ver mas..</a>
            </div>
         </div>
       </div>
       <div class="col s12 m6 l6">
         <div class="card blue-grey darken-1">
           <div class="card-content">
             <span class="card-title white-text"><b>traspaso</b></span>
             <h2 align="center" class="white-text">
                <?php
                // $operacion = 'TRASPASO';
                // $sel -> execute();
                // $sel -> store_result();
                // $sel -> bind_result($propiedad);
                // //echo $sel->num_rows;
                 ?>
             </h2>
           </div>
            <div class="card-action">
              <a href="../propiedades/index.php?ope=TRASPASO">ver mas..</a>
            </div>
         </div>
       </div>
       <div class="col s12 m6 l6">
         <div class="card blue-grey darken-1">
           <div class="card-content">
             <span class="card-title white-text"><b>ocupado</b></span>
             <h2 align="center" class="white-text">
                <?php
                // $operacion = 'OCUPADO';
                // $sel -> execute();
                // $sel -> store_result();
                // $sel -> bind_result($propiedad);
                // //echo $sel->num_rows;
                 ?>
             </h2>
           </div>
            <div class="card-action">
              <a href="../propiedades/index.php?ope=OCUPADO">ver mas..</a>
            </div>
         </div>
       </div>
       <div class="row">
         <div class="col s12">
           <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <h4 align="center"><b>comentarios</b> </h4>
            </div>
            <div class="card-tabs">
              <ul class="tabs tabs-fixed-width tabs-transparent">
                <li class="tab"><a class="active" href="#nuevos">Nuevos</a></li>
                <li class="tab"><a href="#resueltos">Resueltos</a></li>
              </ul>
            </div>
            <div class="card-content white">
              <!-- <div id="nuevos">
                <table>
                   <th>Vista</th>
                   <th>Solicitante</th>
                   <th>Telefono</th>
                   <th>Correo</th>
                   <th>Mensaje</th>
                   <?php
                   // $sel_com = $con->prepare("SELECT id_propiedad, nombre, tel, correo, mensaje FROM comentario WHERE estatus = ? ");
                   // $sel_com->bind_param('s', $estatus);
                   // $estatus = 'NUEVO';
                   // $sel_com->execute();
                   // $sel_com->bind_result($id_propiedad,$nombre, $tel, $correo,$mensaje);
                   // while ($sel_com->fetch()) { ?>
                   <tr>
                     <td class="borrar"><button data-target="modal1" onclick="enviar(this.value)"
                       value="<?php //echo $id_propiedad?>" class="btn modal-trigger btn-floating"><i class="material-icons">
                     visibility</i><?php //echo $marcado?></button></td>
                     <td>
                     <td><?php //echo $nombre ?></td>
                     <td><?php //echo $tel ?></td>
                     <td><a href="correo.php?correo=<?php //echo $correo?>&nombre=<?php //echo $nombre?>&id_mensaje=<?php //echo $id ?>">
                       <?php //echo $correo?></a> </td>
                     <td><?php //echo $mensaje?></td>
                   </tr>
                   <?php //} ?>
                 </table>
              </div> -->
              <!-- <div id="resueltos">
                <table>
                   <th>Vista</th>
                   <th>Solicitante</th>
                   <th>Telefono</th>
                   <th>Correo</th>
                   <th>Mensaje</th>
                   <?php
                   // $estatus = 'RESUELTO';
                   // $sel_com->execute();
                   // $sel_com->bind_result($id_propiedad,$nombre, $tel, $correo,$mensaje);
                   // while ($sel_com->fetch()) { ?>
                   <tr>
                     <td class="borrar"><button data-target="modal1" onclick="enviar(this.value)"
                       value="<?php //echo $id_propiedad?>" class="btn modal-trigger btn-floating"><i class="material-icons">
                     visibility</i><?php //echo $marcado?></button></td>
                     <td>
                     <td><?php //echo $nombre ?></td>
                     <td><?php //echo $tel ?></td>
                     <td><?php //echo $correo ?></td>
                     <td><?php //echo $mensaje ?></td>
                   </tr>
                   <?php //} ?>
                 </table>
              </div> -->
            </div>
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
           $.get('../propiedades/modal.php', {
             id:valor,
             beforeSend: function () {
               $('.res_modal').html('Espere un momento por favor');
              }
            }, function (respuesta) {
                 $('.res_modal').html(respuesta);
           });
         }

     </script> -->
  </body>
</html>
