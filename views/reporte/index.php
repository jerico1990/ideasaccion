<?php 
$votos = $model->getVotos($model->region_id);

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
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
    ]); ?>
    <div class="form-group label-floating field-voto-region required">
        <select id="voto-region_id" class="form-control" name="Voto[region_id]" >
            <option value>Selecciona tu región</option>
            <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                <option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    
    
    <table class="table">
        <thead>
            <th>Asunto público</th>
            <th>Votos emitidos</th>
        </thead>
        <tbody>
        <?php foreach($votos['votos'] as $voto):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $voto['descripcion_cabecera'] ?></td>
                <td><?= $voto['voto_emitido'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>    
        <?= LinkPager::widget([
            'pagination' => $votos['pages'],
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
        
        <br>
        <?= Html::a('Descargar',['reporte/index_descargar','region'=>$model->region_id]);?>
        
    
</div>

