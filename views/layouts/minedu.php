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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href='https://fonts.googleapis.com/css?family=Exo+2:400,700,600' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/jquery.custom-scrollbar.css"/>
	

	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
    
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
		<a href="http://minedu.gob.pe/ideasenaccion/" class="logos ideas"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/logo_ideas_en_accion.png" alt=""></a>
	</div>
	
</header>
<section class="vote container">
    <div class="row">
	<?= $content ?>
    </div>
    <img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_character_right.png" class="vote_character" width="270">
</section>



<?php $this->endBody() ?>

</body>
</html>
