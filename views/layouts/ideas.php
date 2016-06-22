<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppEstandarAsset;
use app\models\Foro;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Equipo;
use app\models\Proyecto;
use app\models\Etapa;
use app\models\Estudiante;

use app\models\Invitacion;
AppEstandarAsset::register($this);
if (!\Yii::$app->user->isGuest) {
$etapa2=Etapa::find()->where('etapa=2')->one();
$etapa3=Etapa::find()->where('etapa=3')->one();
$usuario=Usuario::find()->where('id=:id',[':id'=>\Yii::$app->user->id])->one();
$estudiante=Estudiante::find()->where('id=:id',[':id'=>$usuario->estudiante_id])->one();
//$invitacion=Invitacion::find()->where('equipo_id=:equipo_id and estado=1',[':equipo_id'=>$equipo->id])->one();
$integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
if($integrante)
{
    $equipo=Equipo::find()->where('id=:id and estado=1',[':id'=>$integrante->equipo_id])->one();
    if($equipo)
    {
        
        $proyecto=Proyecto::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])->one();
    }
}
$foros=Foro::find()->orderBy('id DESC')->all();

$images=['gato_crema','perro_gris','gato_chicha','colibri','mono'];
$key=array_rand($images);
$class="";
if($key==0)
{
    $class="";
}
if($key==1)
{
    $class="";
}
if($key==2)
{
    $class="";
}
if($key==3)
{
    $class="personaje_foros";
}
if($key==4)
{
    $class="personaje_entregas";
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Page style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

    <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
     <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
   <!-- Twitter Bootstrap -->
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="<?= \Yii::$app->request->BaseUrl ?>/css/style.css" rel="stylesheet">
    
    <?php $this->head() ?>
</head>
<body class="mi_equipo">
    <?php $this->beginBody() ?>
    <div class="personaje_derecha_fixed <?= $class ?>">
        <table cellpadding="0" cellspacing="0" border="0" align="right" class="text">
            <tbody>
                <tr>
                    <td>
                        No olvides dejar tus comentarios. <br>Es requisito para seguir en el concurso.
                    </td>
                </tr>
            </tbody>
        </table>
        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/munecos/<?= $images[$key] ?>.png" class="" alt="">
    </div>
    <header>
        <div class="franja_amarilla"></div>
        <div class="content">
            <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logo">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/logo.jpg" alt="" />
                    </a>
        </div>
    </header>
    <div class="body content">
        <div class="form">
            <div class="form_login">
                <div class="content_form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="grid_box_line_blue">
                                <div class="box_head link_close">
                                    <b><?= Html::a('Cerrar sesión <b>X</b>',['login/logout']);?></b>
                                </div>
                                <div class="box_content">
                                    <div class="mis_datos">
                                        <div class="table_div">
                                            <div class="row_div">
                                                <div class="cell_div cell_image">
                                                    <div class="image_grupo" style="background-image: url(../foto_personal/<?= $usuario->avatar?>);"></div>
                                                </div>
                                                <div class="cell_div cell_info">
                                                    <div class="cell_info_content">
                                                        <b class="uppercase"><?= Html::a("".$usuario->estudiante->nombres." ".$usuario->estudiante->apellido_paterno." ".$usuario->estudiante->apellido_materno."",['usuario/configuracion']);?> </b>
                                                    </div>
                                                    <div class="line_separator"></div>
                                                    <div class="cell_info_content">
                                                        <b><?= $estudiante->institucion->denominacion ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="grid_box_line_blue">
                                <ul class="menu_lateral">
                                    <li>
                                        <?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_idea"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Ideas en acción <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>',['panel/ideas-accion'],[]);?>
                                    </li>
                                    <li>
                                        <?= Html::a('<div class="table_div">
                                                        <div class="row_div">
                                                                <div class="cell_div div_ia_icon">
                                                                        <span class="ia_icon ia_icon_team"></span>
                                                                </div>
                                                                <div class="cell_div">
                                                                        Mi equipo <span class="hide">></span>
                                                                </div>
                                                        </div>
                                                </div>',['panel/index'],[]);?>
                                    </li>
                                    <!--Mi proyecto-->
                                    <?php if($integrante && $equipo && !$proyecto && $integrante->rol==1){ ?>
                                    <li>
                                        <?= Html::a('<div class="table_div">
                                            <div class="row_div">
                                                <div class="cell_div div_ia_icon">
                                                    <span class="ia_icon ia_icon_project"></span>
                                                </div>
                                                <div class="cell_div">
                                                    Mi proyecto <span class="hide">></span>
                                                </div>
                                            </div>
                                        </div>',['proyecto/index'],[]);?>
                                    </li>
                                    <?php } elseif($integrante && $equipo && $proyecto && ($integrante->rol==1 || $integrante->rol==2)){ ?>
                                    <li>
                                        <?= Html::a('<div class="table_div">
                                            <div class="row_div">
                                                <div class="cell_div div_ia_icon">
                                                    <span class="ia_icon ia_icon_project"></span>
                                                </div>
                                                <div class="cell_div">
                                                    Mi proyecto <span class="hide">></span>
                                                </div>
                                            </div>
                                        </div>',['proyecto/actualizar'],[]);?>
                                    </li>
                                    <?php }?>
                                    <!--Fin mi proyecto-->
                                    <!--Foro-->
                                    <?php if ($integrante && $equipo && $estudiante->grado!=6){ ?>
                                    <li>
                                        <a href="#" class="sub_menu">
                                            <div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_foro"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Foros <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <ul>
                                        <?php foreach($foros as $foro): ?>
                                            <?php if($foro->id==2 || ($integrante && $foro->asunto_id==$equipo->asunto_id)){?>
                                                <?php if($foro->id==2){ ?>
                                                    <li><?= Html::a("Foro de participación estudiantil",['foro/view','id'=>$foro->id],[]);?></li>
                                                <?php }elseif($foro->asunto_id) { ?>
                                                    <li><?= Html::a("Foro de asunto público",['foro/view','id'=>$foro->id],[]);?></li>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <?php } ?>
                                    <!--Fin Foro-->
                                    <?php if($integrante && $equipo && $proyecto && ($integrante->rol==1 || $integrante->rol==2) && $estudiante->grado!=6){ ?>
                                        <?php if($integrante && $equipo && $proyecto && ($equipo->etapa==1 || $equipo->etapa==2 || $equipo->etapa==3)){?>
                                        <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Mi primera entrega <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>',['entrega/primera'],[]);?>
                                        </li>
                                        <?php }?>
                                        <?php if($integrante && $equipo && $proyecto && ($equipo->etapa==2 || $equipo->etapa==3)){?>
                                        <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Mi segunda entrega <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>',['entrega/segunda'],[]);?>
                                        </li>
                                        <?php }?>
                                        
                                        <?php if($integrante && $equipo && $proyecto && ($etapa2 || $etapa3) && ($equipo->etapa==1 || $equipo->etapa==2 ) && $estudiante->grado!=6){?>
                                        <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Aporta a otros proyectos <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>',['proyecto/buscar'],[]);?>
                                        </li>
                                        <?php }?>
                                        
                                        <?php if($integrante && $equipo && $proyecto && $etapa3 && ($equipo->etapa==2 || $equipo->etapa==3) && $estudiante->grado!=6){?>
                                        <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Votación interna <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>',['proyecto/votacion'],[]);?>
                                        </li>
                                        <?php }?>
                                        
                                    <?php } ?>
                                </ul>
                            </div>
                            <a href="#" data-toggle="modal" data-target="#myModalVideo" class="btn btn-default btn-lateral">
                                <span class="icon_play"> Video de etapas del concurso</span>
                            </a>
    
                            <a href="<?= \Yii::$app->request->BaseUrl ?>/guia_final.pdf" target="_blank" class="btn btn-default btn-lateral">
                                <span class="icon_download"> GUÍA DE ORIENTACIÓN</span>
                            </a>
                            
                            <a href="<?= \Yii::$app->request->BaseUrl ?>/esquema_rapido_del_proyecto.pdf" target="_blank" class="btn btn-default btn-lateral">
                                <span class="icon_download"> ESQUEMA DE PROYECTO</span>
                            </a>
                            <!--
                            <a href="#" class="btn btn-default btn-lateral">
                                <span class="icon_download"> GUÍA PARA EL ESTUDIANTE</span>
                            </a>-->
                        </div>
    
                        <div class="col-md-9">
                            <div class="grid_box_line_blue content_infografia">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Open source code -->
<?php $this->endBody() ?>
<script>
    $('#myModalVideo').on('hidden.bs.modal', function () {
        $("#myModalVideo iframe").attr("src", $("#myModalVideo iframe").attr("src"));
    });
    
    $(".menu_lateral li a.sub_menu").on("click", function (e) {
		e.preventDefault();
		var _a  = $(this);
		var _li = _a.parent();

		_a.toggleClass("active");
		$("ul", _li).stop(true).slideToggle();
	});
    
</script>

</body>
</html>
<?php $this->endPage() ?>
<?php } else {?>
<script>
    window.location.replace('../web/site/index')
</script>
<?php } ?>

<div class="modal fade" id="myModalVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body " id="video">
                <div  class="embed-responsive embed-responsive-16by9">
                    <iframe width="492" height="277" src="https://www.youtube.com/embed/qjS7HMqyfcg" frameborder="0" allowfullscreen></iframe>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    $('#myModalVideo').on('hide.bs.modal', function(e) {    
    var $if = $(e.delegateTarget).find('iframe');
    var src = $if.attr("src");
    $if.attr("src", '/empty.html');
    $if.attr("src", src);
});
</script>