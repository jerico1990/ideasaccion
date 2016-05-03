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
        message: 'Los datos ingresados no estan correctos' 
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
        <img src="../img/title/login.png" alt="" />
    </div>
    <div class="content_form">
        <div class="content_form">
            <div class="form-group label-floating field-loginform-username required" >
                
                <input type="email" id="loginform-username" class="form-control" name="LoginForm[username]" placeholder="Correo electrónico">
            </div>
            <div class="form-group label-floating field-loginform-password required" >
                
                <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]" placeholder="Contraseña">
            </div>
            <div class="form-group">
               <button id="ingresar" type="submit" class="btn btn-default">Ingresar</button>
            </div>
            <?php if($tipo==2 && $resultados){ ?>
            <div class="form-group olvide_contrasena text-center">
                <u><?= Html::a('¿Olvido su contraseña?',['site/recuperar'],['class'=>'']);?></u>
            </div>
            <div class="line_separator"></div>
            <div class="form-group no_apuntado text-center">
            <p>¿Aún no te has apuntado?</p>
            <?= Html::a('Regístrate',['registrar/index'],['class'=>'btn btn-default']);?>
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
            error=error+'ingrese su usuario <br>';
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
        
        
        if($('#loginform-password').val()=='' )
        {
            error=error+'ingrese su contraseña <br>';
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