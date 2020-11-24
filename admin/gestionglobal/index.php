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
           <a id ='new' class="btn-floating btn-large blue darken-4 left" style= "margin-left: 5px;"><i
             class="material-icons">insert_drive_file</i></a>
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
                          $orgactual = null;
             ?>
             <input id = "OrgActual"type ="hidden" value="<?php echo $orgactual; ?>">
             <input id = "comp"type ="hidden" value="<?php echo $compania; ?>">
             <label for="organizacion">Organización</label>
                <select id="organizacion"class="form-control">
                    <?php if($sel_org->affected_rows==0){
                        echo "<option value='' disabled class'gray'>   Vacio   </option>";
                    }else {

                      while ($sel_org ->fetch()): ?>
                      <?php if ($orgactual == null):
                        $orgactual= $idor;
                      endif; ?>

                        <option value="<?php echo $idor?>"><?php echo $organizacion?> <?php !isset($val_org)?$val_org=$idor:$val_org?></option>
                    <?php
                      endwhile;
                    }
                    $sel_org ->close();
                    ?>
                </select>

           </div>
           <div id = "dvperiodo"class="col s2">
              <label for="periodo">Periodo</label>
              <input id ="periodo" type="text" class = "datepicker" name="periodo" value="<?php echo ultimoPeriodo($compania, $orgactual) ?>">
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
                    <b>Monto</b>
                  </div>
                </div>
                <?php
                if(isset($_GET['id'])){
                  $val_org = $_GET['id'];
                }
                $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE tu.id_compania = ? AND organizacion = ? order by funcion, CONCAT((SELECT orden FROM tipo_unidades_gestion WHERE id_compania = ? and id = tu.idpa),tu.orden)*1,orden");
                $sel_unid -> bind_param('iii',$compania, $val_org,$compania);
                $sel_unid -> execute();
                $sel_unid-> store_result();
                $sel_unid -> bind_result($idug, $unidadgestion);
                //echo "SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = ? order by tu.id".$val_org;
                  while ($sel_unid ->fetch()): ?>
                  <div class="row">
                    <div id="g-<?php echo $idug?>" class="col s12 dvunidad blue lighten-5">
                          <div class="col s4">
                            <span><b><?php echo $unidadgestion ?></b></span>
                          </div>
                          <div class="input-field col s8">
                            <?php
                            $sel_insu = $con->prepare("SELECT id, Descripcion FROM red_organizacional r WHERE id_compania = ? AND tipo = 4 AND id not in (SELECT DISTINCT idpa FROM red_organizacional WHERE id_compania = ? AND tipo = 4) order by
                            CONCAT(0,(SELECT orden FROM red_organizacional WHERE id_compania = ? AND tipo = 4 and id = r.idpa),orden)*1,r.orden");
                            //$sel_insu -> bind_param('i', $compania);
                            $sel_insu -> bind_param('iii', $compania, $compania, $compania);
                            $sel_insu -> execute();
                            $sel_insu-> store_result();
                            $sel_insu -> bind_result($idin, $insumo);
                              while ($sel_insu ->fetch()): ?>
                                <div class="col s12 dvinsumo white">
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
                        <div class="col s4">
                          <span><br></span>
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
                  <b>Monto</b>
                </div>
              </div>
              <?php
              if(isset($_GET['id'])){
                $val_org = $_GET['id'];
              }
              $sel_unid_final = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec,tu.TieneCamas FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE tu.id_compania =? AND organizacion = ? and tu.funcion = 0 order by CONCAT((SELECT orden FROM tipo_unidades_gestion WHERE id_compania = ? and id = tu.idpa),tu.orden)*1,orden");
              $sel_unid_final -> bind_param('iii',$compania, $val_org,$compania);
              $sel_unid_final -> execute();
              $sel_unid_final-> store_result();
              $sel_unid_final -> bind_result($idugf, $unidadgestionf,$unidprodprimf,$unidprodsecf,$tienecamasf);
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
                            <?php if ($tienecamasf): ?>
                              <div class="input-field col s4">
                              </div>
                              <div class="input-field col s8">
                                <div class="col s12 dvcel unidprodcam">
                                  <div class="row ">
                                    <div class="col s8">
                                      <span>Cantidad Camas</span>
                                    </div>
                                    <div class="col s4 ">
                                        <input class="inprod" id="p-<?php echo $idugf?>" type="text"  title="rubro" >
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php endif; ?>
                        </div>
                      </div>
                <?php
                $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion, tu.unidprodprim, tu.unidprodsec,tu.TieneCamas FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE tu.id_compania =? AND organizacion = ? and tu.funcion = 1 order by tu.id");
                $sel_unid -> bind_param('ii',$compania, $val_org);
                $sel_unid -> execute();
                $sel_unid-> store_result();
                $sel_unid -> bind_result($idug, $unidadgestion,$unidprodprim,$unidprodsec,$tienecamas);
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
                        <?php if ($tienecamas): ?>
                          <div class="input-field col s4">
                          </div>
                          <div class="input-field col s8">
                            <div class="col s12 dvcel unidprodsec">
                              <div class="row ">
                                <div class="col s8">
                                  <span>Cantidad de Camas</span>
                                </div>
                                <div class="col s4 ">
                                    <input class="inprod" id="p-<?php echo $idug?>" type="text"  title="rubro" >
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
                  </div>
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
              if(isset($_GET['id'])){
                $val_org = $_GET['id'];
              }
              $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE id_compania =? AND organizacion = ? order by CONCAT((SELECT orden FROM tipo_unidades_gestion WHERE id_compania = ? and id = tu.idpa),tu.orden)*1,orden");
              $sel_unid -> bind_param('iii', $compania,$val_org,$compania);
              $sel_unid -> execute();
              $sel_unid-> store_result();
              $sel_unid -> bind_result($idug, $unidadgestion);
              while ($sel_unid ->fetch()): ?>
              <div class="row">
                <div id="h-<?php echo $idug?>" class="col s12 dvunidad blue lighten-5">
                      <div class="col s4">
                        <span><b><?php echo $unidadgestion ?></b></span>
                      </div>
                      <div class="input-field col s8">
                        <?php
                        $sel_pers = $con->prepare("SELECT id, Descripcion FROM red_organizacional WHERE id_compania =? AND tipo = 3 and idpa <> 0 order by orden,id");
                        $sel_pers -> bind_param('i', $compania);
                        $sel_pers -> execute();
                        $sel_pers-> store_result();
                        $sel_pers -> bind_result($idin, $personal);
                          while ($sel_pers ->fetch()): ?>
                            <div class="col s12 dvhora white">
                              <div class="row ">
                                <div class="col s8">
                                  <span>  <?php echo $personal ?></span>
                                </div>
                                <div class="col s4 ">
                                    <input class="inphora" id="h-<?php echo $idin?>" type="text"  title="hora" >
                                </div>
                              </div>
                            </div>
                        <?php endwhile;
                      $sel_pers ->close();?>
                    </div>
                    <div class="col s4">
                      <span><br></span>
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
