<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Foros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$usuario=$model->usuario;
$posts = $model->getPosts($model->id);
?>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt=""> <?= ($model->id==2)?'Foro de participación estudiantil':'Foro de asunto público' ?> 
</div>
<div class="box_content contenido_seccion_equipo">
    <?php if($model->id==2){ ?>
        <p class="text-justify">Te invitamos a ser parte del foro de participación estudiantil, comentanos tu experiencia en el concurso</p>
            
    <?php }elseif($model->id>=3 && $model->id<=35) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <h3><?= $model->asunto->descripcion_corta ?></h3>
        <p class="text-justify"><?= $model->asunto->descripcion_larga ?></p>
    <?php }else{ ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>
    
    
    <?= $this->render('_posts', [
            'posts'=>$posts['posts'],
            'pageSize'=>$posts['pages']->pageSize, //分页
            'pages' => $posts['pages'], //分页
            'postCount' => $model->post_count //评论数
        ]);
    ?>
    <!--
    <article class="thread-view">
        <header class="thread-head">
            <div class="thread-info">
                <div class="pull-right">
                    <span class="glyphicon glyphicon-comment"></span> <?= $model->post_count ?>
                </div>
            </div>
        </header>
    </article>-->
    <!-- Post Form Begin -->
        <?= $this->render('/foro-comentario/_form',[
                'model'=>$newComentario,
            ]);
        ?>
    <!-- Post Form End -->
</div>
