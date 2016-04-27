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

?>


<?php $form = ActiveForm::begin(); ?>
<h1><b>Mi proyecto</b></h1>
<hr class="colorgraph">
<div class="row">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" style="background: white;">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Datos generales</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Objetivos y actividades</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="col-xs-12 col-sm-3 col-md-3"></div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-titulo required" style="margin-top: 15px">
                            <label class="control-label" for="proyecto-titulo" title="Máximo 200 palabras">Título</label>
                            <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" id="proyecto-titulo" class="form-control" name="Proyecto[titulo]" maxlength="200" title="Máximo 200 palabras">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-asunto required">
                            <label class="control-label" for="proyecto-asunto" >Asunto público</label>
                            <?= $equipo->asunto->descripcion_cabecera?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-resumen required" style="margin-top: 15px">
                            <label class="control-label" for="proyecto-resumen" title="Mínimo 500 palabras">Sumilla / Justificación</label>
                            <textarea style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="proyecto-resumen" class="form-control" name="Proyecto[resumen]" minlength="100" maxlength="2500" title="Mínimo 500 palabras"></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-beneficiario required" style="margin-top: 15px">
                            <label class="control-label" for="proyecto-beneficiario">Beneficiario</label>
                            <textarea style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="proyecto-beneficiario" class="form-control" name="Proyecto[beneficiario]" ></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-3 col-md-3"></div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-objetivo_general required" style="margin-top: 15px">
                            <label class="control-label" for="proyecto-objetivo_general" title="Máximo 200 palabras">Objetivo general</label>
                            <textarea style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="proyecto-objetivo_general" class="form-control" name="Proyecto[objetivo_general]"  maxlength="200"  title="Máximo 200 palabras"></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4>Objetivos especificos <span class="glyphicon glyphicon-plus-sign" onclick="agregarObjetivoActividad()" ></span></h4>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div id="mostrar_oe_actividades">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!--<div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group field-proyecto-objetivo_especifico_1 required">
                            <span class="glyphicon glyphicon-plus-sign field-proyecto-objetivo_especifico_1" data-toggle="modal" data-target="#objetivo_especifico_1"></span>
                            <div style="display: inline" id="txt_objetivo_especifico_1"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group field-proyecto-objetivo_especifico_2 required">
                            <span class="glyphicon glyphicon-plus-sign field-proyecto-objetivo_especifico_2" data-toggle="modal" data-target="#objetivo_especifico_2"></span>
                            <div style="display: inline" id="txt_objetivo_especifico_2"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group field-proyecto-objetivo_especifico_3 required">
                            <span class="glyphicon glyphicon-plus-sign field-proyecto-objetivo_especifico_3" data-toggle="modal" data-target="#objetivo_especifico_3"></span>
                            <div style="display: inline" id="txt_objetivo_especifico_3"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>-->
                </div>
                <div class="clearfix"></div>
            </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
    </div>
    
    
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
           <button type="submit" id="btnproyecto" class="btn btn-raised btn-success">Guardar</button>
        
    </div>
</div>

<!-- Objetivo Especifico general-->
<div class="modal fade" id="objetivo_especifico_general" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 2000 !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="oe_modal">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-success"  onclick='MostrarOeActividades()'>Aceptar</button>
            </div>
        </div>
    </div>
</div>


<!-- Objetivo Especifico 1 
<div class="modal fade" id="objetivo_especifico_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 2000 !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <div class="form-group label-floating field-proyecto-objetivo_especifico_1 required">
                        <label class="control-label" for="proyecto-objetivo_especifico_1" title="Máximo 200 palabras">Objetivo especifico 1</label>
                        <textarea id="proyecto-objetivo_especifico_1" class="form-control" name="Proyecto[objetivo_especifico_1]"  maxlength="200"  title="Máximo 200 palabras"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <table class="table table-striped table-hover" id="tab_logic_1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Actividad
                                </th>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addr_1_0'>
                                <td>
                                1
                                </td>
                                <td style="padding: 2px">
                                    <div class="form-group field-proyecto-actividad_objetivo1_0 required" style="margin-top: 0px">
                                        <input type="text" id="proyecto-actividad_objetivo1_0" class="form-control" name="Proyecto[actividades_1][]" placeholder="Actividad #1"/>
                                    </div>
                                </td>
                                <td>
                                    <span class="remCF glyphicon glyphicon-minus-sign"></span>
                                </td>
                            </tr>
                            <tr id='addr_1_1'></tr>
                        </tbody>
                    </table>
                    
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <div id="add_row_1" class="btn btn-raised btn-success" value="1">Agregar</div>
                <button type="button" id="btn_objetivo_especifico_1" class="btn btn-raised btn-success" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-raised btn-success" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Objetivo Especifico 2 
<div class="modal fade" id="objetivo_especifico_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 2000 !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <div class="form-group label-floating field-proyecto-objetivo_especifico_2 required">
                        <label class="control-label" for="proyecto-objetivo_especifico_2" title="Máximo 200 palabras">Objetivo especifico #2</label>
                        <textarea id="proyecto-objetivo_especifico_2" class="form-control" name="Proyecto[objetivo_especifico_2]"  maxlength="200" title="Máximo 200 palabras"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <table class="table table-striped table-hover" id="tab_logic_2">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Actividad
                                </th>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addr_2_0'>
                                <td>
                                1
                                </td>
                                <td style="padding: 2px">
                                    <div class="form-group field-proyecto-actividad_objetivo2_0 required" style="margin-top: 0px">
                                        <input type="text" id="proyecto-actividad_objetivo2_0" class="form-control" name="Proyecto[actividades_2][]" placeholder="Actividad #1"/>
                                    </div>
                                </td>
                                <td>
                                    <span class="remCF glyphicon glyphicon-minus-sign"></span>
                                </td>
                            </tr>
                            <tr id='addr_2_1'></tr>
                        </tbody>
                    </table>
                    <br>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <div id="add_row_2" class="btn btn-raised btn-success" value="1">Agregar</div>
                <button type="button" id="btn_objetivo_especifico_2" class="btn btn-raised btn-success" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-raised btn-success" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<!-- Objetivo Especifico 3 
<div class="modal fade" id="objetivo_especifico_3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 2000 !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <div class="form-group label-floating field-proyecto-objetivo_especifico_3 required">
                        <label class="control-label" for="proyecto-objetivo_especifico_3" title="Máximo 200 palabras">Objetivo especifico #3</label>
                        <textarea id="proyecto-objetivo_especifico_3" class="form-control" name="Proyecto[objetivo_especifico_3]"  maxlength="200" title="Máximo 200 palabras"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <table class="table table-striped table-hover" id="tab_logic_3">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Actividad
                                </th>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addr_3_0'>
                                <td>
                                1
                                </td>
                                <td style="padding: 2px">
                                    <div class="form-group field-proyecto-actividad_objetivo3_0 required" style="margin-top: 0px">
                                        <input type="text" id="proyecto-actividad_objetivo3_0" class="form-control" name="Proyecto[actividades_3][]" placeholder="Actividad #1" />
                                    </div>
                                </td>
                                <td>
                                    <span class="remCF glyphicon glyphicon-minus-sign"></span>
                                </td>
                            </tr>
                            <tr id='addr_3_1'></tr>
                        </tbody>
                    </table>
                    <br>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <div id="add_row_3" class="btn btn-raised btn-success" value="1">Agregar</div>
                <button type="button" id="btn_objetivo_especifico_3" class="btn btn-raised btn-success" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-raised btn-success" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

-->
<?php ActiveForm::end(); ?>



<?php
    $this->registerJs(
    "$('document').ready(function(){})");
?>
<script>
    var i=1;
    var a=1;
    var e=1;
    $("#tab_logic_1").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });
    
    $("#tab_logic_2").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });
    
    $("#tab_logic_3").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });
    $("#add_row_1").click(function(){
        
        
        var objetivo=$('input[name=\'Proyecto[actividades_1][]\']').length;
        if (objetivo==5 && $('#proyecto-actividad_objetivo1_'+(i-1)).val()!='')
        {
            $.notify({
                message: 'No se puede agregar mas de 5' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).removeClass('has-error');
            return false;
        }
        
        
        if($('#proyecto-actividad_objetivo1_'+(i-1)).val()=='')
        {
            var error='ingrese la '+i+' actividad <br>';
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).addClass('has-error');
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
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).removeClass('has-error');
            
            $('#addr_1_'+i).html("<td>"+ (i+1) +"</td><td style='padding: 2px'><div class='form-group field-proyecto-actividad_objetivo1_"+i+" required' style='margin-top: 0px'><input placeholder='Actividad #"+(i+1)+"' id='proyecto-actividad_objetivo1_"+i+"' name='Proyecto[actividades_1][]' type='text' class='form-control'  /></div></td><td><span class='remCF glyphicon glyphicon-minus-sign'></span></td>");
            $('#tab_logic_1').append('<tr id="addr_1_'+(i+1)+'"></tr>');
            i++;
        }
        
        
        return true;
    });
    
    
    $("#add_row_2").click(function(){
        
        
        var objetivo=$('input[name=\'Proyecto[actividades_2][]\']').length;
        if (objetivo==5 && $('#proyecto-actividad_objetivo2_'+(a-1)).val()!='')
        {
            $.notify({
                message: 'No se puede agregar mas de 5' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).removeClass('has-error');
            return false;
        }
        
        
        if($('#proyecto-actividad_objetivo2_'+(a-1)).val()=='')
        {
            var error='ingrese la '+a+' actividad <br>';
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).addClass('has-error');
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
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).removeClass('has-error');
            
            $('#addr_2_'+a).html("<td>"+ (a+1) +"</td><td style='padding: 2px'><div class='form-group field-proyecto-actividad_objetivo2_"+a+" required' style='margin-top: 0px'><input placeholder='Actividad #"+(a+1)+"' id='proyecto-actividad_objetivo2_"+a+"' name='Proyecto[actividades_2][]' type='text' class='form-control'  /></div></td><td><span class='remCF glyphicon glyphicon-minus-sign'></span></td>");
            $('#tab_logic_2').append('<tr id="addr_2_'+(a+1)+'"></tr>');
            a++;
        }
        
        
        return true;
    });
    
    
    $("#add_row_3").click(function(){
        
        
        var objetivo=$('input[name=\'Proyecto[actividades_3][]\']').length;
        if (objetivo==5 && $('#proyecto-actividad_objetivo3_'+(e-1)).val()!='')
        {
            $.notify({
                message: 'No se puede agregar mas de 5' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).removeClass('has-error');
            return false;
        }
        
        
        if($('#proyecto-actividad_objetivo3_'+(e-1)).val()=='')
        {
            var error='ingrese la '+e+' actividad <br>';
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).addClass('has-error');
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
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).removeClass('has-error');
            
            $('#addr_3_'+e).html("<td>"+ (e+1) +"</td><td style='padding: 2px'><div class='form-group field-proyecto-actividad_objetivo3_"+e+" required' style='margin-top: 0px'><input placeholder='Actividad #"+(e+1)+"' id='proyecto-actividad_objetivo3_"+e+"' name='Proyecto[actividades_3][]' type='text' class='form-control'  /></div></td><td><span class='remCF glyphicon glyphicon-minus-sign'></span></td>");
            $('#tab_logic_3').append('<tr id="addr_3_'+(e+1)+'"></tr>');
            e++;
        }
        
        
        return true;
    });
    /*
    $("#delete_row").click(function(){
        if(i>1){
            $("#addr"+(i-1)).html('');
            i--;
        }
    });*/
    
    
    $("#btn_objetivo_general").click(function(event){
        if ($('#proyecto-objetivo_general').val()=='') {
            $.notify({
                message: 'Ingrese el Objetivo General' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-objetivo_general').addClass('has-error');
            return false;
        }
        $('.field-proyecto-objetivo_general').css( 'color', 'black' );
        $("#txt_objetivo_general").html($('#proyecto-objetivo_general').val());
        
        return true;
    });
    
    $("#btn_objetivo_especifico_1").click(function(event){
        var error='';
        if ($('#proyecto-objetivo_especifico_1').val()=='') {
            error=error+' Ingrese el Objetivo especifico 1 <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
        }
        
        var objetivo1=$('input[name=\'Proyecto[actividades_1][]\']').length;
        for (var i=0; i<objetivo1; i++) {
            if($('#proyecto-actividad_objetivo1_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo1_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo1_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo1_'+i).removeClass('has-error');
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
        else
        {
            $("#txt_objetivo_especifico_1").html($('#proyecto-objetivo_especifico_1').val());
            $('.field-proyecto-objetivo_especifico_1').css( 'color', 'black' );
            return true;
        }
        
    });
    
    $("#btn_objetivo_especifico_2").click(function(event){
        var error='';
        
        var objetivo2=$('input[name=\'Proyecto[actividades_2][]\']').length;
        for (var i=0; i<objetivo2; i++) {
            if($('#proyecto-actividad_objetivo2_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo2_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo2_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo2_'+i).removeClass('has-error');
            }
        }
        
        if ($('#proyecto-objetivo_especifico_2').val()=='') {
            error=error+'Ingrese el Objetivo especifico 2 <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
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
        else
        {
            $("#txt_objetivo_especifico_2").html($('#proyecto-objetivo_especifico_2').val());
            $('.field-proyecto-objetivo_especifico_2').css( 'color', 'black' );
            return true;
        }
    });
    
    $("#btn_objetivo_especifico_3").click(function(event){
        var error='';
        
        if ($('#proyecto-objetivo_especifico_3').val()=='') {
            error=error+'Ingrese el Objetivo especifico 3 <br>';
            $('.field-proyecto-objetivo_especifico_3').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_3').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_3').removeClass('has-error');
        }
            
        var objetivo3=$('input[name=\'Proyecto[actividades_3][]\']').length;
        for (var i=0; i<objetivo3; i++) {
            if($('#proyecto-actividad_objetivo3_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo3_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo3_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo3_'+i).removeClass('has-error');
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
        else
        {
            $("#txt_objetivo_especifico_3").html($('#proyecto-objetivo_especifico_3').val());
            $('.field-proyecto-objetivo_especifico_3').css( 'color', 'black' );
            return true;
        }
    });
    
    $("#btnproyecto").click(function(event){
        var error='';
        var objetivo_especifico_1=$('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
        var objetivo_especifico_2=$('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
        var objetivo_especifico_3=$('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
        var total=objetivo_especifico_1+objetivo_especifico_2+objetivo_especifico_3;
        
        if (total<3) {
            error=error+'ingrese 3 objetivos especificos <br>';
        }
        
        
        if($('#proyecto-titulo').val()=='')
        {
            error=error+'ingrese titulo del proyecto <br>';
            $('.field-proyecto-titulo').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-titulo').addClass('has-success');
            $('.field-proyecto-titulo').removeClass('has-error');
        }
        
        if($('#proyecto-resumen').val()=='')
        {
            error=error+'ingrese resumen del proyecto <br>';
            $('.field-proyecto-resumen').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-resumen').addClass('has-success');
            $('.field-proyecto-resumen').removeClass('has-error');
        }
        
        if($('#proyecto-beneficiario').val()=='')
        {
            error=error+'ingrese beneficiarios del proyecto <br>';
            $('.field-proyecto-beneficiario').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-beneficiario').addClass('has-success');
            $('.field-proyecto-beneficiario').removeClass('has-error');
        }
        
        
        if($('#proyecto-objetivo_general').val()=='')
        {
            error=error+'ingrese objetivo general del proyecto <br>';
            $('.field-proyecto-objetivo_general').addClass('has-error');
            
        }
        else
        {
            $('.field-proyecto-objetivo_general').addClass('has-success');
            $('.field-proyecto-objetivo_general').removeClass('has-error');
        }
        
        /*
        if($('#proyecto-objetivo_especifico_1').val()=='')
        {
            error=error+'ingrese objetivo especifico 1   <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
        }
        
        if($('#proyecto-objetivo_especifico_2').val()=='')
        {
            error=error+'ingrese objetivo especifico 2   <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
        }
        */
        
        
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
        return true;
    });
    
    $('.numerico').keypress(function (tecla) {
        var reg = /^[0-9\s]+$/;
        if(!reg.test(String.fromCharCode(tecla.which))){
            return false;
        }
        return true;
    });
    var oe=1;
    var actividad=1;
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
        actividad=1;
        
        body=   "<div id='objetivo'>"+
                    "<div class='col-xs-12 col-sm-12 col-md-12'>"+
                        "<div class='form-group label-floating field-proyecto-temp_objetivo_especifico required' style='margin-top: 15px'>"+
                            "<label class='control-label' for='proyecto-temp_objetivo_especifico' >Objetivo especifico </label>"+
                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_objetivo_especifico' class='form-control'>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div class='clearfix'></div>"+
                "<div class='col-xs-12 col-sm-12 col-md-12'>Actividades <span class='glyphicon glyphicon-plus-sign pull-right' onclick='agregarActividad()' ></span></div>"+
               
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
        body=   "<div class='col-xs-12 col-sm-12 col-md-12'>"+
                    "<div class='form-group label-floating field-proyecto-temp_actividad_"+actividad+" required' style='margin-top: 15px'>"+
                        "<label class='control-label' for='proyecto-temp_actividad_actividad_"+actividad+"' >Descripción de actividad #"+actividad+"</label>"+
                        "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_"+actividad+"' name='Proyecto[temp_actividades][]' class='form-control'>"+
                    "</div>"+
                "</div>";
        $("#actividades").append(body);
        actividad++;
        return true;
    }
    
    function MostrarOeActividades() {
        var body="";
        var error='';
        var temp_objetivo_especifico=$("#proyecto-temp_objetivo_especifico").val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades][]\']').length;
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
        
        
        $("#actividades input").each(function( index ) {
            bodyactividades=bodyactividades+"<li>"+$( this ).val()+" <input type='hidden' value='"+$( this ).val()+"' name='Proyecto[actividades_"+oe+"][]'></li>";
            console.log( $( this ).val() );
        });
        
        
        
        var body=   "<div class='col-xs-12 col-sm-12 col-md-12'>"+
                            "<li><b>"+temp_objetivo_especifico+"</b></li>"+
                            "<input type='hidden' value='"+temp_objetivo_especifico+"' name='Proyecto[objetivo_especifico_"+oe+"]'>"+
                            "<ul>"+bodyactividades+"</ul>"+
                    "</div>";
        $('#objetivo_especifico_general').modal('toggle');
        $("#mostrar_oe_actividades").append(body);
        oe++;
        actividad=1;
        return true;
        
    }
</script>





