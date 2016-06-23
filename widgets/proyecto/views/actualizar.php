<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use yii\widgets\Pjax;
use yii\web\JsExpression;
/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */
$contoe=0;
$acti1=0;
$acti2=0;
$acti3=0;
?>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<style>.image-upload > input
{
    display: none;
}

.image-upload img
{
    width: 80px;
    cursor: pointer;
}
label{
    display:inline-block !important ;
    max-width:100% !important;
    margin-bottom:5px !important;
    font-size:14px !important;
    font-weight:700 !important;
    color:#1f2a69 !important;
}
.form-control
{
    color:#59595b !important;
    font-size:14px !important;
}

    ul #oespe{
        content: "";
        list-style: none; 
    }
    ul #act{
        content: "";
        list-style: none; 
    }
    /*
    li {
        
    }*/
    #oespe::before
    {
        padding-right: 5px;
        content: "\25BA";
    }
    #act::before
    {
        padding-right: 5px;
        content: "\25CF";
    }
    
    #act
    {
        padding-top:10px;
        padding-bottom:10px;
    }
</style>






<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_project_big.png" alt="">MI PROYECTO (Segunda entrega)
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" style="background: white;">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Datos generales</a></li>
                <li class=""><a href="#tab_9" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Objetivos y actividades</a></li>
                <!--<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Resultado</a></li>-->
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Presupuesto</a></li>
                <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Cronograma</a></li>
                <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"  style="color: #333 !important">Mi video</a></li>
                <?php if($estudiante->grado!=6){?>
                <!--<li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false" style="color: #333 !important" >Reflexión</a></li>-->
                <?php } ?>
                <?php if(($etapa->etapa==2 || $etapa->etapa==3) && $estudiante->grado!=6){ ?>
                <!--<li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Mi evaluación</a></li>-->
                <!--<li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Foro</a></li>-->
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">    
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-titulo required">
                                <label class="control-label" for="proyecto-titulo">Título del proyecto</label>
                                <input type="text" id="proyecto-titulo" class="form-control" name="Proyecto[titulo]" maxlength="200" title="Máximo 200 palabras" value="<?= $proyecto->titulo ?>" <?= $disabled ?>>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-equipo-asunto_id required" >
                                <label class="control-label" for="proyecto-asunto_id">Selecciona el Asunto de Público sobre el que trabajará tu equipo</label>
                                <select id="proyecto-asunto_id" class="form-control" name="Proyecto[asunto_id]">
                                    <option value=""></option>
                                    <?php
                                        $resultados=Resultados::find()->where('region_id=:region_id',['region_id'=>$institucion->department_id])->all();
                                        foreach($resultados as $resultado)
                                        {
                                            if($equipo->asunto_id==$resultado->asunto_id)
                                            {
                                                echo "<option value='$resultado->asunto_id' selected='selected'>".$resultado->asunto->descripcion_cabecera."</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='$resultado->asunto_id'>".$resultado->asunto->descripcion_cabecera."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>    
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-resumen required">
                                <label class="control-label" for="proyecto-resumen" >Sumilla / Justificación</label>
                                <textarea id="proyecto-resumen" class="form-control" name="Proyecto[resumen]" rows="3"  maxlength="2500"  <?= $disabled ?> ><?= $proyecto->resumen ?></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-beneficiario required">
                                <label class="control-label" for="proyecto-beneficiario">Beneficiario</label>
                                <textarea id="proyecto-beneficiario" class="form-control" name="Proyecto[beneficiario]" rows="3" maxlength="2500"  <?= $disabled ?> ><?= $proyecto->beneficiario ?></textarea>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <!--<div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-archivo required" >
                                <input class="form-control" type="file" id="proyecto-archivo"  name="Proyecto[archivo]" onchange="Documento(this)"/>
                                <div class="input-group">
                                    <input type="text" readonly="" class="form-control" >
                                      <span class="input-group-btn input-group-sm">
                                        <button type="button" class="btn btn-fab btn-fab-mini glyphicon glyphicon-paperclip">
                                          <i class="material-icons">archivo</i>
                                        </button>
                                      </span>
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="col-xs-12 col-sm-12 col-md-12" >
                            <?php if(($proyecto->formato_proyecto=='' || $proyecto->formato_proyecto==0) && $integrante->rol==1 && $etapa->etapa==1){ ?>
                            <div class="form-group" style="background: #F0EFF1">
                                <p class="text-justify" style="margin-left: 20px;margin-bottom: 0px;margin-top: 20px;padding-top: 10px">Tambien puedes subir tu proyecto:</p>
                                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                        <input type="file" id="proyecto-archivo"  name="Proyecto[archivo]" />
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php } elseif($proyecto->formato_proyecto==1 && $etapa->etapa==1) { ?>
                            <div class="form-group" style="background: #F0EFF1">
                                <p class="text-justify" style="margin: 20px;padding-top: 10px">Haz subido tu proyecto en el formato simplificado:</p>
                                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                    <a href="<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $proyecto->proyecto_archivo ?>" target="_blank" class=" btn-lateral"><img height=22px src="<?= \Yii::$app->request->BaseUrl ?>/img/pdf.png"> Primera entrega</a>
                                </div>
                                <div class="clearfix"></div>
                            </div><!--César has cambiado el elseif agregandole && $equipo->etapa==1 recuerda 22062016-->
                            <?php } elseif(($proyecto->formato_proyecto2=='' || $proyecto->formato_proyecto2==0) && $integrante->rol==1 && $etapa->etapa==2 && $equipo->etapa==1){ ?>
                            <div class="form-group" style="background: #F0EFF1">
                                <p class="text-justify" style="margin-left: 20px;margin-bottom: 0px;margin-top: 20px;padding-top: 10px">Tambien puedes subir tu proyecto:</p>
                                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                        <input type="file" id="proyecto-archivo2"  name="Proyecto[archivo2]" />
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php } elseif($proyecto->formato_proyecto2==1 && $etapa->etapa==2) { ?>
                            <div class="form-group" style="background: #F0EFF1">
                                <p class="text-justify" style="margin: 20px;padding-top: 10px">Haz subido tu proyecto en el formato simplificado:</p>
                                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                    <a href="<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $proyecto->proyecto_archivo2 ?>" target="_blank" class=" btn-lateral"><img height=22px src="<?= \Yii::$app->request->BaseUrl ?>/img/pdf.png"> Segunda entrega</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_9">
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <?php if($disabled=='disabled') { ?>
                                <h4><b>Objetivos</b>  </h4>
                            <?php } else { ?>
                                <h4><b>Objetivos</b> <span class="glyphicon glyphicon-plus-sign" style="cursor: pointer" title="Haga clic para añadir objetivos"  onclick="agregarObjetivoActividad()" <?= $disabled ?>></span></h4>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div id="mostrar_oe_actividades">
                                <div id="oe_1" class='col-xs-12 col-sm-12 col-md-12'>
                                    <?php if($proyecto->objetivo_especifico_1){ ?>
                                        <ul>
                                            <li id='oespe'><b>Objetivo N° 1: <?= $proyecto->objetivo_especifico_1 ?></b> <?= ($disabled=='disabled')?'':"<span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(1)'></span>" ?>  </li>
                                                <input type='hidden' value='<?= $proyecto->objetivo_especifico_1 ?>' name='Proyecto[objetivo_especifico_1]'>
                                            <ul>
                                                <?php foreach($actividades as $actividad){ ?>
                                                    <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_1_id){?>
                                                        <li id='act'>Actividad: <?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_1][]'></li>
                                                        <input id="proyecto-actividades_ids_1_<?= $acti1 ?>" type="hidden" name="Proyecto[actividades_ids_1][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" />
                                                    <?php $acti1 ++; } ?>
                                                <?php  } ?>
                                            </ul>
                                        </ul>
                                        <?php $contoe=1; ?>
                                    <?php } ?>
                                </div>
                                
                                <div id="oe_2" class='col-xs-12 col-sm-12 col-md-12'>
                                    <?php if($proyecto->objetivo_especifico_2){  ?>
                                        <ul>
                                            <li id='oespe'><b>Objetivo N°2: <?= $proyecto->objetivo_especifico_2 ?></b> <?= ($disabled=='disabled')?'':"<span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(2)'></span>" ?> </li>
                                                <input type='hidden' value='<?= $proyecto->objetivo_especifico_2 ?>' name='Proyecto[objetivo_especifico_2]'>
                                            <ul>
                                                <?php foreach($actividades as $actividad){ ?>
                                                    <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_2_id){?>
                                                        <li id='act'>Actividad: <?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_2][]'></li>
                                                        <input id="proyecto-actividades_ids_2_<?= $acti2 ?>" type="hidden" name="Proyecto[actividades_ids_2][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" />
                                                    <?php $acti2++;} ?>
                                                <?php  } ?>
                                            </ul>
                                        </ul>
                                        <?php $contoe=2; ?>
                                    <?php } ?>
                                </div>
                                
                                <div id="oe_3" class='col-xs-12 col-sm-12 col-md-12'>
                                    <?php if($proyecto->objetivo_especifico_3) { ?>
                                        <ul>
                                            <li id='oespe'><b>Objetivo N°3: <?= $proyecto->objetivo_especifico_3 ?></b> <?= ($disabled=='disabled')?'':"<span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(3)'></span>" ?> </li>
                                                <input type='hidden' value='<?= $proyecto->objetivo_especifico_3 ?>' name='Proyecto[objetivo_especifico_3]'>
                                            <ul>
                                                <?php foreach($actividades as $actividad){ ?>
                                                    <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_3_id){?>
                                                        <li id='act'>Actividad: <?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_3][]'></li>
                                                        <input id="proyecto-actividades_ids_3_<?= $acti3 ?>" type="hidden" name="Proyecto[actividades_ids_3][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" />
                                                    <?php $acti3++;  } ?>
                                                <?php  } ?>
                                            </ul>
                                        </ul>
                                        <?php $contoe=3; ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab_2">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                            <th>Actividad</th>
                            <th>Resultado</th>
                            </thead>
                            <tbody>
                            <?php $i=0;?>
                            <?php foreach($actividades as $actividad){ ?>
                                <tr>
                                    <td style="vertical-align: middle"><?= $actividad->descripcion ?></td>
                                    <td style="padding: 2px">
                                        <div class="form-group field-proyecto-resultado_esperado_<?= $i ?> required" style="margin-top: 0px">
                                            <input type="hidden"  class="form-control" name="Proyecto[resultados_ids][]" value="<?= $actividad->actividad_id ?>" >
                                            <input type="text" id="proyecto-resultado_esperado_<?= $i ?>" class="form-control " name="Proyecto[resultados_esperados][]" placeholder="Resultado #<?= $i ?>" value="<?= $actividad->resultado_esperado ?>" <?= $disabled ?> >
                                        </div>
                                    </td>
                                </tr>
                                
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_4">
                    <?= \app\widgets\cronograma\CronogramaWidget::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_5">
                    <div class="clearfix"></div>
                    <?php if($integrante->rol==1 && !$disabled){ ?>
                    
                        <?php if($video->ruta){?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            
                            <?php if($video->ruta && $video->tipo==1){ ?>
                            <br>
                            <iframe type="text/html" 
                                width="320" 
                                height="240" 
                                src="https://www.youtube.com/embed/<?= substr($video->ruta,-11) ?>" 
                                frameborder="0">
                            </iframe>
                            <?php } elseif($video->tipo==2){ ?>
                            <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video').$video->ruta ?>" >  
                            </video>
                            <?php } ?>
                            
                            Para enviar tu video puedes
                            <div class="radio">
                                <label>
                                    <input type="radio" id="video-nuevo" name="video" ><span class="circle"></span><span class="check"></span>
                                    Cargar tu video
                                </label>
                            </div>
                            
                            <div class="form-group label-floating field-video-archivo required" style="display: none">
                                <div class="imagen_equipo" style="vertical-align: middle;border: solid 1px;line-height: 160px;" aling="center">
                                <input style="cursor: pointer" type="file" id="video-archivo" class="form-control" name="Video[archivo]" onchange="Video(this)"/>
                                    Sube tu video AQUÍ.
                                </div>
                            </div>
                            
                            
                            <div class="radio">
                                <label>
                                    <input type="radio" id="video-link" name="video" ><span class="circle"></span><span class="check"></span>
                                    Copiar link de youtube
                                </label>
                            </div>
                            <div class="form-group label-floating field-proyecto-ruta required" style="display: none">
                                <label class="control-label" for="proyecto-ruta" >Link youtube</label>
                                <input type="text" class="form-control" name="Proyecto[ruta]" maxlength="450">
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            Para enviar tu video puedes
                            <div class="radio">
                                <label>
                                    <input type="radio" id="video-nuevo" name="video" ><span class="circle"></span><span class="check"></span>
                                    Cargar tu video
                                </label>
                            </div>
                            
                            <div class="form-group label-floating field-video-archivo required" style="display: none">
                                <div class="imagen_equipo" style="vertical-align: middle;border: solid 1px;line-height: 160px;" aling="center">
                                <input style="cursor: pointer" type="file" id="video-archivo" class="form-control" name="Video[archivo]" onchange="Video(this)"/>
                                    Sube tu video AQUÍ.
                                </div>
                            </div>
                            
                            
                            <div class="radio">
                                <label>
                                    <input type="radio" id="video-link" name="video" ><span class="circle"></span><span class="check"></span>
                                    Copiar link de youtube
                                </label>
                            </div>
                            <div class="form-group label-floating field-proyecto-ruta required" style="display: none">
                                <label class="control-label" for="proyecto-ruta" >Link youtube</label>
                                <input type="text" class="form-control" name="Proyecto[ruta]" maxlength="450">
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    
                    <?php if($integrante->rol==1 && $disabled && $videoprimera){ ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video').$videoprimera->ruta ?>" >  
                            </video>
                        </div>
                    <?php } ?>
                    
                    <?php if($integrante->rol==2 && $disabled && !$videoprimera && !$videosegunda){ ?>
                    <?php //var_dump($videoprimera);die; ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            
                            <?php if($video->ruta && $video->tipo==1){ ?>
                            <br>
                            <iframe type="text/html" 
                                width="320" 
                                height="240" 
                                src="https://www.youtube.com/embed/<?= substr($video->ruta,-11) ?>" 
                                frameborder="0">
                            </iframe>
                            <?php } elseif($video->tipo==2){ ?>
                            <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video').$video->ruta ?>" >  
                            </video>
                            <?php } ?>
                            
                        </div>
                    <?php } ?>
                    
                    <?php if($integrante->rol==2 && $disabled && $videoprimera){ ?>
                    <?php //var_dump($videoprimera);die; ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video').$videoprimera->ruta ?>" >  
                            </video>
                        </div>
                    <?php } ?>
                    
                    <?php if($integrante->rol==2 && $videosegunda){ ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                           <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video').$videosegunda->ruta ?>" >  
                            </video> 
                        </div>
                    <?php } ?>
                    
                    <div class="clearfix"></div>
                    
                </div><!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab_6">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-p1 required">
                            <label class="control-label" for="proyecto-p1" style="padding-left: 10px">Como equipo ¿Cómo se han sentido al trabajar su proyecto?</label>
                            <textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p1" class="form-control" rows="3" name="Proyecto[p1]"  <?= $disabled ?>><?= $proyecto->p1?></textarea>
                        </div>
                        <div class="form-group label-floating field-proyecto-p2 required">
                            <label class="control-label" for="proyecto-p2" style="padding-left: 10px">¿Qué debilidades encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                            <textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p2" class="form-control" rows="3" name="Proyecto[p2]"  <?= $disabled ?>><?= $proyecto->p2?></textarea>
                        </div>
                        <div class="form-group label-floating field-proyecto-p3 required">
                            <label class="control-label" for="proyecto-p3" style="padding-left: 10px"> ¿Qué fortalezas encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                            <textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p3" class="form-control" rows="3" name="Proyecto[p3]"  <?= $disabled ?>><?= $proyecto->p3?></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                <?php if($etapa->etapa==1 || $etapa->etapa==2 || $etapa->etapa==3){ ?>
                
                <div class="tab-pane" id="tab_7">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-evaluacion required">
                            <label class="control-label" for="proyecto-evaluacion" style="padding-left: 10px">Evaluación</label>
                            <textarea id="proyecto-evaluacion" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" class="form-control" name="Proyecto[evaluacion]"  <?= ($equipo->etapa==2)?'disabled':''; ?>><?= $proyecto->evaluacion?></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                <?php } ?>
                <?php if($etapa->etapa==2 || $etapa->etapa==3){ ?>
                <div class="tab-pane" id="tab_8">
                    <?php //= \app\widgets\foro\ForoWidget::widget(['proyecto_id'=>$proyecto->id]); ?> 
                </div><!-- /.tab-pane -->
                <?php }?>
            </div><!-- /.tab-content -->
        </div>
        
        
        
        
       
        <div class="clearfix"></div>
        <!-- Objetivo Especifico general-->
        <div class="modal fade" id="objetivo_especifico_general" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="z-index: 2000 !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="oe_modal">
                        
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-default"  onclick='MostrarOeActividades()'>Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Objetivo Especifico general-->
        <div class="modal fade" id="objetivo_especifico_general_copia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="z-index: 2000 !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="oe_modal_copia">
                        
                    </div>
                    <div class="modal-footer" id="oe_modal_button">
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div style="border-top:2px dotted #f6de34 !important;">
        <?php if($entrega!=1 && $estudiante->grado!=6){ ?>    
            <?php if($disabled=='' && $equipo->etapa==0){ ?>
            <div class="col-xs-12 col-sm-4 col-md-4" >
                <button type="submit" id="btnproyecto" class="btn btn-default">Guardar</button>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 ">
                
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 ">
                <?= \app\widgets\entrega\EntregaWidget::widget(); ?>
            </div>
            <?php } else if($disabled && $equipo->etapa==0){?>
            <div class="col-xs-12 col-sm-4 col-md-4" >
                <!--<button type="button" id="btnproyectoreflexion" class="btn btn-default">Guardar</button>-->
            </div>
            <?php } else if($equipo->etapa==1 && $integrante->rol==1){ ?>
            <div class="col-xs-12 col-sm-4 col-md-4" >
                <button type="submit" id="btnproyectoevaluacion" class="btn btn-default">Guardar</button>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 "></div>
            <div class="col-xs-12 col-sm-4 col-md-4 ">
                <?php //= \app\widgets\entrega\EntregaWidget::widget(); ?> <!--Activar cuando se acabe la semana de foros-->
            </div>
            
            
            <?php } else if($equipo->etapa==1 && $integrante->rol==2){ ?>
            <div class="col-xs-12 col-sm-4 col-md-4" >
                <!--<button type="button" id="btnproyectoevaluacion" class="btn btn-default">Guardar</button>-->
            </div>
            
            <?php } ?>
        <?php } ?>
        </div>
    </div>
</div>



<?php ActiveForm::end(); ?>

<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
     This must be loaded before fileinput.min.js -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
     This must be loaded before fileinput.min.js -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/fileinput.min.js"></script>
<!-- bootstrap.js below is needed if you wish to zoom and view file content 
     in a larger detailed modal dialog -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
<!-- optionally if you need a theme like font awesome theme you can include 
    it as mentioned below -->
<!-- optionally if you need translation for your language then include 
    locale file as mentioned below -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/locales/es.js"></script>

<?php
    $this->registerJs(
    "$('document').ready(function(){})");
?>
<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminaractividad');
    $reflexion= Yii::$app->getUrlManager()->createUrl('proyecto/reflexion');
    $evaluacion= Yii::$app->getUrlManager()->createUrl('proyecto/evaluacion');
    $archivo_pro= Yii::$app->getUrlManager()->createUrl('proyecto/archivo');
    $archivo_pro2= Yii::$app->getUrlManager()->createUrl('proyecto/archivo2');
?>
<!--var i=<?php //= $i ?>;
    var a=<?php //= $a ?>;
    var e=<?php //= $e ?>;-->
<script>
    
    $(document).ready(function ($) {
        
        $("#proyecto-archivo").fileinput({
                    uploadUrl: "<?= $archivo_pro ?>", // server upload action
                    uploadAsync: false,
                    showUpload: false, // hide upload button
                    showRemove: false, // hide remove button
                    showPreview: false,
                    showCaption:false,
                    showCancel:false,
                    browseLabel:'Subir proyecto',
                    minFileCount: 1,
                    maxFileCount: 1,
                    allowedFileExtensions:['pdf']
                }).on("filebatchselected", function(event, files) {
                    // trigger upload method immediately after files are selected
                    $("#proyecto-archivo").fileinput("upload");
                }).on('filebatchuploadcomplete', function(event, data, previewId, index) {
                    alert("Se ha subido tu proyecto satisfactoriamente");
                    location.reload();
                }).on('fileerror', function(event, data, msg) {
                    
                    $.notify({
                        message: "Solo se permite subir archivos con extensiones .pdf"
                    },{
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                    });
                });
        
        $("#proyecto-archivo2").fileinput({
                    uploadUrl: "<?= $archivo_pro2 ?>", // server upload action
                    uploadAsync: false,
                    showUpload: false, // hide upload button
                    showRemove: false, // hide remove button
                    showPreview: false,
                    showCaption:false,
                    showCancel:false,
                    browseLabel:'Subir proyecto',
                    minFileCount: 1,
                    maxFileCount: 1,
                    allowedFileExtensions:['pdf']
                }).on("filebatchselected", function(event, files) {
                    // trigger upload method immediately after files are selected
                    $("#proyecto-archivo2").fileinput("upload");
                }).on('filebatchuploadcomplete', function(event, data, previewId, index) {
                    alert("Se ha subido tu proyecto satisfactoriamente");
                    location.reload();
                }).on('fileerror', function(event, data, msg) {
                    
                    $.notify({
                        message: "Solo se permite subir archivos con extensiones .pdf"
                    },{
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                    });
                });
    });
    
    $("#video-nuevo").click(function(event){
        $(".field-video-archivo").show();
        $(".field-proyecto-ruta").hide();
    });
    
    $("#video-link").click(function(event){
        $(".field-proyecto-ruta").show();
        $(".field-video-archivo").hide();
    });
    
    $("#btnproyecto").click(function(event){
        var error='';
        var archivo=$("#proyecto-archivo").get(0).files;
        var formato_ar="<?= $proyecto->formato_proyecto ?>";
        /*planpresupuestal*/
        var planespresupuestalesrecursosdescripciones=$('input[name=\'Proyecto[planes_presupuestales_recursos_descripciones][]\']').length;
        /*planpresupeutal ini*/
        var objetivo_especifico_1=$('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
        var objetivo_especifico_2=$('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
        var objetivo_especifico_3=$('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
        var total=objetivo_especifico_1+objetivo_especifico_2+objetivo_especifico_3;
        
        if (total<2) {
            error=error+'ingrese 2 objetivos especificos como mínimo <br>';
        }
        
        for (var i=0; i<planespresupuestalesrecursosdescripciones; i++) {
	    if(jQuery.trim($('#proyecto-plan_presupuestal_recurso_descripcion_'+i).val())=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna recurso dscripción <br>';
                $('.field-proyecto-plan_presupuestal_recurso_descripcion_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_recurso_descripcion_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_recurso_descripcion_'+i).removeClass('has-error');
            }
	    /*
	    if(jQuery.trim($('#proyecto-plan_presupuestal_unidad_'+i).val())=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna unidad <br>';
                $('.field-proyecto-plan_presupuestal_unidad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_unidad_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_unidad_'+i).removeClass('has-error');
            }*/
	    
	    if(jQuery.trim($('#proyecto-plan_presupuestal_dirigido_'+i).val())=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna a quien va dirigido <br>';
                $('.field-proyecto-plan_presupuestal_dirigido_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_dirigido_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_dirigido_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-plan_presupuestal_como_conseguirlo_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna como conseguirlo <br>';
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).removeClass('has-error');
            }
	    if($('#proyecto-plan_presupuestal_cantidad_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna cantidad <br>';
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).removeClass('has-error');
            }
        }
        /*planpresupuestal fin*/
        
        
        if(jQuery.trim($('#proyecto-titulo').val())=='')
        {
            error=error+'Ingrese titulo del proyecto <br>';
            $('.field-proyecto-titulo').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-titulo').addClass('has-success');
            $('.field-proyecto-titulo').removeClass('has-error');
        }
        
        if(jQuery.trim($('#proyecto-resumen').val())=='')
        {
            error=error+'ingrese resumen del proyecto <br>';
            $('.field-proyecto-resumen').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-resumen').addClass('has-success');
            $('.field-proyecto-resumen').removeClass('has-error');
        }
        
        if(jQuery.trim($('#proyecto-beneficiario').val())=='')
        {
            error=error+'ingrese beneficiarios del proyecto <br>';
            $('.field-proyecto-beneficiario').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-beneficiario').addClass('has-success');
            $('.field-proyecto-beneficiario').removeClass('has-error');
        }
        
        /*
        if($('#proyecto-objetivo_general').val()=='')
        {
            error=error+'ingrese objetivo general del proyecto <br>';
            $('.field-proyecto-objetivo_general').addClass('has-error');
            $('.field-proyecto-objetivo_general').css( 'color', '#a94442' );
            
        }
        else
        {
            $('.field-proyecto-objetivo_general').addClass('has-success');
            $('.field-proyecto-objetivo_general').removeClass('has-error');
            $('.field-proyecto-objetivo_general').css( 'color', 'black' );
        }
        */
        
        if($('#proyecto-objetivo_especifico_1').val()=='')
        {
            error=error+'ingrese objetivo especifico 1   <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
            $('.field-proyecto-objetivo_especifico_1').css( 'color', '#a94442' );
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
            $('.field-proyecto-objetivo_especifico_1').css( 'color', 'black' );
        }
        
        if($('#proyecto-objetivo_especifico_2').val()=='')
        {
            error=error+'ingrese objetivo especifico 2   <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
            $('.field-proyecto-objetivo_especifico_2').css( 'color', '#a94442' );
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
            $('.field-proyecto-objetivo_especifico_2').css( 'color', 'black' );
        }
        
        
        
        if(error!='')
        {
            if ((archivo && archivo[0]) || formato_ar==1) {
                return true;
            }
            else
            {
                $.notify({
                    message: error 
                },{
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                        from: 'bottom',
                        align: 'right'
                    },
                });
                return false;   
            }
            
        }
        return true;
    });
    
    $('.numerico').keypress(function (e) {
		
	tecla = (document.all) ? e.keyCode : e.which; // 2
	if (tecla==8) return true; // 3
        var reg = /^[0-9\s]+$/;
        te = String.fromCharCode(tecla); // 5
	return reg.test(te); // 6
		
    });		
	
    $('#btnproyectoreflexion').click(function(events){
        var error='';
        
        if(jQuery.trim($('#proyecto-reflexion').val())=='')
        {
            error=error+'ingrese una reflexión del proyecto <br>';
            $('.field-proyecto-reflexion').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-reflexion').addClass('has-success');
            $('.field-proyecto-reflexion').removeClass('has-error');
        }
        
        if(error!='')
        {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        else
        {
            $.ajax({
                url: '<?= $reflexion ?>',
                type: 'POST',
                async: true,
                data: {'Reflexion[reflexion]':$('#proyecto-reflexion').val(),'Reflexion[proyecto_id]':<?= $proyecto->id ?>,'Reflexion[user_id]':<?= \Yii::$app->user->id ?>},
                success: function(data){
                    $.notify({
                        message: 'Se ha guardado tu reflexión' 
                    },{
                        type: 'success',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    
                    setTimeout(function(){
                                        window.location.reload(1);
                                    }, 2000); 
                }
            });
            return true;
        }
        
    });
    
    
    
    
    $('#btnproyectoevaluacion').click(function(events){
        var error='';
        var etapa=<?= $etapa->etapa ?>;
        if (etapa==2) {
            
                $.ajax({
                    url: '<?= $evaluacion ?>',
                    type: 'POST',
                    async: true,
                    data: {'Evaluacion[evaluacion]':$('#proyecto-evaluacion').val(),'Evaluacion[proyecto_id]':<?= $proyecto->id ?>,'Evaluacion[user_id]':<?= \Yii::$app->user->id ?>},
                    success: function(data){
                        $.notify({
                            message: 'Se ha guardado tu información' 
                        },{
                            type: 'success',
                            z_index: 1000000,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                        });
                        //$( "#w0" ).submit();
                    }
                });
                
                setTimeout(function(){
                                            window.location.reload(1);
                                        }, 2000);
                return true;
        }
        else
        {
            $.notify({
                message: 'Se ha guardado la información' 
            },{
                type: 'success',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            //$( "#w0" ).submit();
            setTimeout(function(){
                window.location.reload(1);
            }, 2000);
            return true;
        }
    });
    
    
    //(function() {
    $('#btnvideo').click(function(events){
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');
        $('#w0').ajaxForm({
            beforeSend: function() {
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                //console.log(percentVal, position, total);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
               // $( "#w0" ).submit();
               setTimeout(function(){
                                        window.location.reload(1);
                                    }, 10);
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
               // $( "#w0" ).submit();
                setTimeout(function(){
                                        window.location.reload(1);
                                    }, 10);
            }
        }); });
    //})();
    
    function Video(elemento) {
        var ext = $(elemento).val().split('.').pop().toLowerCase();
        var error='';
        if($.inArray(ext, ['mp4','avi','mpeg','flv']) == -1) {
            error=error+'Solo se permite subir archivos con extensiones .mp4,.avi,.mpeg,.flv';
        }
        if (error=='' && elemento.files[0].size/1024/1024>=100) {
            error=error+'Solo se permite archivos hasta 50 MB';
        }
        
        if (error!='') {
            $.notify({
                message: error
            },{
                // settings
                type: 'danger',
                z_index: 1000000,
                placement: {
                        from: 'bottom',
                        align: 'right'
                },
            });
            //fileupload = $('#equipo-foto_img');  
            //fileupload.replaceWith($fileupload.clone(true));
            $(elemento).replaceWith($(elemento).val('').clone(true));
            //$('#equipo-foto_img').val('');
            return false;
        }
        else
        {
            //mostrarImagen(this);
            return true;
        }
    }
    
    
    var oe=1;
    var actividadcon=1;
    /*
    $('#objetivo_especifico_general').on('hidden.bs.modal', function (e) {
        actividad=1;
        console.log("aa");
    });*/
    
    
    function agregarObjetivoActividad() {        
        
        
        var body="";
        var objetivo_especifico_1=$('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
        var objetivo_especifico_2=$('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
        var objetivo_especifico_3=$('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
        var total=objetivo_especifico_1+objetivo_especifico_2+objetivo_especifico_3;
        if (total>=3) {
            $.notify({
                message: 'Solo se puede agregar 3 objetivos especificos'
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        $('#objetivo_especifico_general').modal({backdrop: 'static', keyboard: false});
        actividadcon=1;
        
        body=   "<div id='objetivo'>"+
                    "<div class='col-xs-12 col-sm-12 col-md-12'>"+
                        "<div class='form-group label-floating field-proyecto-temp_objetivo_especifico required' style='margin-top: 15px'>"+
                            "<label class='control-label' for='proyecto-temp_objetivo_especifico' >Objetivo </label>"+
                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_objetivo_especifico' class='form-control'>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div class='clearfix'></div>"+
                "<div class='col-xs-12 col-sm-12 col-md-12' ><div style='padding-top:5px;border-top:2px dotted #f6de34'>Actividades <span class='glyphicon glyphicon-plus-sign' onclick='agregarActividad()' ></span></div></div>"+
               
                "<div id='actividades'></div>"+
                "<div class='clearfix'></div>";
        $("#oe_modal").html(body);
        //oe++;
        return true;
    }
    
    function agregarActividad() {
        
        var error='';
        //var temp_actividad=$("proyecto-temp_actividad_"+(actividad-1)).val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades][]\']').length;
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
            }
        }
        
        if (error!='') {
            $.notify({
                message: error
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        
        var body="";
        body=   "<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>"+
                    "<div class='form-group label-floating field-proyecto-temp_actividad_"+actividadcon+" required' style='margin-top: 15px'>"+
                        "<label class='control-label' for='proyecto-temp_actividad_actividad_"+actividadcon+"' >Descripción de actividad #"+actividadcon+"</label>"+
                        "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_"+actividadcon+"' name='Proyecto[temp_actividades][]' class='form-control'>"+
                    "</div>"+
                "</div>";
        $("#actividades").append(body);
        actividadcon++;
        return true;
    }
    
    function MostrarOeActividades() {
        oe=<?= ($contoe+1) ?>;
        var oe_es_1=$('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
        var oe_es_2=$('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
        var oe_es_3=$('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
        
        var body="";
        var error='';
        var temp_objetivo_especifico=$("#proyecto-temp_objetivo_especifico").val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades][]\']').length;
        var bodyactividades="";
        
        if (oe_es_1>0) {
            oe=2;
        }
        
        if (oe_es_2>0) {
            oe=3;
        }
        
        
        if(jQuery.trim(temp_objetivo_especifico)=='')
        {
            error=error+'Ingrese descripción en Objetivo especifico <br>';
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-success');
            $('.field-proyecto-temp_objetivo_especifico').removeClass('has-error');
        }
        
        if (temp_actividades==0) {
            error=error+'Ingrese 1 actividad como mínimo <br>';
        }
        
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
            }
        }
        
        
        if (error!='') {
            $.notify({
                message: error
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        
        
        $("#actividades input").each(function( index ) {
            bodyactividades=bodyactividades+"<li id='act'> Actividad: "+$( this ).val()+" <input type='hidden' value='"+$( this ).val()+"' name='Proyecto[actividades_"+oe+"][]'></li>";
            console.log( $( this ).val() );
        });
        
        
        
        var body=   "<div id='oe_"+oe+"' class='col-xs-12 col-sm-12 col-md-12'>"+
                            "<ul><li id='oespe'><b>Objetivo N°"+oe+": "+temp_objetivo_especifico+"</b> <span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar("+oe+")'></span></li>"+
                            "<input type='hidden' value='"+temp_objetivo_especifico+"' name='Proyecto[objetivo_especifico_"+oe+"]'>"+
                            "<ul>"+bodyactividades+"</ul></ul>"+
                    "</div>";
        $('#objetivo_especifico_general').modal('toggle');
        $("#mostrar_oe_actividades").append(body);
        oe++;
        actividadcon=1;
        return true;
        
    }
    
    function Editar(identificador) {
        $('#objetivo_especifico_general_copia').modal({backdrop: 'static', keyboard: false});
        //var objetivo_especifico="";
        var objetivo_especifico=$("input[name='Proyecto[objetivo_especifico_"+identificador+"]']").val();
        var bodyactividades="";
        var a=1;
        $("input[name='Proyecto[actividades_"+identificador+"][]']").each(function( index ) {
            bodyactividades=bodyactividades+"<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>"+
                                                "<div class='form-group label-floating field-proyecto-temp_actividad_"+a+" required' style='margin-top: 15px'>"+
                                                    "<label class='control-label' for='proyecto-temp_actividad_actividad_"+a+"'>Descripción de actividad #"+a+"</label>"+
                                                    "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_"+a+"' name='Proyecto[temp_actividades_copia][]' class='form-control' value='"+$(this).val()+"'>"+
                                                "</div>"+
                                            "</div>";
            a++;
        });
        
        
        body=   "<div id='objetivo_copia'>"+
                    "<div class='col-xs-12 col-sm-12 col-md-12'>"+
                        "<div class='form-group label-floating field-proyecto-temp_objetivo_especifico required' style='margin-top: 15px'>"+
                            "<label class='control-label' for='proyecto-temp_objetivo_especifico' >Objetivo </label>"+
                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_objetivo_especifico_"+identificador+"' class='form-control' value='"+objetivo_especifico+"'>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div class='clearfix'></div>"+
                "<div class='col-xs-12 col-sm-12 col-md-12' ><div style='padding-top::5px;border-top:2px dotted #f6de34'> Actividades <span class='glyphicon glyphicon-plus-sign' onclick='agregarActividadCopia()' ></span></div></div>"+
               
                "<div id='actividades_copia'>"+
                bodyactividades+
                "</div>"+
                "<div class='clearfix'></div>";
        $("#oe_modal_copia").html(body);
                        
        $("#oe_modal_button").html('<div class="col-md-4"></div>'+
                                   '<div class="col-md-4"><button type="button" class="btn btn-default"  onclick="MostrarOeActividadesCopia('+identificador+')">Aceptar</button></div>');
        
        actividad=a;
        return true;
    }
    
    function MostrarOeActividadesCopia(identificador) {
        oe=identificador;
        var body="";
        var error='';
        var temp_objetivo_especifico=$("#proyecto-temp_objetivo_especifico_"+identificador+"").val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades_copia][]\']').length;
        
        var bodyactividades="";
        if(jQuery.trim(temp_objetivo_especifico)=='')
        {
            error=error+'Ingrese descripción en Objetivo especifico <br>';
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-success');
            $('.field-proyecto-temp_objetivo_especifico').removeClass('has-error');
        }
        
        if (temp_actividades==0) {
            error=error+'Ingrese 1 actividad como mínimo <br>';
        }
        
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
            }
        }
        
        
        if (error!='') {
            $.notify({
                message: error
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        
        
        if (oe==1) {
            <?php foreach($actividades as $actividad){ ?>
                <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_1_id){?>
                    //bodyactividades=bodyactividades+"<li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_"+oe+"][]'></li>"+
                                    //"<input type='hidden' name='Proyecto[actividades_ids_"+oe+"][]'  value='<?= $actividad->actividad_id ?>' />";
                <?php } ?>
            <?php } ?>  
        }
        else if(oe==2){
            <?php foreach($actividades as $actividad){ ?>
                <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_2_id){?>
                    //bodyactividades=bodyactividades+"<li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_"+oe+"][]'></li>"+
                                //    "<input type='hidden' name='Proyecto[actividades_ids_"+oe+"][]'  value='<?= $actividad->actividad_id ?>' />";
                <?php } ?>
            <?php } ?>  
        }
        else if(oe==3){
            <?php foreach($actividades as $actividad){ ?>
                <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_3_id){?>
                    //bodyactividades=bodyactividades+"<li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_"+oe+"][]'></li>"+
                                  //  "<input type='hidden' name='Proyecto[actividades_ids_"+oe+"][]'  value='<?= $actividad->actividad_id ?>' />";
                <?php } ?>
            <?php } ?>  
        }
        
        
        
        var acti=0;
        $("#actividades_copia input").each(function( index ) {
            //console.log($("#proyecto-actividades_ids_"+oe+"_"+acti+"").val());
            input="";
            if ($("#proyecto-actividades_ids_"+oe+"_"+acti+"").length > 0) {
                input="<input id='proyecto-actividades_ids_"+oe+"_"+acti+"' type='hidden' name='Proyecto[actividades_ids_"+oe+"][]' value='"+$("#proyecto-actividades_ids_"+oe+"_"+acti+"").val()+"' >";
            }
            
            bodyactividades=bodyactividades+"<li id='act'>Actividad: "+$( this ).val()+" <input type='hidden' value='"+$( this ).val()+"' name='Proyecto[actividades_"+oe+"][]'></li>"+
                                              input;
                                            /*"<input id='proyecto-actividades_ids_"+oe+"_"+acti+"' type='hidden' name='Proyecto[actividades_ids][]'  value='"+$('#proyecto-actividades_ids_'+oe+'_'+acti+'').val()+"' />";*/
            
            acti++;
        });
        
        
        
        var body=   "<div id='oe_"+oe+"' class='col-xs-12 col-sm-12 col-md-12'>"+
                            "<ul><li id='oespe'><b>Objetivo N°"+oe+": "+temp_objetivo_especifico+"</b> <span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar("+oe+")'></span> </li>"+
                            "<input type='hidden' value='"+temp_objetivo_especifico+"' name='Proyecto[objetivo_especifico_"+oe+"]'>"+
                            "<ul>"+bodyactividades+"</ul></ul>"+
                    "</div>";
        $('#objetivo_especifico_general_copia').modal('toggle');
        $("#oe_"+identificador+"").replaceWith(body);
        oe++;
        actividadcon=1;
        return true;
        
    }
    
    
    function agregarActividadCopia() {
        
        var error='';
        //var temp_actividad=$("proyecto-temp_actividad_"+(actividad-1)).val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades_copia][]\']').length;
        
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
            }
        }
        
        if (error!='') {
            $.notify({
                message: error
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        
        var body="";
        body=   "<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>"+
                    "<div class='form-group label-floating field-proyecto-temp_actividad_"+actividad+" required' style='margin-top: 15px'>"+
                        "<label class='control-label' for='proyecto-temp_actividad_actividad_"+actividad+"' >Descripción de actividad #"+actividad+"</label>"+
                        "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_"+actividad+"' name='Proyecto[temp_actividades_copia][]' class='form-control'>"+
                    "</div>"+
                "</div>";
        $("#actividades_copia").append(body);
        actividad++;
        return true;
    }
    
    function Documento(elemento) {
        var ext = $(elemento).val().split('.').pop().toLowerCase();
        var error='';
        if($.inArray(ext, ['pdf']) == -1) {
            error=error+'Solo se permite subir archivos con extensiones .pdf';
        }
        if (error=='' && elemento.files[0].size/1024/1024>=10) {
            error=error+'Solo se permite archivos hasta 5 MB';
        }
        
        if (error!='') {
            $.notify({
                message: error
            },{
                // settings
                type: 'danger',
                z_index: 1000000,
                placement: {
                        from: 'bottom',
                        align: 'right'
                },
            });
            //fileupload = $('#equipo-foto_img');  
            //fileupload.replaceWith($fileupload.clone(true));
            $(elemento).replaceWith($(elemento).val('').clone(true));
            //$('#equipo-foto_img').val('');
            return false;
        }
        else
        {
            //mostrarImagen(this);
            return true;
        }
    }
</script>

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>

