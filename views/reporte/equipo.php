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
            <th><b>Región</b></th>
            <th><b>Total de equipos finalizados</b></th>
            <th><b>Total integrantes de equipos finalizados</b></th>
            <th><b>Total de equipos no finalizados</b></th>
            <th><b>Total integrantes de equipos no finalizados</b></th>
        </thead>
        <tbody>
        <?php foreach($equipos['equipos'] as $equipo):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $equipo['department'] ?></td>
                <td><?= $equipo['total_equipos'] ?></td>
                <td ><?= $equipo['total_alumnos'] ?></td>
                <td ><?= $equipo['total_equipos_nofinalizado'] ?></td>
                <td ><?= $equipo['total_alumnos_nofinalizado'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>    
        <?= LinkPager::widget([
            'pagination' => $equipos['pages'],
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
        
        <div class='clearfix'></div>
            <div class="form-group pull-rigth col-md-4" >
            <?= Html::a('Descargar',['reporte/region_descargar'],['class'=>' btn btn-default']);?>
            </div>
        <div class='clearfix'></div>
        
        
    
</div>
<script>
    function Region(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>
