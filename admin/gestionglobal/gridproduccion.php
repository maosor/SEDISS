<?php
include '../conexion/conexion.php';
if($_POST){
  $organizacion=$_POST['organizacion'];
  $fecha=$_POST['fecha'];
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
     <b>Rubro</b>
   </div>
 </div>
 <?php
 $sel_unid_final = $con->prepare("SELECT p.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec, sum(if(p.primaria=1, p.rubro,0)), sum(if(p.primaria=2, p.rubro,0)) FROM produccion p INNER JOIN tipo_unidades_gestion tu ON tu.id = p.unidadgestion and tu.id = p.producto WHERE p.idcompania = 1 AND organizacion = ? and tu.funcion = 0 AND fecha = ? group by p.unidadgestion order by tu.id");
 $sel_unid_final -> bind_param('is', $organizacion, $fecha);
 $sel_unid_final -> execute();
 $sel_unid_final-> store_result();
 $sel_unid_final -> bind_result($idugf, $unidadgestionf,$unidprodprimf,$unidprodsecf,$rubro1,$rubro2);
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
           </div>
         </div>
   <?php
   // $sel_unid = $con->prepare("SELECT p.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec, sum(if(p.primaria=1, p.rubro,0)), sum(if(p.primaria=2, p.rubro,0)) FROM produccion p INNER JOIN tipo_unidades_gestion tu
   //      ON tu.id = p.producto WHERE  p.idcompania = 1 AND organizacion = ? and tu.funcion = 1 AND  p.unidadgestion = ? and fecha = ?
   //      group by tu.id order by p.producto;");
   $sel_unid = $con->prepare("SELECT p.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec, sum(if(p.primaria=1, p.rubro,0)), sum(if(p.primaria=2, p.rubro,0)) FROM produccion p INNER JOIN tipo_unidades_gestion tu
         ON tu.id = p.producto WHERE  p.idcompania = 1 AND organizacion = ? and tu.funcion = 1 AND  p.unidadgestion = ? and fecha = ?
         group by tu.id order by p.producto;");

   $sel_unid -> bind_param('iis', $organizacion, $idugf, $fecha);
   $sel_unid -> execute();
   $sel_unid-> store_result();
   $sel_unid -> bind_result($idug, $unidadgestion,$unidprodprim,$unidprodsec,$rubro1,$rubro2);
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
