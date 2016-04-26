<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ForoComentario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="foro-comentario-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <textarea id="foro_comentario-contenido" name="ForoComentario[contenido]" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; " ></textarea>
    
    <?= Html::submitButton(Yii::t('app', 'Comentar'), ['id'=>'btncomentar','class' => 'btn btn-raised btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $( '#btncomentar' ).click(function( event ) {
        console.log($("#foro_comentario-contenido").val());
        if (jQuery.trim($("#foro_comentario-contenido").val())=='') {
            $.notify({
                    // options
                    message: 'No ha comentado' 
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
        return true;
        
    });
</script>