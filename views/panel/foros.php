<?php
use yii\helpers\Html;
?>


<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Foro
</div>
<div class="box_content contenido_seccion_equipo" >
    
    <div class="clearfix"></div>
    <div class="col-md-6">Asunto</div>
    <div class="col-md-2">Total de comentarios</div>
    <div class="col-md-2">Comentarios valorados</div>
    <div class="col-md-2">Falta valorar</div>
    <div class="clearfix"></div>
    <hr>
    <div class="col-md-6">Asunto de participación estudiantil</div>
    <div class="col-md-2"><?= $foroparticipacion->total_comentario ?></div>
    <div class="col-md-2"><?= $foroparticipacion->valorado ?></div>
    <div class="col-md-2"><?= Html::a($foroparticipacion->falta_valorar,['foro/viewadmin','id'=>$foroparticipacion->id],[]);?></div>
    <div class="clearfix"></div>
    <?php foreach($forospublicos as $foropublico): ?>
        <hr>
        <div class="col-md-6"><?= $foropublico->titulo ?></div>
        <div class="col-md-2"><?= $foropublico->total_comentario ?></div>
        <div class="col-md-2"><?= $foropublico->valorado ?></div>
        <div class="col-md-2"><?= Html::a($foropublico->falta_valorar,['foro/viewadmin','id'=>$foropublico->id],[]);?></div>
        <div class="clearfix"></div>
    <?php endforeach; ?>
    
    
</div>


