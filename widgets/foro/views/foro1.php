<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = $model->titulo;
$usuario=$model->usuario;
//$posts = $model->getPosts($model->id);
$posts = $model->getForo1Entrega($model->id);
?>

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
   





