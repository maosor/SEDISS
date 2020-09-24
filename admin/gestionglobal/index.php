<?php include '../extend/header.php';
include '../extend/funciones.php';
$compania= $_SESSION['compania'];
?>
<script src="../js/jquery-1.11.1.min.js"></script>
 <div class="row">
   <div class="col s12">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Gestión Datos</span>
         <div class="row">
           <a id ='up' class="btn-floating btn-large blue left" style= "margin-left: 5px;"><i
             class="material-icons">save</i></a>
           <a id ='del' class="btn-floating btn-large red left" style= "margin-left: 5px;"><i
             class="material-icons">delete</i></a>
           <br>
             <br>
           </div>
         <div class="row">
           <div class="col s6">
             <?php
             $sel_org = $con->prepare("SELECT DISTINCT o.id, o.descripcion FROM organizacion o INNER JOIN unidadgestion_organizacion uo ON o.id = uo.organizacion where o.idcompania = ? ");
             $sel_org -> bind_param('i',$compania);
             $sel_org -> execute();
             $sel_org-> store_result();
             $sel_org -> bind_result($idor, $organizacion);
             ?>
             <label for="organizacion">Organización</label>
                <select id="organizacion"class="form-control">
                    <?php if($sel_org->affected_rows==0){
                        echo "<option value='' disabled class'gray'>   Vacio   </option>".$sel_org->affected_rows;
                    }else {
                      while ($sel_org ->fetch()): ?>
                        <option value="<?php echo $idor?>"><?php echo $organizacion?> <?php !isset($val_org)?$val_org=$idor:$val_org?></option>
                    <?php
                      endwhile;
                    }
                    $sel_org ->close();
                    ?>
                </select>
                <?php //$val_org=2; ?>
           </div>
           <div class="col s2">
              <label for="periodo">Periodo</label>
              <input id ="periodo" type="text" class = "datepicker" name="periodo" value="<?php echo Date("Y-m-d") ?>">
            </div>
            <div class="col s1">
              <a id ='sync' class="btn-floating btn-large green left" style= "margin-left: 5px;"><i
                class="material-icons">sync</i></a>
            </div>
         </div>
          <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s3"><a class="active" href="#insumos">Insumos</a></li>
                <li class="tab col s3"><a href="#produccion">Producción</a></li>
                <li class="tab col s3"><a href="#horas">Horas</a></li>
              </ul>
            </div>
            <div id="insumos" class="col s12">
                <br><br><br>
                <div class="row">
                  <div class="col s4">
                    <b>Unidad de gestión</b>
                  </div>
                  <div class="col s5">
                    <b>Insumo</b>
                  </div>
                  <div class="col s3">
                    <b>Rubro</b>
                  </div>
                </div>
                <?php
                $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by tu.id");
                $sel_unid -> bind_param('i', $val_org);
                $sel_unid -> execute();
                $sel_unid-> store_result();
                $sel_unid -> bind_result($idug, $unidadgestion);
                //echo "SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by tu.id".$val_org;
                  while ($sel_unid ->fetch()): ?>
                  <div class="row">
                    <div id="g-<?php echo $idug?>" class="col s12 dvunidad">
                          <div class="col s4">
                            <span><?php echo $unidadgestion ?></span>
                          </div>
                          <div class="input-field col s8">
                            <?php
                            $sel_insu = $con->prepare("SELECT id, Descripcion FROM red_organizacional WHERE tipo = 4");
                            $sel_insu -> execute();
                            $sel_insu-> store_result();
                            $sel_insu -> bind_result($idin, $insumo);
                              while ($sel_insu ->fetch()): ?>
                                <div class="col s12 dvinsumo">
                                  <div class="row ">
                                    <div class="col s8">
                                      <span>  <?php echo $insumo ?></span>
                                    </div>
                                    <div class="col s4 ">
                                        <input class="inprubro" id="g-<?php echo $idin?>" type="text"  title="rubro" >
                                    </div>
                                  </div>
                                </div>
                            <?php endwhile;
                          $sel_insu ->close();?>
                        </div>
                      </div>
                    </div>
                    <?php endwhile;
                    $sel_unid ->close();?>
              </div>
            <div id="produccion" class="col s12">
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
              $sel_unid_final = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? and tu.funcion = 0 order by tu.id");
              $sel_unid_final -> bind_param('i', $val_org);
              $sel_unid_final -> execute();
              $sel_unid_final-> store_result();
              $sel_unid_final -> bind_result($idugf, $unidadgestionf,$unidprodprimf,$unidprodsecf);
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
                                      <input class="inprod" id="p-<?php echo $idugf?>" type="text"  title="rubro" >
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
                                      <input class="inprod" id="p-<?php echo $idugf?>" type="text"  title="rubro" >
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                <?php
                $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? and tu.funcion = 1 order by tu.id");
                $sel_unid -> bind_param('i', $val_org);
                $sel_unid -> execute();
                $sel_unid-> store_result();
                $sel_unid -> bind_result($idug, $unidadgestion,$unidprodprim,$unidprodsec);
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
                                  <input class="inprod" id="p-<?php echo $idug?>" type="text"  title="rubro" >
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
                                <span>  <?php echo $unidprodsec ?></span>
                              </div>
                              <div class="col s4 ">
                                  <input class="inprod" id="p-<?php echo $idug?>" type="text"  title="rubro" >
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
            <div id="horas" class="col s12">
              <br><br><br>
              <div class="row">
                <div class="col s4">
                  <b>Unidad de gestión</b>
                </div>
                <div class="col s5">
                  <b>Recurso Humano</b>
                </div>
                <div class="col s3">
                  <b>Horas</b>
                </div>
              </div>
              <?php
              $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by tu.id");
              $sel_unid -> bind_param('i', $val_org);
              $sel_unid -> execute();
              $sel_unid-> store_result();
              $sel_unid -> bind_result($idug, $unidadgestion);
              while ($sel_unid ->fetch()): ?>
              <div class="row">
                <div id="h-<?php echo $idug?>" class="col s12 dvunidad">
                      <div class="col s4">
                        <span><?php echo $unidadgestion ?></span>
                      </div>
                      <div class="input-field col s8">
                        <?php
                        $sel_insu = $con->prepare("SELECT id, Descripcion FROM red_organizacional WHERE tipo = 3 order by orden,id");
                        $sel_insu -> execute();
                        $sel_insu-> store_result();
                        $sel_insu -> bind_result($idin, $insumo);
                          while ($sel_insu ->fetch()): ?>
                            <div class="col s12 dvhora">
                              <div class="row ">
                                <div class="col s8">
                                  <span>  <?php echo $insumo ?></span>
                                </div>
                                <div class="col s4 ">
                                    <input class="inphora" id="h-<?php echo $idin?>" type="text"  title="hora" >
                                </div>
                              </div>
                            </div>
                        <?php endwhile;
                      $sel_insu ->close();?>
                    </div>
                  </div>
                </div>
                <?php endwhile;
                $sel_unid ->close();?>
            </div>
       </div>
     </div>
   </div>
 </div>
<?php include '../extend/scripts.php'; ?>
<script src="../js/gestion_datos.js" charset="utf-8"></script>
