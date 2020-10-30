<?php
include '../conexion/conexion.php';
if($_POST){
  $organizacion=$_POST['organizacion'];
  $fecha=$_POST['fecha'];
  $compania = $_SESSION['compania'];
}
 ?>
 <br><br><br>
 <div class="row">
   <div class="col s4">
     <b>Unidad de gestión</b>
   </div>
   <div class="col s5">
     <b>Producto</b>
   </div>
   <div class="col s3">
     <b>Monto</b>
   </div>
 </div>
 <?php
 $sel_unid_final = $con->prepare("SELECT p.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec,tu.TieneCamas, sum(if(p.primaria=1, p.rubro,0)), sum(if(p.primaria=2, p.rubro,0)),sum(if(p.primaria=3, p.rubro,0)) FROM produccion p
 INNER JOIN tipo_unidades_gestion tu ON tu.id = p.unidadgestion and tu.id = p.producto WHERE p.idcompania = ? AND organizacion = ? and tu.funcion = 0 AND fecha = ? group by p.unidadgestion order by CONCAT((SELECT orden FROM tipo_unidades_gestion WHERE id_compania = ? and id = tu.idpa),tu.orden)*1,orden");
 $sel_unid_final -> bind_param('iisi',$compania, $organizacion, $fecha,$compania);
 $sel_unid_final -> execute();
 $sel_unid_final-> store_result();
 $sel_unid_final -> bind_result($idugf, $unidadgestionf,$unidprodprimf,$unidprodsecf,$tienecamasf,$rubro1,$rubro2,$rubro3);
 while ($sel_unid_final ->fetch()):
   ?>
   <div class="row">
     <div id="PF-<?php echo $idugf?>" class="col s12 dvunidadFinal blue lighten-5">
       <div class="col s4">
         <span><b><?php echo $unidadgestionf ?></b></span>
       </div>
       <div class="row">
         <div id="P-<?php echo $idugf.'-'.$idugf?>" class="col s12 dvunidad white">
               <div class="col s4">
                 <span>PRODUCCION PRIMARIA</span>
               </div>
               <div class="input-field col s8">
                 <div class="col s12 dvcel dvunidprodprim">
                   <div class="row ">
                     <div class="col s8">
                       <span>  <?php echo $unidprodprimf ?></span>
                     </div>
                     <div class="col s4 ">
                         <input class="inprod" id="p-<?php echo $idugf?>" type="text"  title="rubro" value="<?php echo $rubro1?>" >
                     </div>
                   </div>
                 </div>
               </div>
               <div class="input-field col s4">
               </div>
               <div class="input-field col s8">
                 <div class="col s12 dvcel unidprodsec">
                   <div class="row ">
                     <div class="col s8">
                       <span>  <?php echo $unidprodsecf ?></span>
                     </div>
                     <div class="col s4 ">
                         <input class="inprod" id="p-<?php echo $idugf?>" type="text"  title="rubro" value="<?php echo $rubro2?>" >
                     </div>
                   </div>
                 </div>
               </div>
               <?php if ($tienecamasf): ?>
                 <div class="input-field col s4">
                 </div>
                 <div class="input-field col s8">
                   <div class="col s12 dvcel unidprodcam">
                     <div class="row ">
                       <div class="col s8">
                         <span> Cantidad de Camas</span>
                       </div>
                       <div class="col s4 ">
                           <input class="inprod" id="p-<?php echo $idugf?>" type="text"  title="rubro" value="<?php echo $rubro3?>" >
                       </div>
                     </div>
                   </div>
                 </div>
               <?php endif; ?>
           </div>
         </div>
   <?php
   // $sel_unid = $con->prepare("SELECT p.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec, sum(if(p.primaria=1, p.rubro,0)), sum(if(p.primaria=2, p.rubro,0)) FROM produccion p INNER JOIN tipo_unidades_gestion tu
   //      ON tu.id = p.producto WHERE  p.idcompania = 1 AND organizacion = ? and tu.funcion = 1 AND  p.unidadgestion = ? and fecha = ?
   //      group by tu.id order by p.producto;");
   $sel_unid = $con->prepare("SELECT p.producto,tu.Descripcion, tu.unidprodprim, tu.unidprodsec,tu.TieneCamas, sum(if(p.primaria=1, p.rubro,0)), sum(if(p.primaria=2, p.rubro,0)),sum(if(p.primaria=3, p.rubro,0)) FROM produccion p INNER JOIN tipo_unidades_gestion tu
         ON tu.id = p.producto WHERE  p.idcompania = ? AND organizacion = ? and tu.funcion = 1 AND  p.unidadgestion = ? and fecha = ?
         group by tu.id order by p.producto;");

   $sel_unid -> bind_param('iiis',$compania, $organizacion, $idugf, $fecha);
   $sel_unid -> execute();
   $sel_unid-> store_result();
   $sel_unid -> bind_result($idug, $unidadgestion,$unidprodprim,$unidprodsec,$tienecamas,$rubro1,$rubro2,$rubro3);
   while ($sel_unid ->fetch()): ?>
   <div class="row">
     <div id="P-<?php echo $idugf.'-'.$idug?>" class="col s12 dvunidad white">
           <div class="col s4">
             <span><?php echo $unidadgestion ?></span>
           </div>
           <div class="input-field col s8">
             <div class="col s12 dvcel dvunidprodprim">
               <div class="row ">
                 <div class="col s8">
                   <span>  <?php echo $unidprodprim ?></span>
                 </div>
                 <div class="col s4 ">
                     <input class="inprod" id="p-<?php echo $idug?>" type="text"  title="rubro" value="<?php echo $rubro1?>">
                 </div>
               </div>
             </div>
           </div>
           <div class="input-field col s4">
           </div>
           <div class="input-field col s8">
             <div class="col s12 dvcel unidprodsec">
               <div class="row ">
                 <div class="col s8">
                   <span>  <?php echo $unidprodsec?></span>
                 </div>
                 <div class="col s4 ">
                     <input class="inprod" id="p-<?php echo $idug?>" type="text"  title="rubro" value="<?php echo $rubro2?>" >
                 </div>
               </div>
             </div>
           </div>
           <?php if ($tienecamas): ?>
             <div class="input-field col s4">
             </div>
             <div class="input-field col s8">
               <div class="col s12 dvcel unidprodsec">
                 <div class="row ">
                   <div class="col s8">
                     <span>Cantida de Camas</span>
                   </div>
                   <div class="col s4 ">
                       <input class="inprod" id="p-<?php echo $idug?>" type="text"  title="rubro" value="<?php echo $rubro3?>" >
                   </div>
                 </div>
               </div>
             </div>
           <?php endif; ?>
       </div>
     </div>
     <?php endwhile;
     $sel_unid ->close();
     ?>
     </div><?php
   endwhile;
   $sel_unid_final ->close();
   ?>

</div>
