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
        'action' => ['proyecto-monitor','id'=>$model->id],
        'method' => 'get',
    ]); ?>
    <div class="md-col-6">
        <div class="form-group label-floating field-voto-region required">
            <label>Sección (Selecciona una sección para comentar el proyecto)</label>
            <select id="proyecto-seccion" name="Proyecto[seccion]" class="form-control" onchange="Seccion(event)">
                <option value></option>
                <option value="1" <?= ($seccion==1)?'selected':'' ?>>Nombre del proyecto</option>
                <option value="2" <?= ($seccion==2)?'selected':'' ?>>Resumen del proyecto</option>
                <option value="3" <?= ($seccion==3)?'selected':'' ?>>Beneficiarios</option>
                <option value="4" <?= ($seccion==4)?'selected':'' ?>>Objetivos y actividades</option>
                <option value="5" <?= ($seccion==5)?'selected':'' ?>>Cronograma y presupuesto</option>
            </select>
        </div>
    </div>
     <?php ActiveForm::end(); ?>
    <!-- Post Form End -->
    <?= $this->render('/foro/_posts1entregamonitor', [
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



