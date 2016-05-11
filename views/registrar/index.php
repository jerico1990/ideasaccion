<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Ubigeo ;
use yii\web\JsExpression;
use yii\widgets\Pjax;
?>
<style>
.img-responsive {
    max-width: 100%;
    height: auto;
    display: block;
}
</style>
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-strength-meter-master/docs/js/jquery-2.1.1.min.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-strength-meter-master/docs/js/bootstrap-3.2.0.min.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-strength-meter-master/docs/js/prettify.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-strength-meter-master/dist/js/bootstrap-strength-meter.js"></script>

<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-strength-meter-master/password-score/password-score.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-strength-meter-master/password-score/password-score-options.js"></script>



            <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
            <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
            <script type="text/javascript" src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class' => 'form_login']]); ?>
        <div class="title_form">
                <img src="../img/title/registro.png" alt="" />
        </div>
        <div class="content_form">
            <div class="right_photo">
                <div class="txt_upload">
                    <div class=" form-group " >
                         <input  type="file" id="registrar-foto" class="form-control  file" name="Registrar[foto]" onchange="Imagen(this)"/>
                         <?= Html::img('../foto_personal/no_disponible.jpg',['id'=>'img_destino','class'=>'text-center', 'alt'=>'Responsive image','style'=>"height: 150px;width: 120px;align:center;cursor: pointer"]) ?>
                    </div>
                </div>
            </div>
            <div class="left">
                <div class="form-group label-floating field-registrar-nombres required" style="margin-top: 15px">
                    <label for="registrar-nombres" class="control-label">Nombres</label>
                    <input style="padding-bottom: 0px;padding-top: 0px;height: 30px" type="text" onpaste="return false;" onCopy="return false" id="registrar-nombres" class="form-control texto" name="Registrar[nombres]" required/>
                </div>
                <div class="last_name">
                    <div class="form-group label-floating field-registrar-apellido_paterno required left" style="margin-top: 15px">
                        <label class="control-label" for="registrar-apellido_paterno">Apellido paterno</label>
                        <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" onpaste="return false;" onCopy="return false" id="registrar-apellido_paterno" class="form-control texto" name="Registrar[apellido_paterno]" required/>
                    </div>
                    <div class="form-group label-floating field-registrar-apellido_materno required right" style="margin-top: 15px">
                        <label class="control-label" for="registrar-apellido_materno">Apellido materno</label>
                        <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" onpaste="return false;" onCopy="return false" id="registrar-apellido_materno" class="form-control texto" name="Registrar[apellido_materno]" required/>
                    </div>
                    <div class="clear"></div>
                    <div class="form-group label-floating field-registrar-sexo required left" style="margin-top: 15px">
                        <label class="control-label" for="registrar-sexo">Sexo</label>
                        <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-sexo" class="form-control" name="Registrar[sexo]" required/>
                            <option value=""></option>
                            <option value="F">Femenino</option>
                            <option value="M">Masculino</option>
                        </select>
                    </div>
                    <div class="form-group label-floating field-registrar-dni required right" style="margin-top: 15px">
                        <label class="control-label" for="registrar-dni">DNI</label>
                        <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" onpaste="return false;" onCopy="return false" id="registrar-dni" class="form-control numerico" name="Registrar[dni]" maxlength="8">
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group label-floating field-registrar-email required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-email">Correo electrónico</label>
                        <input  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="email" onpaste="return false;" onCopy="return false" id="registrar-email" class="form-control" name="Registrar[email]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group label-floating field-registrar-celular required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-celular">Número de celular</label>
                        <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" onpaste="return false;" onCopy="return false" id="registrar-celular" class="form-control numerico" name="Registrar[celular]" maxlength="9" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group label-floating field-registrar-fecha_nac required form-control-wrapper" style="margin-top: 15px">
                        <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;color: #BDBDBD" type="date" id="registrar-fecha_nac" class="form-control label-floating" name="Registrar[fecha_nac]" placeholder="Fecha de nacimiento">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating field-registrar-password required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-password">Contraseña</label>
                        <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="password" onpaste="return false;" onCopy="return false" id="registrar-password" class="form-control" name="Registrar[password]">
                    </div>      
                </div>
                <div class="col-md-6">
                    <div class="form-group label-floating field-registrar-repassword required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-repassword">Repetir Contraseña</label>
                        <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="password" onpaste="return false;" onCopy="return false" id="registrar-repassword" class="form-control" name="Registrar[repassword]">
                    </div>
                </div>
            </div>
            <div class="row">
                <!--<div class="col-md-12" id="example-progress-bar-container"></div>-->
            </div>
             <div class="clearfix"></div>
            <div class="line_separator"></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group label-floating field-registrar-departamento required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-departamento">Departamento</label>
                        <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-departamento" class="form-control" name="Registrar[departamento]" onchange='departamento($(this).val())'>
                        <option value=""></option>
                        <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group label-floating field-registrar-provincia required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-provincia">Provincia</label>
                        <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-provincia" class="form-control" name="Registrar[provincia]" onchange='provincia($(this).val())'>
                        <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group label-floating field-registrar-distrito required " style="margin-top: 15px">
                        <label class="control-label" for="registrar-distrito">Distrito</label>
                        <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-distrito" class="form-control" name="Registrar[distrito]" onchange='distrito($(this).val())'>
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating field-registrar-institucion required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-institucion">Institución</label>
                        <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-institucion" class="form-control" name="Registrar[institucion]">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group label-floating field-registrar-grado required" style="margin-top: 15px">
                        <label class="control-label" for="registrar-grado">Grado de estudios</label>
                        <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-grado" class="form-control" name="Registrar[grado]">
                            <option value=""></option>
                            <option value="1">1er</option>
                            <option value="2">2do</option>
                            <option value="3">3ro</option>
                            <option value="4">3to</option>
                            <option value="5">5to</option>
                            <option value="6">Docente</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group btn_registro_submit">
                <button type="submit" id="registrar"  class="btn  btn-default" >
                    Regístrate >
                </button>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>

<?php
    $validardni= Yii::$app->getUrlManager()->createUrl('registrar/validardni');
    $validaremail= Yii::$app->getUrlManager()->createUrl('registrar/validaremail');
    $provincias= Yii::$app->getUrlManager()->createUrl('ubigeo/provincias');
    $distritos= Yii::$app->getUrlManager()->createUrl('ubigeo/distritos');
    $instituciones= Yii::$app->getUrlManager()->createUrl('ubigeo/instituciones');
?>

<?php if (Yii::$app->session->hasFlash('emailexistente')): ?>
<script>
    $.notify({
        // options
        message: 'El correo ya existe' 
    },{
        // settings
        type: 'danger',
        z_index: 1000000,
        placement: {
                from: 'bottom',
                align: 'right'
        },
    });

</script>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('dniexistente')): ?>
<script>
    $.notify({
        // options
        message: 'El dni ya existe' 
    },{
        // settings
        type: 'danger',
        z_index: 1000000,
        placement: {
                from: 'bottom',
                align: 'right'
        },
    });

</script>
<?php endif; ?>


<script>
    
    
    function Imagen(elemento) {
        var ext = $(elemento).val().split('.').pop().toLowerCase();
        var error='';
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            error=error+'Solo se permite subir archivos con extensiones .gif,.png,.jpg,.jpeg';
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
            $('#registrar-foto').val('');
            //$('#img_destino').val('');
            $('#img_destino').attr('src', '../foto_personal/no_disponible.jpg');
            return false;
        }
        else
        {
            mostrarImagen(elemento);
            return true;
        }
    }
    
    function mostrarImagen(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_destino').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    //$('#registrar-fecha_nac').bootstrapMaterialDatePicker({ weekStart : 0, time: false ,format : 'DD/MM/YYYY',lang : 'es' });
    $('#registrar-password').focusout(function() {
        if($(this).val()!='')
        {
            if($(this).val().length<8)
            {
                $.notify({
                    // options
                    message: 'La contraseña debe contener mínimo 8 caracteres' 
                },{
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                $('.field-registrar-password').addClass('has-error');
            }
            else
            {
                $('.field-registrar-password').addClass('has-success');
                $('.field-registrar-password').removeClass('has-error');
            }
        }
    });
    $('#registrar-password').strengthMeter('progressBar', {
        
            container: $('#example-progress-bar-container'),
            
    });
    
    $( '#registrar-dni' ).focusout(function() {
        if($(this).val()!='')
        {
            if($(this).val().length<8)
            {
                $.notify({
                    // options
                    message: 'El DNI debe contener 8 caracteres' 
                },{
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                $('.field-registrar-dni').addClass('has-error');
                $('#registrar-dni').val('');
                return false;
            }
            
            $.ajax({
                url: '<?= $validardni ?>',
                type: 'POST',
                async: true,
                data: {dni:$(this).val()},
                success: function(data){
                    if(data==1)
                    {
                        $('.field-registrar-dni').addClass('has-error');
                        $.notify({
                            // options
                            message: 'El DNI ya existe' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                    from: 'bottom',
                                    align: 'right'
                            },
                        });
                        $('#registrar-dni').val('');
                    }
                }
            });
            
        }
        return true;
    });
    
    
    $( '#registrar-email' ).focusout(function() {
        if($(this).val()!='')
        {
            
            $.ajax({
                url: '<?= $validaremail ?>',
                type: 'POST',
                async: true,
                data: {email:$(this).val()},
                success: function(data){
                    if(data==1)
                    {
                        $('.field-registrar-email').addClass('has-error');
                        $.notify({
                            // options
                            message: 'El email ya existe' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                    from: 'bottom',
                                    align: 'right'
                            },
                        });
                        $('#registrar-email').val('');
                    }
                }
            });
            
        }
        return true;
    });
    
    
    $( '#registrar-repassword' ).focusout(function() {
        if($('#registrar-repassword').val()!=$('#registrar-password').val())
        {
            $('.field-registrar-repassword').addClass('has-error');
            $.notify({
                // options
                message: 'La contraseña no es idéntica' 
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
        else
        {
            $('.field-registrar-repassword').addClass('has-success');
            $('.field-registrar-repassword').removeClass('has-error');
            return true;
        }
    });
    
    
   
    
    
    $('#registrar').click(function(){
        var error='';
        var p1=$('input[name=\'Registrar[p1][]\']:checked').length;
        var p2=$('input[type=radio]:checked').length;
        var p3=$('input[name=\'Registrar[p3][]\']:checked').length;
        var p4=$('input[name=\'Registrar[p4][]\']:checked').length;
        var p5=$('input[name=\'Registrar[p5][]\']:checked').length;
        var p6=$('input[name=\'Registrar[p6][]\']:checked').length;
        var ext = $('#registrar-foto').val().split('.').pop().toLowerCase();
        
        /*if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            error=error+'Solo se permite subir archivos con extensiones .gif,.png,.jpg,.jpeg';
        }*/

        if ($('#registrar-nombres').val()=='') {
            error=error+'Ingrese nombres <br>';
            $('.field-registrar-nombres').addClass('has-error');
        }
        else
        {
            $('.field-registrar-nombres').addClass('has-success');
            $('.field-registrar-nombres').removeClass('has-error');
        }
        
        if ($('#registrar-apellido_paterno').val()=='') {
            error=error+'Ingrese su apellido paterno <br>';
            $('.field-registrar-apellido_paterno').addClass('has-error');
        }
        else
        {
            $('.field-registrar-apellido_paterno').addClass('has-success');
            $('.field-registrar-apellido_paterno').removeClass('has-error');
        }
        
        if ($('#registrar-apellido_materno').val()=='') {
            error=error+'Ingrese su apellido materno <br>';
            $('.field-registrar-apellido_materno').addClass('has-error');
        }
        else
        {
            $('.field-registrar-apellido_materno').addClass('has-success');
            $('.field-registrar-apellido_materno').removeClass('has-error');
        }
        
        if ($('#registrar-sexo').val()=='') {
            error=error+'Ingrese sexo <br>';
            $('.field-registrar-sexo').addClass('has-error');
        }
        else
        {
            $('.field-registrar-sexo').addClass('has-success');
            $('.field-registrar-sexo').removeClass('has-error');
        }
        
        if ($('#registrar-dni').val()=='') {
            error=error+'Ingrese dni <br>';
            $('.field-registrar-dni').addClass('has-error');
        }
        else
        {
            $('.field-registrar-dni').addClass('has-success');
            $('.field-registrar-dni').removeClass('has-error');
        }
        
        if ($('#registrar-fecha_nac').val()=='') {
            error=error+'Ingrese fecha de nacimiento <br>';
            $('.field-registrar-fecha_nac').addClass('has-error');
        }
        else
        {
            $('.field-registrar-fecha_nac').addClass('has-success');
            $('.field-registrar-fecha_nac').removeClass('has-error');
        }
        
        if ($('#registrar-email').val()=='') {
            error=error+'Ingrese email <br>';
            $('.field-registrar-email').addClass('has-error');
        }
        else
        {
            $('.field-registrar-email').addClass('has-success');
            $('.field-registrar-email').removeClass('has-error');
        }
        
        if($('#registrar-email').val()!='' && !validateEmail($('#registrar-email').val()))
        {
            error=error+'el usuario debe ser un correo <br>';
            $('.field-registrar-email').addClass('has-error');
        }
        
        if ($('#registrar-celular').val()=='') {
            error=error+'Ingrese celular <br>';
            $('.field-registrar-celular').addClass('has-error');
        }
        else
        {
            $('.field-registrar-celular').addClass('has-success');
            $('.field-registrar-celular').removeClass('has-error');
        }
        
        
        if ($('#registrar-password').val()=='') {
            error=error+'Ingrese contraseña <br>';
            $('.field-registrar-password').addClass('has-error');
        }
        else
        {
            $('.field-registrar-password').addClass('has-success');
            $('.field-registrar-password').removeClass('has-error');
        }
        
        if ($('#registrar-repassword').val()=='') {
            error=error+'Ingrese repetir contraseña <br>';
            $('.field-registrar-repassword').addClass('has-error');
        }
        else
        {
            $('.field-registrar-repassword').addClass('has-success');
            $('.field-registrar-repassword').removeClass('has-error');
        }
        
        if ($('#registrar-departamento').val()=='') {
            error=error+'Ingrese departamento <br>';
            $('.field-registrar-departamento').addClass('has-error');
        }
        else
        {
            $('.field-registrar-departamento').addClass('has-success');
            $('.field-registrar-departamento').removeClass('has-error');
        }
        
        if ($('#registrar-provincia').val()=='') {
            error=error+'Ingrese provincia <br>';
            $('.field-registrar-provincia').addClass('has-error');
        }
        else
        {
            $('.field-registrar-provincia').addClass('has-success');
            $('.field-registrar-provincia').removeClass('has-error');
        }
        
        if ($('#registrar-distrito').val()=='') {
            error=error+'Ingrese distrito <br>';
            $('.field-registrar-distrito').addClass('has-error');
        }
        else
        {
            $('.field-registrar-distrito').addClass('has-success');
            $('.field-registrar-distrito').removeClass('has-error');
        }
        
        if ($('#registrar-institucion').val()=='') {
            error=error+'Ingrese institución <br>';
            $('.field-registrar-institucion').addClass('has-error');
        }
        else
        {
            $('.field-registrar-institucion').addClass('has-success');
            $('.field-registrar-institucion').removeClass('has-error');
        }
        
        if ($('#registrar-grado').val()=='') {
            error=error+'Ingrese grado <br>';
            $('.field-registrar-grado').addClass('has-error');
        }
        else
        {
            $('.field-registrar-grado').addClass('has-success');
            $('.field-registrar-grado').removeClass('has-error');
        }
        
        
        
        if($('#registrar-password').val()!='' && $('#registrar-password').val().length<8)
        {
            error=error+'La contraseña debe contener mínimo 8 caracteres <br>';
            $('.field-registrar-password').addClass('has-error');
        }
        
        if ($('#registrar-password').val()!='' && $('#registrar-repassword').val() && $('#registrar-password').val()!=$('#registrar-repassword').val()) {
            error=error+'Las contraseñas no son idénticas <br>';
            $('.field-registrar-password').addClass('has-error');
            $('.field-registrar-repassword').addClass('has-error');
        }
        
        var dni=$.ajax({
            url: '<?= $validardni ?>',
            type: 'POST',
            async: false,
            data: {dni:$('#registrar-dni').val()},
            success: function(data){
                
            }
        });
        if (dni.responseText=='1') {
            error=error+'El dni ya existe <br>';
        }
        
        var email=$.ajax({
            url: '<?= $validaremail ?>',
            type: 'POST',
            async: false,
            data: {email:$('#registrar-email').val()},
            success: function(data){
                
            }
        });
        if (email.responseText=='1') {
            error=error+'El correo electrónico ya existe <br>';
        }
        
        
        
        if (error!='')
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
    
    
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }
    
    function distrito(value) {
        $.post( "<?= $instituciones ?>?distrito="+value, function( data ) {
        $( "#registrar-institucion" ).html( data );});
    }
    
    function provincia(value) {
        $.post( "<?= $distritos ?>?provincia="+value, function( data ) {$( "#registrar-distrito" ).html( data );});
        $("#registrar-distrito").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-institucion").find("option").remove().end().append("<option value></option>").val("");
    }
    
    function departamento(value) {
        $.post( "<?= $provincias ?>?departamento="+value, function( data ) {$( "#registrar-provincia" ).html( data );});
        $("#registrar-provincia").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-distrito").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-institucion").find("option").remove().end().append("<option value></option>").val("");
    }
    
    
    $('.numerico').keypress(function (tecla) {
        var reg = /^[0-9\s]+$/;
        if(!reg.test(String.fromCharCode(tecla.which))){
            return false;
        }
        return true;
    });		
    $('.texto').keypress(function(tecla) {
        var reg = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ'_\s]+$/;
        if(!reg.test(String.fromCharCode(tecla.which))){
            return false;
        }
        return true;
    });
</script>