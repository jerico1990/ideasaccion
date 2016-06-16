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
<style>
    .pagination>li:first-child>a, .pagination>li:first-child>span
    {
        position:relative;
        float:left;
        padding:6px 12px;
        margin-left:-1px;
        line-height:1.42857143;
        text-decoration:none;
        border:1px solid black;
        color: white;
        background-color: #1f2a69;
    }
    .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover
    {
        position:relative;
        float:left;
        padding:6px 12px;
        margin-left:-1px;
        line-height:1.42857143;
        text-decoration:none;
        border:1px solid black;
        color: white;
        background-color: #1f2a69;
    }
    .pagination>li>a, .pagination>li>span
    {
        position:relative;
        float:left;
        padding:6px 12px;
        margin-left:-1px;
        line-height:1.42857143;
        text-decoration:none;
        border:1px solid black;
        color: white;
        background-color: #1f2a69;
    }
    .pagination>li>a:focus,
    .pagination>li>a:hover,
    .pagination>li>span:focus,
    .pagination>li>span:hover
    {
        color:white;
        background-color: #1f2a69;
        border:1px solid black;
    }
    .pagination>.active>a,
    .pagination>.active>a:focus,
    .pagination>.active>a:hover,
    .pagination>.active>span,
    .pagination>.active>span:focus,
    .pagination>.active>span:hover
    {
        border:1px solid black;
        background-color: #F0EFF1;
        color:#1f2a69;
    }
</style>




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
                <div class="col-sm-12 col-md-12" >
                    <?php if($post['user_id']>=2 and $post['user_id']<=8){ ?>
                    <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #4EB3C7">
                    <?php } else{ ?>
                    <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">
                    <?php } ?>
                        <?= HtmlPurifier::process($post['contenido']) ?>
                        <div class="post-meta">
                            <?php if(\Yii::$app->user->can('monitor')){ ?>
                                <?php if($post['valoracion']!=0 && $post['valoracion']!=''){ ?>
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
                                <?php }else{ ?>
                                    <?php if($post['user_id']>=2 and $post['user_id']<=8){ ?>
                                    <div class="col-sm-12 col-md-12">
                                    </div>
                                    <?php } else{ ?>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="br-wrapper br-theme-fontawesome-stars pull-right">
                                            <select class="enable" onchange="Rating($(this).val(),<?= $post['id'] ?>)" > <!-- now hidden -->
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
                                <?php }?>
                            <?php }?>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-md-12">
                                <div class="pull-right">
                                    <?php if($post['user_id']>=2 and $post['user_id']<=8){ ?>
                                    <div class="col-sm-12 col-md-12">
                                        <?php if($post['estado']==1){ ?>
                                        <span class="glyphicon glyphicon-eye-open clase<?= $post['id'] ?>" onclick="Visible(<?= $post['id'] ?>)"></span>
                                        <?php }else{ ?>
                                        <span class="glyphicon glyphicon-eye-close clase<?= $post['id'] ?>" onclick="Visible(<?= $post['id'] ?>)"></span>
                                        <?php } ?>
                                        Comentario de <?= $post['nombres'] ?> <?= Yii::$app->formatter->asRelativeTime($post['creado_at']) ?> 
                                    </div>
                                    <?php } else{ ?>
                                        <?php if($post['estado']==1){ ?>
                                        <span class="glyphicon glyphicon-eye-open clase<?= $post['id'] ?>" onclick="Visible(<?= $post['id'] ?>)"></span>
                                        <?php }else{ ?>
                                        <span class="glyphicon glyphicon-eye-close clase<?= $post['id'] ?>" onclick="Visible(<?= $post['id'] ?>)"></span>
                                        <?php } ?>
                                        Comentario de <?= $post['nombres']." ".$post['apellido_paterno'] ?> <?= Yii::$app->formatter->asRelativeTime($post['creado_at']) ?> 
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
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
$visible= Yii::$app->getUrlManager()->createUrl('foro-comentario/visible');
$invisible= Yii::$app->getUrlManager()->createUrl('foro-comentario/invisible');
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
    
    function Visible(id) {
        $.post( "<?= $visible ?>", { "id" : id }, null, "json" )
            .done(function( data, textStatus, jqXHR ) {
                if (data==1) {
                    $(".clase"+id).removeClass('glyphicon-eye-close');
                    $(".clase"+id).addClass('glyphicon-eye-open');
                }
                else if (data==0) {
                    $(".clase"+id).removeClass('glyphicon-eye-open');
                    $(".clase"+id).addClass('glyphicon-eye-close');
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( "La solicitud a fallado: " +  textStatus);
                }
        });
    }
</script>
