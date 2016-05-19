<?php
use yii\helpers\Html;
?>

<style>
    hr{
        margin-top:10px !important;
        margin-bottom: 10px !important;
    }
</style>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Foro
</div>
<div class="box_content contenido_seccion_crear_equipo" >
    
    <div class="clearfix"></div>
    <div class="col-md-4">Asunto</div>
    <div class="col-md-2">Total</div>
    <div class="col-md-2">Valorados</div>
    <div class="col-md-2">Pendientes</div>
    <div class="col-md-2">Emitidos</div>
    <div class="clearfix"></div>
    <hr>
    <div class="col-md-4"><?= Html::a('Participación estudiantil',['foro/viewadmin','id'=>$foroparticipacion->id],[]);?>  </div>
    <div class="col-md-2"><?= $foroparticipacion->total ?></div>
    <div class="col-md-2"><?= $foroparticipacion->valorado ?></div>
    <div class="col-md-2"><?= $foroparticipacion->pendiente ?></div>
    <div class="col-md-2"><?= $foroparticipacion->emitido ?></div>
    <div class="clearfix"></div>
    <?php foreach($forospublicos as $foropublico): ?>
        <hr>
        <div class="col-md-4"><?= Html::a($foropublico->titulo,['foro/viewadmin','id'=>$foropublico->id],[]);?> </div>
        <div class="col-md-2"><?= $foropublico->total ?></div>
        <div class="col-md-2"><?= $foropublico->valorado ?></div>
        <div class="col-md-2"><?= $foropublico->pendiente ?></div>
        <div class="col-md-2"><?= $foropublico->emitido ?></div>
        <div class="clearfix"></div>
    <?php endforeach; ?>
    
    
</div>


