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
use app\models\Invitacion;
AppEstandarAsset::register($this);

if (!\Yii::$app->user->isGuest) {

$etapa2=Etapa::find()->where('etapa=2')->one();
$etapa3=Etapa::find()->where('etapa=3')->one();
$usuario=Usuario::find()->where('id=:id',[':id'=>\Yii::$app->user->id])->one();
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

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
        
        

  <!-- jQuery -->
  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <!-- Material Design fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <title><?= Html::encode($this->title) ?></title>
    <!-- Bootstrap -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    
    
    <link href="http://t00rk.github.io/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
  
  <!-- Bootstrap Material Design -->
  <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/css/bootstrap-material-design.css" rel="stylesheet">
  <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/css/ripples.min.css" rel="stylesheet">

  <!-- Dropdown.js -->
  <link href="http://cdn.rawgit.com/FezVrasta/dropdown.js/master/jquery.dropdown.css" rel="stylesheet">

  <!-- Page style -->
  <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<link href="<?= \Yii::$app->request->BaseUrl ?>/css/style.css" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="mi_equipo">
    <?php $this->beginBody() ?>
    <img src="../img/personaje_derecha_mi_equipo.png" class="personaje_derecha_fixed" alt="" />
    <header>
        <div class="franja_amarilla"></div>
        <div class="content">
            <a href="#" class="logo">
                    <img src="../img/logo.jpg" alt="" />
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
                                    <?= Html::a('Cerrar sesión <b>X</b>',['login/logout']);?>
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
                                                        <b class="uppercase">Administrador</b>
                                                    </div>
                                                    <div class="line_separator"></div>
                                                    <div class="cell_info_content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="grid_box_line_blue">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<?php $this->endBody() ?>
<!-- Open source code -->
<script>
  window.page = window.location.hash || "#about";

  $(document).ready(function () {
    if (window.page != "#about") {
      $(".menu").find("li[data-target=" + window.page + "]").trigger("click");
    }
  });

  $(window).on("resize", function () {
    $("html, body").height($(window).height());
    $(".main, .menu").height($(window).height() - $(".header-panel").outerHeight());
    $(".pages").height($(window).height());
  }).trigger("resize");

  $(".menu li").click(function () {
    // Menu
    if (!$(this).data("target")) return;
    if ($(this).is(".active")) return;
    $(".menu li").not($(this)).removeClass("active");
    $(".page").not(page).removeClass("active").hide();
    window.page = $(this).data("target");
    var page = $(window.page);
    window.location.hash = window.page;
    $(this).addClass("active");


    page.show();

    var totop = setInterval(function () {
      $(".pages").animate({scrollTop: 0}, 0);
    }, 1);

    setTimeout(function () {
      page.addClass("active");
      setTimeout(function () {
        clearInterval(totop);
      }, 1000);
    }, 100);
  });

  function cleanSource(html) {
    var lines = html.split(/\n/);

    lines.shift();
    lines.splice(-1, 1);

    var indentSize = lines[0].length - lines[0].trim().length,
        re = new RegExp(" {" + indentSize + "}");

    lines = lines.map(function (line) {
      if (line.match(re)) {
        line = line.substring(indentSize);
      }

      return line;
    });

    lines = lines.join("\n");

    return lines;
  }

  $("#opensource").click(function () {
    $.get(window.location.href, function (data) {
      var html = $(data).find(window.page).html();
      html = cleanSource(html);
      $("#source-modal pre").text(html);
      $("#source-modal").modal();
    });
  });
</script>

<!-- Twitter Bootstrap -->
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- Material Design for Bootstrap -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/material.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/ripples.min.js"></script>
<script>
  $.material.init();
</script>


<!-- Dropdown.js -->
<script src="https://cdn.rawgit.com/FezVrasta/dropdown.js/master/jquery.dropdown.js"></script>
<script>
  $("#dropdown-menu select").dropdown();
</script>

</body>
</html>
<?php $this->endPage() ?>
<?php } else {?>
<script>
    window.location.replace('../web/site/index')
</script>
<?php } ?>