<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Exo+2:400,700,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
    
    <!-- Material Design fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	
	
	
   
    <!-- Bootstrap -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    
    
    <link href="http://t00rk.github.io/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
  
  <!-- Bootstrap Material Design -->
  <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/css/bootstrap-material-design.css" rel="stylesheet">
  <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/css/ripples.min.css" rel="stylesheet">

  <!-- Dropdown.js -->
  <link href="http://cdn.rawgit.com/FezVrasta/dropdown.js/master/jquery.dropdown.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/jquery.custom-scrollbar.css"/>
    

  
  
  
  
  
  
  <!-- Page style -->
  <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">
    <link href="<?= \Yii::$app->request->BaseUrl ?>/css/style_votacion.css" rel="stylesheet">
    
    
    <script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>
    <script src="<?= \Yii::$app->request->BaseUrl ?>/js/jquery.custom-scrollbar.min.js"></script>
</head>
<body>
<?php $this->beginBody() ?>
<header>
	<div class="bar_yellow"></div>

	<div class="container">
		<a href="#" class="logos"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/logo.jpg" alt=""></a>
		<a href="#" class="logos ideas"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/logo_ideas_en_accion.png" alt=""></a>
	</div>
	
</header>
<section class="vote container">
    <div class="row">
	<?= $content ?>
    </div>
    <img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_character_right.png" class="vote_character" width="270">
</section>



<?php $this->endBody() ?>

<!-- Twitter Bootstrap -->
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- Material Design for Bootstrap -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/material.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/ripples.min.js"></script>
<script>
  $.material.init();
</script>

</body>
</html>
