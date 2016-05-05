<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = $model->titulo;
$usuario=$model->usuario;
$posts = $model->getPosts($model->id);
?>

<div class="box_content contenido_seccion_equipo">
    <article class="thread-view">
        <header class="thread-head">
            <h1><?= Html::encode($this->title) ?></h1>
        </header>
    </article>
    <!-- Post Form End -->
    <?= $this->render('/foro/_posts', [
            'posts'=>$posts['posts'],
            'pageSize'=>$posts['pages']->pageSize, //??
            'pages' => $posts['pages'], //??
            'postCount' => $model->post_count //???
        ]);
    ?>
    <!-- Post Form Begin -->
    <?= $this->render('/foro-comentario/_form',[
            'model'=>$newComentario,
        ]);
    ?>
    
</div>





