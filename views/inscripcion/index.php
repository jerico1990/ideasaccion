<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use yii\widgets\Pjax;
use yii\web\JsExpression;
$equipoid=0;
if($equipo->id)
{
    $equipoid=$equipo->id;
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        (function ($) {
            $('#filtrar_nombres').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.buscar tr').hide();
                $('.buscar tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            });
            
            $('#filtrar_grado').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.buscar tr').hide();
                $('.buscar tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
            
            $('#filtrar_nombres_docente').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.buscar_docente tr').hide();
                $('.buscar_docente tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            });
        }(jQuery));
    });
  </script>

<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">MI EQUIPO
</div>
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<div class="box_content contenido_seccion_crear_equipo">

    <div class="row">
        <div class="col-md-9">
            <div class="form-group label-floating field-equipo-descripcion_equipo required" >
                <label class="control-label" for="equipo-descripcion_equipo">Nombre del equipo</label>
                <input value="<?= $equipo->descripcion_equipo?>" type="text" id="equipo-descripcion_equipo" class="form-control texto" name="Equipo[descripcion_equipo]">
            </div>
            <div class="form-group label-floating field-equipo-descripcion required">
                <label class="control-label" for="equipo-descripcion">Danos una breve descripción de tu equipo</label>
                <textarea  id="equipo-descripcion" class="form-control" name="Equipo[descripcion]" cols="30" rows="3"><?= $equipo->descripcion?></textarea>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""> </label>
                <div class="imagen_equipo" style="border: 0px;">
                    
                    <input type="file" id="equipo-foto_img" class="form-control file" name="Equipo[foto_img]" onchange="Imagen(this)">
                    <img id='img_destino' src=""  style="vertical-align: middle;line-height: 160px;line-width: 150px;height: 160px;width: 150px;align:center;cursor: pointer" alt="Agrega una imagen para tu equipo">
                        
                    <?php //= Html::img('',['id'=>'img_destino','class'=>'text-center', 'alt'=>'Agrega una imagen para tu equipo','style'=>"height: 160px;width: 150px;align:center;cursor: pointer"]) ?>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <div class="form-group label-floating field-equipo-asunto_id required" >
                <label class="control-label" for="equipo-asunto_id">Selecciona el Asunto de Público sobre el que trabajará tu equipo</label>
                <select id="equipo-asunto_id" class="form-control" name="Equipo[asunto_id]">
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Selecciona a los miembros de tu equipo:</label>
            </div>
        </div>
    </div>
    <div class="row tabla_crear_equipo">
        <div class="col-md-12">
            <table id="estudiantes" class="table table-bordered" >
                <thead>
                    <tr class="filtros">
                            <td width="6%"> </td>
                            <td width="60%" class="filtros">
                                    <input id="filtrar_nombres" type="text"  placeholder="Filtro 01" class="">
                            </td>
                            <td width="34%" class="filtros">
                                    <input id="filtrar_grado" type="text" placeholder="Filtro 02" class="">
                            </td>
                    </tr>
                    <tr class="cabecera_tabla">
                            <td> </td>
                            <td>Apellidos y Nombres</td>
                            <td align="center">Grados</td>
                    </tr>
                </thead>

                <tbody class="buscar">
                    <?php
                        $i=1;
                        foreach($estudiantes as $estudiante)
                        {
                            echo "<tr>
                                    <td><div class='checkbox'><label><input name='Equipo[invitaciones][]' type='checkbox' value='$estudiante->id' onclick='validar($estudiante->id,$equipoid,$(this))'><span class='checkbox-material'></span></label></div></td>
                                    
                                    <td style='vertical-align:middle'>$estudiante->nombres $estudiante->apellido_paterno $estudiante->apellido_materno</td>
                                    <td align='center' style='vertical-align:middle'> ".$estudiante->getGrado() ."</td>
                            </tr>";
                             
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Selecciona a tu docente:</label>
            </div>
        </div>
    </div>
    <div class="row tabla_crear_equipo">
        <div class="col-md-12">
            <table id="docentes" class="table table-bordered" >
                <thead>
                    <tr class="filtros">
                            <td width="6%"> </td>
                            <td width="60%" class="filtros">
                                    <input id="filtrar_nombres_docente" type="text"  placeholder="Filtro 01" class="">
                            </td>
                    </tr>
                    <tr class="cabecera_tabla">
                            <td> </td>
                            <td>Apellidos y Nombres</td>
                    </tr>
                </thead>

                <tbody class="buscar_docente">
                    <?php
                        $i=1;
                        foreach($docentes as $docente)
                        {
                            echo "<tr>
                                    <td><div class='checkbox'><label><input name='Equipo[invitaciones_docente][]' type='checkbox' value='$docente->id' onclick='validardocente($docente->id,$equipoid,$(this))'><span class='checkbox-material'></span></label></div></td>
                                    
                                    <td style='vertical-align:middle'>$docente->nombres $docente->apellido_paterno $docente->apellido_materno</td>
                                    
                            </tr>";
                             
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
                <button type="submit" id="btnequipo" class="btn btn-default"><?= $equipo->isNewRecord ? Yii::t('app', 'Crea tu equipo') : Yii::t('app', 'Actualizar') ?></button>
        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>





<?php
    //$validarintegrante= Yii::$app->getUrlManager()->createUrl('equipo/validarintegrante');
    $validarinvitacioneintegrante= Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrante');
    $validarinvitacioneintegrantedocente= Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrantedocente');
    $validarinvitacioneintegrante2= Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrante2');
    $validarinvitacioneintegrante5= Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrante5');
    $validarintegrante2= Yii::$app->getUrlManager()->createUrl('equipo/validarintegrante2');
    $existeequipo=Yii::$app->getUrlManager()->createUrl('equipo/existeequipo');
    
    $this->registerJs(
    "$('document').ready(function(){
        
        
        
    })");
?>

<script>
   
                  
    function mostrarImagen(input) {
        if (input.files && input.files[0]) {
            //$(this).parent().css("background", "url(/images/r-srchbg_white.png) no-repeat");
            
            var reader = new FileReader();
            reader.onload = function (e) {
                //$('#img_destino').css("background", e.target.result);
                $('#img_destino').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function Imagen(elemento) {
        var ext = $(elemento).val().split('.').pop().toLowerCase();
        var error='';
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            error=error+'Solo se permite subir archivos con extensiones .gif,.png,.jpg,.jpeg';
        }
        
        if (error=='' && elemento.files[0].size/1024/1024>=5) {
            error=error+'Solo se permite archivos hasta 5MB';
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
            //elemento.replaceWith(elemento.val('').clone(true));
            $('#equipo-foto_img').val('');
            $('#img_destino').attr('src', '../foto_equipo/no_disponible.jpg');
            
            return false;
        }
        else
        {
            
            mostrarImagen(elemento);
            return true;
        }
    }
    
    var contador=<?= $invitacionContador ?>;
    
    var equipo=<?= $invitacionContador ?>;
    
    var contadordocente=<?= $invitacionContadorDocente ?>;
    
    var equipodocente=<?= $invitacionContadorDocente ?>;
    $( '#btnequipo' ).click(function( event ) {
        var error='';
        var bandera=true;
        if($('#equipo-descripcion_equipo').val()=='')
        {
            error=error+'ingrese descripcion del equipo <br>';
            $('.field-equipo-descripcion_equipo').addClass('has-error');
        }
        
        if($('#equipo-descripcion').val()=='')
        {
            error=error+'ingrese descripcion del proyecto <br>';
            $('.field-equipo-descripcion').addClass('has-error');
        }
        
        if($('#equipo-asunto_id').val()=='')
        {
            error=error+'ingrese asunto <br>';
            $('.field-equipo-asunto_id').addClass('has-error');
        }
        
        var validarinvitaciones= $.ajax({
            url: '<?= $validarinvitacioneintegrante5 ?>',
            type: 'GET',
            async: false,
            data: {equipo:<?= $equipoid ?>},
            success: function(data){
                
            }
        });
        
        if (validarinvitaciones.responseText==1) {
            error=error+'Ya no tienes permitido enviar mas invitaciones';
        }
        //console.log(validarinvitaciones);
        //return false;
        
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
            if (validarinvitaciones.responseText==1) {
                setTimeout(function(){
                    window.location.reload(1);
                }, 2000);
            }
            return false;
        }
        
        
        if (equipo==0)
        {
            var existeequipo=$.ajax({
                url: '<?= $existeequipo ?>',
                //type: 'GET',
                async: false,
                //data: {},
                success: function(data){
                    
                }
            });
            
            if (existeequipo.responseText==1) {
                $.notify({
                    // options
                    message: 'Ya creastes un equipo' 
                },{
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                setTimeout(function(){
                    window.location.reload(1);
                }, 2000);
                return false;
            }
        }
        else
        {
            var estudiantes = $('input[name="Equipo[invitaciones][]"]:checked').map(function(){ 
                    return this.value; 
                }).get();
            var validarestudiantes=$.ajax({
                url: '<?= $validarinvitacioneintegrante2 ?>',
                type: 'POST',
                async: false,
                data: {'Equipo[invitaciones][]':estudiantes,'Equipo[id]':<?= $equipoid ?>,'Equipo[tipo]':1},
                success: function(data){
                    
                }
            });
            
            if (validarestudiantes.responseText==1) {
                
                $.ajax({
                    url: '<?= $validarinvitacioneintegrante2 ?>',
                    type: 'POST',
                    async: true,
                    data: {'Equipo[invitaciones][]':estudiantes,'Equipo[id]':<?= $equipoid ?>,'Equipo[tipo]':2},
                    success: function(data){
                        $.notify({
                            // options
                            message: data 
                        },{
                            // settings
                            type: 'danger',
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
                return false;
            }
            
        }
        
           
        
        return true;
    });
    
    function validar(estudiante,equipo,elemento)
    {
        var invitaciones=($('input[name=\'Equipo[invitaciones][]\']:checked').length) + contador;
        
        if (invitaciones>6) {
            elemento.prop( "checked", false );
            $.notify({
                // options
                message: 'Solo se permite 5 invitaciones como máximo' 
            },{
                // settings
                type: 'danger',
                z_index: 1000000,
                placement: {
                        from: 'bottom',
                        align: 'right'
                },
            });
            
            return false;
        }
        
        $.ajax({
            url: '<?= $validarinvitacioneintegrante ?>',
            type: 'GET',
            async: true,
            data: {estudiante:estudiante,equipo:equipo},
            success: function(data){
                if(data==1)
                {
                    $.notify({
                        // options
                        message: 'Ya pertenece a un equipo ' 
                    },{
                        // settings
                        type: 'danger',
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
                else if (data==2)
                {
                    $.notify({
                        // options
                        message: 'Ya le has enviado una invitación ' 
                    },{
                        // settings
                        type: 'danger',
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
                else if (data==3)
                {
                    $.notify({
                        // options
                        message: 'Solo se permite 5 invitaciones como máximo' 
                    },{
                        // settings
                        type: 'danger',
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
                return false;
            }
        });
        return true;
    }
    
    
    
    function validardocente(docente,equipo,elemento)
    {
        var invitaciones=($('input[name=\'Equipo[invitaciones_docente][]\']:checked').length) + contadordocente;
        
        if (invitaciones>=2) {
            elemento.prop( "checked", false );
            $.notify({
                // options
                message: 'No puede realizar mas invitaciones' 
            },{
                // settings
                type: 'danger',
                z_index: 1000000,
                placement: {
                        from: 'bottom',
                        align: 'right'
                },
            });
            return false;
        }
        
        $.ajax({
            url: '<?= $validarinvitacioneintegrantedocente ?>',
            type: 'GET',
            async: true,
            data: {docente:docente,equipo:equipo},
            success: function(data){
                if(data==1)
                {
                    $.notify({
                        // options
                        message: 'Ya pertenece a un equipo ' 
                    },{
                        // settings
                        type: 'danger',
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
                else if (data==2)
                {
                    $.notify({
                        // options
                        message: 'Ya le has enviado una invitación ' 
                    },{
                        // settings
                        type: 'danger',
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
                else if (data==3)
                {
                    $.notify({
                        // options
                        message: 'Solo se permite 5 invitaciones como máximo' 
                    },{
                        // settings
                        type: 'danger',
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
                return false;
            }
        });
        return true;
    }
</script>