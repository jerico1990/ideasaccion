<?php 

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($pageSize * $_GET['page']) - $pageSize;
?>
<section class="posts">
    <div class="post-title">
        <!--<h3><?= Yii::t('app', '{postCount} comentarios', ['postCount' => $postCount]) ?></h3>-->
    </div>
    <div id="post-list">
        <?php foreach($posts as $post):
            $floor_number=$floor++; //楼层数减少
            ?>
            <div class="row post-item">
                <div class="col-sm-12">
                    <div class="post-content" >
                        <?= HtmlPurifier::process($post['contenido']) ?>
                    </div>
                    <div class="post-meta pull-right">
                        Comentario de <?= $post['nombres']." ".$post['apellido_paterno'] ?> hace <?= Yii::$app->formatter->asRelativeTime($post['creado_at']) ?>
                        <!--<span class="glyphicon glyphicon-user"></span> <?= $post['nombres']." ".$post['apellido_paterno'] ?>-->
                        <!--&nbsp;•&nbsp;
                        <span class="post-time">
                            <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['creado_at']) ?>
                        </span>
                        <a class="floor-number" id="<?= $floor_number ?>" href="#<?= $floor_number ?>">
                           <span class="badge"><?= $floor_number ?>#</span>
                        </a>-->
                    </div>
                    
                </div>
            </div>
        <?php endforeach; ?>
        <?= LinkPager::widget([
            'pagination' => $pages,
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
    </div>
</section>
