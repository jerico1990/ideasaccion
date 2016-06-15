<?php 
$proyectos = $model->getProyectoRegional($sort->orders);

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
            <th align="center"><b><?= $sort->link('province')?></b></th>
            <th align="center"><b><?= $sort->link('district')?></b></th>
            <th align="center"><b><?= $sort->link('province_id')?></b></th>
            <th align="center"><b><?= $sort->link('district_id')?></b></th>
        </thead>
        <tbody>
        <?php
            $a=0;
        ?>
        <?php foreach($proyectos['proyectos'] as $proyecto):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $proyecto['department'] ?></td>
                <td><?= $proyecto['province'] ?></td>
                <td><?= $proyecto['district'] ?></td>
                <td><?= $proyecto['province_id'] ?></td>
                <td><?= $proyecto['district_id'] ?></td>
            </tr>
      
        <?php endforeach; ?>
        </tbody>
    </table>    
        
        
        <div class='clearfix'></div>
            <div class="form-group pull-rigth col-md-4" >
            <?= Html::a('Descargar',['reporte/proyecto2-descargar'],['class'=>' btn btn-default']);?>
            </div>
        <div class='clearfix'></div>
        
        
    
</div>
<script>
    function Region(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>
