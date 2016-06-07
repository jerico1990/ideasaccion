<?php 
$proyectos = $model->getProyectos($sort->orders);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($proyectos['pages']->pageSize * $_GET['page']) - $proyectos['pages']->pageSize;

?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte 
</div>
<div ng-app="ideasaccion" class="box_content contenido_seccion_crear_equipo">
    <?php $form = ActiveForm::begin([
        'action' => ['proyecto'],
        'method' => 'get',
    ]); ?>
        <div class="md-col-6">
            <div class="form-group label-floating field-voto-region required">
                <select id="proyecto-region_id" class="form-control" name="Proyecto[region_id]" onchange="Region(event)">
                    <option value>Selecciona tu región</option>
                    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>" <?= ($model->region_id==$departamento->department_id)?'selected':'' ?>  ><?= $departamento->department ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    
    <table class="table">
        <thead style="background: #D9D9D9">
            <th><b>Título del proyecto</b></th>
            <th><b># de integrantes</b></th>
            <th><b>Participación en foro de “Participación estudiantil”</b></th>
            <th><b>Participación en foro de “Asuntos públicos”</b></th>
            <th><b>Proyecto finalizado</b></th>
            <th><b>Registro del video</b></th>
            <th><b>Registro de reflexión</b></th>
            <th><b>Archivo de proyecto</b></th>
        </thead>
        <tbody>
        <?php foreach($proyectos['proyectos'] as $proyecto):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $proyecto['titulo'] ?></td>
                <td><?= $proyecto['total_integrantes'] ?></td>
                <td><?= $proyecto['foro_abierto'] ?></td>
                <td><?= $proyecto['foro_asunto'] ?></td>
                <td><?= $proyecto['proyecto_finalizado'] ?></td>
                <td><?= $proyecto['video_check'] ?></td>
                <td><?= $proyecto['reflexion_check'] ?></td>
                <td><?= $proyecto['archivo_proyecto_check'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
        <?= LinkPager::widget([
            'pagination' => $proyectos['pages'],
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
        
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