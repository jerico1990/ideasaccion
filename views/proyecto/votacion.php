<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;
use app\models\Proyecto;
use app\models\VotacionInterna;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\ProyectoSearch */
/* @var $form yii\widgets\ActiveForm */

$votaciones = $model->getProyectoVotacion($searchModel->titulo);

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($votaciones['pages']->pageSize * $_GET['page']) - $votaciones['pages']->pageSize;
    
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="<?= \Yii::$app->request->BaseUrl ?>/css/style_votacion_regional.css" rel="stylesheet">
<?php /*
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Votación regional
</div>
<div class="box_content contenido_seccion_crear_equipo" >
    <?php if (!$votacionesinternasfinalizadasCount || $votacion_publica){ ?>
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
            'action' => ['votacion'],
            'method' => 'get',
        ]); ?>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group label-floating field-proyecto-region_id required">
                <label class="control-label" for="proyecto-region_id">Región</label>
                <select id="proyecto-region_id" class="form-control" name="ProyectoSearch[region_id]" >
                    <option value></option>
                    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>" <?= ($searchModel->region_id==$departamento->department_id)?'selected':'' ?>><?= $departamento->department ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group label-floating field-proyecto-titulo required">
                <label class="control-label" for="proyecto-titulo">Proyecto</label>
                <input type="text" name="ProyectoSearch[titulo]" class="form-control" value="<?= $searchModel->titulo?>">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-raised btn-default pull-right']) ?>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'titulo',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{like}',
                    'buttons' => [
                        'view' => function ($url,$model,$key) {
                            return Html::a('<span class="glyphicon glyphicon-edit" ></span>',['foro/view?id='.$model->foro_id],[]);
                        },//style="color:green"
                        'like' => function ($url,$model,$key) {
                            $votacioninterna=VotacionInterna::find()
                                ->where('proyecto_id=:proyecto_id and user_id=:user_id',
                                        [':proyecto_id'=>$model->id,':user_id'=>\Yii::$app->user->id])
                                ->one();
                            if($votacioninterna)
                            {
                                return Html::a('<span class="glyphicon glyphicon-thumbs-up" style="color:green"></span>',['votacion#'],['onclick'=>'Seleccionar2('.$model->id.',event)']);
                            }
                            else
                            {
                                return Html::a('<span class="glyphicon glyphicon-thumbs-up" ></span>',['votacion#'],['onclick'=>'Seleccionar2('.$model->id.',event)']);
                            }
                        }
                    ],
                ]
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <?php } ?>
    <div class="col-md-6">
        <table class="table">
            <th>Proyecto</th>
            <th>Equipo</th>
            <?php foreach($votacionesinternas as $votacioninterna){ ?>
            <tr>
                <td><?= $votacioninterna->proyecto->titulo ?></td>
                <td><?= $votacioninterna->proyecto->equipo->descripcion_equipo ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php if (!$votacionesinternasfinalizadasCount){?>
        <button type="button" id="btnfinalizarvotacion" class="btn btn-raised btn-default pull-right">Finalizar votación</button>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</div>
*/ ?>

    <div class="box_head title_content_box">
        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_send_big.png" alt="">VOTACIÓN REGIONAL
    </div>
    <div class="box_content contenido_seccion_votacion">
        <?php $form = ActiveForm::begin([
            'action' => ['votacion'],
            'method' => 'get',
        ]); ?>
        
            <div class="row content_form" style="padding:0;">
                <div class="col-xs-12 col-sm-9 col-md-9">
                    <div class="form-group field-proyecto-region_id required" style="margin: 0px;">
                        <input type="text" class="form-control" name="ProyectoSearch[titulo]">
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-default">Buscar</button>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
        <div class="content_votacion">
            <div class="row">
                <div class="col-md-8">
                    <div class="col_left_options">
                        <?php foreach($votaciones['votaciones'] as $votacion):
                            $floor_number=$floor++; //?????
                        ?>
                        <?php $voto=VotacionInterna::find()->where('user_id=:user_id and proyecto_id=:proyecto_id',
                                                                   [':user_id'=>\Yii::$app->user->id,':proyecto_id'=>$votacion["id"]])->one(); ?>
                        <div class="box_content_option" data-id="<?= $votacion["id"] ?>" data-title="<?= $votacion["titulo"] ?>">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_votation_info.jpg" class="icon_votation_info">
                            <a href="#" class="btn_votation_item <?= ($voto)?'active':''; ?>">
                                Vote
                            </a>
                            <h1 class="box_option_title">> TITULO</h1>
                            <p class="box_option_content">
                                <?= $votacion["titulo"] ?>
                            </p>
                            <h1 class="box_option_title">> EQUIPO / IIEE</h1>
                            <p class="box_option_content">
                                <?= $votacion["descripcion_equipo"] ?>
                            </p>
                        </div>
                        
                        <?php endforeach; ?>
                        
                    </div>
                </div>
    
                <div class="col-md-4 col_right_options">
                    <div class="title_col">
                        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_heart_small.jpg" alt="">
                        MI SELECCIÓN:
                    </div>
                    
                    <?php if (!$votacionesinternasfinalizadasCount){ ?>
                    <div id="v1" class="box_votation_small vt1" data-id="1" data-option="">
                        <a href="#" class="icon_delete_box">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_close_small.png">
                        </a>
                        <div class="box_votacion_number">
                            1
                        </div>
                        <div class="box_votacion_content">
                        </div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v2" class="box_votation_small vt2" data-id="2" data-option="">
                        <a href="#" class="icon_delete_box">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_close_small.png">
                        </a>
                        <div class="box_votacion_number">
                            2
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v3" class="box_votation_small vt3" data-id="3" data-option="">
                        <a href="#" class="icon_delete_box">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_close_small.png">
                        </a>
                        <div class="box_votacion_number">
                            3
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <input type="hidden" id="input_votation_1" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_2" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_3" class="input_votation_option" value="">
                    <?php } else { ?> 
                    <div id="v1" class="box_votation_small vt1" data-id="1" data-option="">
                        <div class="box_votacion_number">
                            1
                        </div>
                        <div class="box_votacion_content">
                        </div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v2" class="box_votation_small vt2" data-id="2" data-option="">
                        <div class="box_votacion_number">
                            2
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v3" class="box_votation_small vt3" data-id="3" data-option="">
                        <div class="box_votacion_number">
                            3
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <input type="hidden" id="input_votation_1" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_2" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_3" class="input_votation_option" value="">
                        
                    <?php } ?>
                    <?php if (!$votacionesinternasfinalizadasCount){ ?>
                    <button class="btn btn-default btn-send-votation">CONFIRMAR VOTACIÓN</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php $a=1; ?>
<?php foreach($votaciones['votaciones'] as $votacion): ?>
    <?php $voto=VotacionInterna::find()->where('user_id=:user_id and proyecto_id=:proyecto_id',
                                               [':user_id'=>\Yii::$app->user->id,':proyecto_id'=>$votacion["id"]])->one(); ?>
    
    
    <?php if($voto){ ?>
        <script>
            var p=$('#v'+<?= $a ?>);
            p.addClass('active');
            console.log(p);
            p.attr("data-option", "<?= $votacion["id"] ?>");
			    
                $(".box_votacion_content", p).html("<?= $votacion["titulo"] ?>");
                $("#input_votation_"+ <?= $a ?>).val("<?= $votacion["id"] ?>");
                
            
        </script>
        <?php $a++; ?>
    <?php } ?>
<?php endforeach; ?>                                     
                                                                   

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/app.js" charset="utf-8"></script>
<?php
    $votacion= Yii::$app->getUrlManager()->createUrl('proyecto/votacioninterna');
    $finalizarvotacion= Yii::$app->getUrlManager()->createUrl('proyecto/finalizarvotacioninterna');
?>
<script>
var countvotacion=<?= $votacionesinternasCount ?>;
    
function Seleccionar2(id,event) {
    event.preventDefault();
    $.ajax({
        url: '<?= $votacion ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            
            if (data==1) {
                $.notify({
                    // options
                    message: 'Tu voto ha sido registrado' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
            else if (data==2) {
                $.notify({
                    // options
                    message: 'Tu voto se ha deseleccionado' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
            else if (data==3) {
                $.notify({
                    // options
                    message: 'Solo puedes votar por 3 proyectos' 
                },{
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                }); 
            }
        }
    });
}

$('#btnfinalizarvotacion').click(function(event){
    if (countvotacion<3) {
        $.notify({
            // options
            message: 'Debes votar por 3 proyectos' 
        },{
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                    from: 'bottom',
                    align: 'right'
            },
        });
        return false;
    }
    
    
    $.ajax({
        url: '<?= $finalizarvotacion ?>',
        type: 'GET',
        async: true,
        success: function(data){
            if (data==1) {
                $.notify({
                    // options
                    message: 'Ha finalizado el proceso de votación interna' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
        }
    });
    return true;
    
});

</script>