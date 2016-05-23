<?php 
$registrados = $model->getRegistrados($sort->orders);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($registrados['pages']->pageSize * $_GET['page']) - $registrados['pages']->pageSize;

?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte 
</div>
<div class="box_content contenido_seccion_crear_equipo">
    
    
    
    <table class="table">
        <thead style="background: #D9D9D9">
            <th><b><?= $sort->link('department')?></b></th>
            <th><b>Total</b></th>
            <th><b>Finalizaron equipos</b></th>
            <th><b>Falta finalizar equipo</b></th>
            <th><b>Invitaciones pendientes</b></th>
            <th><b>Sin equipo</b></th>
        </thead>
        <tbody>
        <?php foreach($registrados['registrados'] as $registrado):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $registrado['department'] ?></td>
                <td><?= $registrado['total_estudiantes'] ?></td>
                <td><?= $registrado['estudiantes_finalizaron_equipo'] ?></td>
                <td><?= $registrado['estudiantes_aceptaron_invitacion'] ?></td>
                <td><?= $registrado['estudiantes_invitaciones_pendientes'] ?></td>
                <td><?= $registrado['estudiantes_huerfanos'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>    
       
        
        <div class='clearfix'></div>
        
        
    
</div>
