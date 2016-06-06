<?php 
$equipos = $model->getEquipos($sort->orders);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($votos['pages']->pageSize * $_GET['page']) - $votos['pages']->pageSize;

?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte 
</div>
<div ng-app="ideasaccion" class="box_content contenido_seccion_crear_equipo">
    
    
    <table class="table">
        <thead style="background: #D9D9D9">
            <th><b><?= $sort->link('department')?></b></th>
            <th><b><?= $sort->link('province')?></b></th>
            <th><b><?= $sort->link('district')?></b></th>
            <th><b><?= $sort->link('latitude')?></b></th>
            <th><b><?= $sort->link('longitud')?></b></th>
        </thead>
        <tbody>
        <?php
            $a=0;
            $b=0;
            $c=0;
            $d=0;
        ?>
        <?php foreach($equipos['equipos'] as $equipo):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $equipo['department'] ?></td>
                <td><?= $equipo['province'] ?></td>
                <td ><?= $equipo['district'] ?></td>
                <td ><?= $equipo['latitude'] ?></td>
                <td ><?= $equipo['longitud'] ?></td>
            </tr>
            <?php
                $a=$a+$equipo['province'];
                $b=$b+$equipo['district'];
                $c=$c+$equipo['latitude'];
                $d=$d+$equipo['longitud'];
            ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b><?= $a ?></b></td>
                <td><b><?= $b ?></b></td>
                <td><b><?= $c ?></b></td>
                <td><b><?= $d ?></b></td>
            </tr>
        </tfoot>
    </table>    
        
        <div class='clearfix'></div>
            <div class="form-group pull-rigth col-md-4" >
            <?= Html::a('Descargar',['reporte/equipo-descargar'],['class'=>' btn btn-default']);?>
            </div>
        <div class='clearfix'></div>
        
        
    
</div>
<script>
    function Region(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>
