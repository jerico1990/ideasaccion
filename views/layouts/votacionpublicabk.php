<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;

$this->title="Ideas en acción";
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
    
    <link href='https://fonts.googleapis.com/css?family=Exo+2:400,700,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/votacion/css/style.css">

    <!-- Facebook Share Tags -->
    <meta property="og:title"              content="Ideas en Acción | Minedu" />
    <meta property="og:description"        content="¡Ya elegí mis proyectos favoritos en Ideas en Acción! Vota tu también y hagamos la diferencia." />
    <meta property="og:image"              content="http://face.ideasenaccion.pe/images/share_facebook_image.png" />
</head>
<body>
<?php
$mensajes=['Conoce los proyectos finalistas de las 26 regiones.','Selecciona los 03 proyectos más pajas.','Recuerda que pueden ser de <u>DISTINTAS</u> regiones.'];
$key=array_rand($mensajes);
?>
<header>
    <div class="bar_yellow"></div>

    <div class="container">
	    <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos"><img src="<?= \Yii::$app->request->BaseUrl ?>/votacion/images/logo.jpg" alt=""></a>
	    <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos ideas"><img src="<?= \Yii::$app->request->BaseUrl ?>/votacion/images/logo_ideas_en_accion.png" alt=""></a>
    </div>
</header>
<section class="map container" style="padding-top: 21px">
    <?= $content ?>
</section>
<!-- Open source code -->


</body>
</html>
<?php $this->endPage() ?>

