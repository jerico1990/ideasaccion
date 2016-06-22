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

<?php if (Yii::$app->session->hasFlash('usuarioincorrecto')): ?>
<script>
    $.notify({
        // options
        message: 'La dirección de correo o la contraseña son incorrectos.' 
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

<?php $form = ActiveForm::begin(['options' => ['class' => 'form_login']]); ?>
    <div class="title_form">
        INGRESA A TU CUENTA
    </div>
    <div class="content_form">
        <div class="content_form">
            <div class="form-group label-floating field-loginform-username required" style="margin: 0px">
                <label class="control-label" for="loginform-username" >Correo electrónico</label>
                <input type="email" id="loginform-username" class="form-control" name="LoginForm[username]">
            </div>
            <div class="form-group label-floating field-loginform-password required" style="margin: 0px">
                <label class="control-label text-left" for="loginform-password" style="text-align:left !important">Contraseña</label>
                <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]">
            </div>
            <div class="form-group" style="margin: 0px">
               <button id="ingresar" type="submit" class="btn btn-default">Ingresar</button>
            </div>
            <?php if($tipo==2 && $resultados){ ?>
            <div class="form-group olvide_contrasena text-center" style="margin: 0px">
                <u><?= Html::a('¿Olvido su contraseña?',['site/recuperar'],['class'=>'']);?></u>
            </div>
            <div class="line_separator"></div>
            <div class="form-group no_apuntado text-center" style="margin: 0px">
            <?php //<p>¿Aún no te has apuntado?</p> ?>
            <?php //= Html::a('Regístrate',['registrar/index'],['class'=>'btn btn-default']);?>
            </div>
            <?php } ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>



<script>
    $("#ingresar").click(function(event){
        var error='';
        if($('#loginform-username').val()=='')
        {
            error=error+'Debes ingresar tu usuario <br>';
            $('.field-loginform-username').addClass('has-error');
        }
        else
        {
            $('.field-loginform-username').addClass('has-success');
            $('.field-loginform-username').removeClass('has-error');
        }
        
        if($('#loginform-username').val()!='' && !validateEmail($('#loginform-username').val()))
        {
            error=error+'Debes ingresar una dirección de correo válida <br>';
            $('.field-loginform-username').addClass('has-error');
        }
        
        
        if($('#loginform-password').val()=='' )
        {
            error=error+'Debes ingresar tu contraseña <br>';
            $('.field-loginform-password').addClass('has-error');
        }
        else
        {
            $('.field-loginform-password').addClass('has-success');
            $('.field-loginform-password').removeClass('has-error');
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
</script>