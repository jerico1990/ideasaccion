<?php 

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
\Yii::$app->language = 'es-ES';
$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($pageSize * $_GET['page']) - $pageSize;
?>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link href="<?= \Yii::$app->request->BaseUrl ?>/ratings/dist/themes/fontawesome-stars.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/ratings/dist/jquery.barrating.min.js"></script>

<section class="posts">
    <div class="post-title">
        <!--<h3><?= Yii::t('app', '{postCount} comentarios', ['postCount' => $postCount]) ?></h3>-->
    </div>
    <div id="post-list">
        <?php foreach($posts as $post):
            $floor_number=$floor++; //楼层数减少
            ?>
            <div class="row post-item">
                <div class="col-sm-12 col-md-12">
                    <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">
                        <?= HtmlPurifier::process($post['contenido']) ?>
                        <div class="post-meta">
                            <?php if($post['user_id']>=2 and $post['user_id']<=8){ ?>
                            <div class="col-sm-12 col-md-12"></div>
                            <?php }else{ ?>
                            <div class="col-sm-12 col-md-12">
                                <div class="br-wrapper br-theme-fontawesome-stars pull-right">
                                    <select class="disabled" disabled> <!-- now hidden -->
                                      <option value></option>
                                      <option value="1" <?= ($post['valoracion']==1)?'selected':'' ?> >1</option>
                                      <option value="2" <?= ($post['valoracion']==2)?'selected':'' ?> >2</option>
                                      <option value="3" <?= ($post['valoracion']==3)?'selected':'' ?> >3</option>
                                      <option value="4" <?= ($post['valoracion']==4)?'selected':'' ?> >4</option>
                                      <option value="5" <?= ($post['valoracion']==5)?'selected':'' ?> >5</option>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-md-12">
                                <div class="pull-right">
                                    <?php if($post['user_id']>=2 and $post['user_id']<=8){ ?>
                                    <div class="col-sm-12 col-md-12">
                                        Comentario de <?= $post['nombres'] ?> <?= Yii::$app->formatter->asRelativeTime($post['creado_at']) ?> 
                                    </div>
                                    <?php } else{ ?>
                                        Comentario de <?= $post['nombres']." ".$post['apellido_paterno'] ?> <?= Yii::$app->formatter->asRelativeTime($post['creado_at']) ?> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php endforeach; ?>
        <?= LinkPager::widget([
            'pagination' => $pages,
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
    </div>
</section>

<script>
    $('.disabled').barrating({
        theme: 'fontawesome-stars',
        hoverState: false,
        readonly: true
      });
</script>

