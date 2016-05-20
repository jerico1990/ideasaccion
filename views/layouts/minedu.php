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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

    <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
	
</head>
<body>

<?php $this->beginBody() ?>
    <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PZX7QM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PZX7QM');</script>
<!-- End Google Tag Manager -->
<header>
	<div class="bar_yellow"></div>

	<div class="container">
		<a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/logo.jpg" alt=""></a>
		<a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos ideas"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/logo_ideas_en_accion.png" alt=""></a>
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

