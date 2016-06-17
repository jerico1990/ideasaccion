<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = $model->titulo;
$usuario=$model->usuario;
//$posts = $model->getPosts($model->id);
$posts = $model->getForo1Entrega($model->id,$seccion);

?>
    <?php $form = ActiveForm::begin([
        'action' => ['primera'],
        'method' => 'get',
    ]); ?>
    <div class="md-col-6">
        <div class="form-group label-floating field-voto-region required">
            <label>Sección</label>
            <select name="Proyecto[seccion]" class="form-control" onchange="Seccion(event)">
                <option value></option>
                <option value="1">Nombre del proyecto</option>
                <option value="2">Resumen del proyecto</option>
                <option value="3">Beneficiarios</option>
                <option value="4">Objetivos y actividades</option>
                <option value="5">Cronograma y presupuesto</option>
            </select>
        </div>
    </div>
     <?php ActiveForm::end(); ?>
    <!-- Post Form End -->
    <?= $this->render('/foro/_posts1entrega', [
            'posts'=>$posts['posts'],
            'pageSize'=>$posts['pages']->pageSize, //??
            'pages' => $posts['pages'], //??
            'postCount' => $model->post_count //???
        ]);
    ?>
    <!-- Post Form Begin -->
    <?= $this->render('/foro-comentario/_form1entrega',[
            'model'=>$newComentario,
        ]);
    ?>
   


<script>
    
    function Seccion(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>



