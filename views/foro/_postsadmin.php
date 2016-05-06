<?php 

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;

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
        <?php $i=1;?>
        <?php foreach($posts as $post):
            $floor_number=$floor++; //楼层数减少
            ?>
            <div class="row post-item">
                <div class="col-sm-12">
                    <div class="post-content" >
                        <?= HtmlPurifier::process($post['contenido']) ?>a
                    </div>
                    <div class="post-meta pull-right">
                        <?php if($post['valoracion']!=0 && $post['valoracion']!=''){ ?>
                        <div class="br-wrapper br-theme-fontawesome-stars">
                            <select class="disabled" disabled> <!-- now hidden -->
                              <option value></option>
                              <option value="1" <?= ($post['valoracion']==1)?'selected':'' ?> >1</option>
                              <option value="2" <?= ($post['valoracion']==2)?'selected':'' ?> >2</option>
                              <option value="3" <?= ($post['valoracion']==3)?'selected':'' ?> >3</option>
                              <option value="4" <?= ($post['valoracion']==4)?'selected':'' ?> >4</option>
                              <option value="5" <?= ($post['valoracion']==5)?'selected':'' ?> >5</option>
                            </select>
                        </div>
                        <?php }else{ ?>
                        <div class="br-wrapper br-theme-fontawesome-stars">
                            <select class="enable" onchange="Rating($(this).val(),<?= $post['id'] ?>)" > <!-- now hidden -->
                              <option value></option>
                              <option value="1" <?= ($post['valoracion']==1)?'selected':'' ?> >1</option>
                              <option value="2" <?= ($post['valoracion']==2)?'selected':'' ?> >2</option>
                              <option value="3" <?= ($post['valoracion']==3)?'selected':'' ?> >3</option>
                              <option value="4" <?= ($post['valoracion']==4)?'selected':'' ?> >4</option>
                              <option value="5" <?= ($post['valoracion']==5)?'selected':'' ?> >5</option>
                            </select>
                        </div>
                        <?php }?>
                        Comentario de <?= $post['nombres']." ".$post['apellido_paterno'] ?> hace <?= Yii::$app->formatter->asRelativeTime($post['creado_at']) ?>
                        
                    </div>
                    
                </div>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
        <?= LinkPager::widget([
            'pagination' => $pages,
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
    </div>
</section>
<?php
$rating= Yii::$app->getUrlManager()->createUrl('panel/rating');
?>

<script>
    $('.enable').barrating({
        theme: 'fontawesome-stars',
        
      });
    
    $('.disabled').barrating({
        theme: 'fontawesome-stars',
        hoverState: false,
        readonly: true
      });
    function Rating(rating,id) {
        
        $.ajax({
            url: '<?= $rating ?>',
            type: 'GET',
            async: true,
            data: {rating:rating,comentario_id:id},
            success: function(data){
                
            }
        });
    }
</script>
