<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\web\JsExpression;
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<div class="form_login" >
    <div class="title_form">
        <img src="../img/title/registro.png" alt="" />¿Olvido su contraseña?
    </div> 
    
    <div class="content_form" >
        
        <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                <p class="text-justify">Luego de hacer clic en el botón "Enviar", se enviará un mensaje con instrucciones a su cuenta de correo registrado. Si no recibe el mensaje en su bandeja de entrada sírvase revisar la bandeja de correos no deseados</p>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="form-group label-floating field-loginform-username required">
                        <label class="control-label" for="loginform-username">Correo electrónico</label>
                        <input type="email" id="loginform-username" class="form-control" name="LoginForm[username]">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group btn_registro_submit">
                       <button id="ingresar" type="submit" class="btn btn-default">Reestablecer ></button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php 
$validaremail= Yii::$app->getUrlManager()->createUrl('registrar/validaremail');
?>
<script>
    var ural=jQuery.trim("<?= $usuario->verification_code ?>");
    
    $("#ingresar").click(function(event){
        var error='';
        if($('#loginform-username').val()=='')
        {
            error=error+'ingrese su correo electrónico <br>';
            $('.field-loginform-username').addClass('has-error');
        }
        else
        {
            $('.field-loginform-username').addClass('has-success');
            $('.field-loginform-username').removeClass('has-error');
        }
        
        if($('#loginform-username').val()!='' && !validateEmail($('#loginform-username').val()))
        {
            error=error+'el usuario debe ser un correo <br>';
            $('.field-loginform-username').addClass('has-error');
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
            $.notify({
                message: 'Se ha enviado un link temporal a tu cuenta de correo' 
            },{
                type: 'success',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
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
    
    
    $( '#loginform-username' ).focusout(function() {
        if($(this).val()!='')
        {
            
            $.ajax({
                url: '<?= $validaremail ?>',
                type: 'POST',
                async: true,
                data: {email:$(this).val()},
                success: function(data){
                    if(data==0)
                    {
                        $('.field-loginform-username').addClass('has-error');
                        $.notify({
                            // options
                            message: 'El email no existe' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                    from: 'bottom',
                                    align: 'right'
                            },
                        });
                    }
                }
            });
            
        }
        return true;
    });
    
    
    
</script>