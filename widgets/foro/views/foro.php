<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = $model->titulo;
$usuario=$model->usuario;
$posts = $model->posts;
?>
<div class="foro-view">
    
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
    <article class="thread-view">
        <header class="thread-head">
            <div class="thread-info">
                <div class="pull-right">
                    <span class="glyphicon glyphicon-comment"></span> <?= $model->post_count ?>
                </div>
            </div>
        </header>
    </article>
    <!-- Post Form Begin -->
    <?= $this->render('/foro-comentario/_form',[
            'model'=>$newComentario,
        ]);
    ?>
    
</div>





